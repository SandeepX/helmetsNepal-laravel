<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductDiscountRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Services\BrandServices;
use App\Http\Services\CategoryServices;
use App\Http\Services\ColorServices;
use App\Http\Services\ManufactureServices;
use App\Http\Services\ProductDiscountServices;
use App\Http\Services\ProductGraphicServices;
use App\Http\Services\ProductModelServices;
use App\Http\Services\ProductServices;
use App\Http\Services\SizeServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    private string $basePath = "admin.product.";
    private string $error_message = "Oops! Something went wrong.";
    private ProductServices $productServices;
    private ManufactureServices $manufactureServices;
    private ProductModelServices $productModelServices;
    private CategoryServices $categoryServices;
    private BrandServices $brandServices;
    private SizeServices $sizeServices;
    private ColorServices $colorServices;
    private ProductGraphicServices $productGraphicServices;
    private ProductDiscountServices $productDiscountServices;


    public function __construct()
    {

        $this->productServices = new ProductServices();
        $this->categoryServices = new CategoryServices();
        $this->brandServices = new BrandServices();
        $this->sizeServices = new SizeServices();
        $this->colorServices = new ColorServices();
        $this->productGraphicServices = new ProductGraphicServices();
        $this->productModelServices = new ProductModelServices();
        $this->manufactureServices = new ManufactureServices();
        $this->productDiscountServices = new ProductDiscountServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request): Application|Factory|View
    {
        $_product = $this->productServices->getList($request);
        $_category= $this->categoryServices->getSelectSubCatList();
        $_brand= $this->brandServices->getSelectList();
        return view($this->basePath . "index", compact('_product','_category','_brand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $_categorySelectList = $this->categoryServices->getParentCategoryList();
        $_brandSelectList = $this->brandServices->getSelectList();
        $_sizeSelectList = $this->sizeServices->getSelectList();
        $_colorSelectList = $this->colorServices->getSelectList();
        $_productGraphicSelectList = $this->productGraphicServices->getSelectList();
        $_productModelSelectList = $this->productModelServices->getSelectList();
        $_manufactureSelectList = $this->manufactureServices->getSelectList();
        $_product_attribute_type = ['color' => 'Color', 'size' => 'Size', 'custom' => 'Custom'];
        return view($this->basePath . "create", compact('_categorySelectList', '_brandSelectList', '_colorSelectList', '_sizeSelectList', '_product_attribute_type', '_productGraphicSelectList', '_productModelSelectList', '_manufactureSelectList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $this->productServices->saveProduct($request);
            alert()->success('Success', 'Product has been created successfully');
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View|Factory|Application|RedirectResponse
     */
    public function edit(int $id): View|Factory|Application|RedirectResponse
    {
        try {
            $_product = $this->productServices->getProductForEdit($id);
            $_categorySelectList = $this->categoryServices->getParentCategoryList();
            $_brandSelectList = $this->brandServices->getSelectList();
            $_productCategoryDetails = $this->productServices->getEditProductCategoryDetails($_product->category_id);
            $_productAttributeDetail = $this->productServices->productAttributeDetail($id);
            $_productGraphicSelectList = $this->productGraphicServices->getSelectList();
            $_productModelSelectList = $this->productModelServices->getSelectList();
            $_manufactureSelectList = $this->manufactureServices->getSelectList();
            $_product_attribute_type = ['color' => 'Color', 'size' => 'Size', 'custom' => 'Custom'];

            $_sizeSelectList = $this->sizeServices->getSelectList();
            $product_size = [];
            $product_custom = null;
            if ($_product->size_status) {
                $product_size = $_product->getProductSize()->pluck('size_id')->toArray();
            }
            if ($_product->custom_status) {
                $product_custom = $_product->getProductCustom;
            }
            return view($this->basePath . "edit", compact(
                '_product',
                '_categorySelectList',
                '_brandSelectList',
                '_productCategoryDetails',
                '_product_attribute_type',
                '_productAttributeDetail',
                '_sizeSelectList',
                '_productGraphicSelectList',
                '_productModelSelectList',
                '_manufactureSelectList',
                'product_size',
                'product_custom',
            ));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, int $id): RedirectResponse
    {
        try {
            $this->productServices->updateProduct($id, $request);
            alert()->success('Success', 'Product has been updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->productServices->deleteProduct($id);
            alert()->success('Success', 'Product has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function show(int $id): View|Factory|Application|RedirectResponse
    {
        try {
            $_product = $this->productServices->getProduct($id);
            $_productImages = $this->productServices->getProductImage($id);
            $_productColors = $this->productServices->productColorIndex($id);
            return view($this->basePath . "show", compact('_product', '_productImages', '_productColors'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }


    public function editProductImages(int $id): View|Factory|Application|RedirectResponse
    {
        try {
            $_product = $this->productServices->getProduct($id);
            $_productImages = $this->productServices->getProductImage($id);
            return view($this->basePath . "editProductImages", compact('_productImages', '_product'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function updateProductImages(Request $request, int $id): View|Factory|Application|RedirectResponse
    {
        try {
            $this->productServices->updateProductImages($request, $id);
            alert()->success('Success', 'ProductImage has been updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function deleteProductImages(int $id): array
    {
        try {
            return $this->productServices->deleteProductImages($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    public function productAttribute(string $type, int $section)
    {
        return $this->productServices->productAttribute($type, $section);
    }

    public function deleteProductAttributeImages(Request $request, int $productAttributeDetail_id): array
    {
        try {
            return $this->productServices->deleteProductAttributeImages($productAttributeDetail_id, $request);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function productSearch(Request $request): JsonResponse
    {
        $return_array = $this->productServices->productSearch($request);
        return response()->json($return_array);
    }

    public function productSearchDetails(int $product_id): JsonResponse
    {
        $return_array = $this->productServices->productSearchDetails($product_id);
        return response()->json($return_array);
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->productServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function changeApproveStatus(int $id): array
    {
        try {
            return $this->productServices->changeApproveStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function changeColorStatus(int $id): array
    {
        try {
            return $this->productServices->changeColorStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    public function productColorRow(Request $request): string
    {
        $index_value = $request->index_value;
        $_colorSelectList = $this->colorServices->getSelectList();
        return view($this->basePath . "productColorRow", compact('_colorSelectList', 'index_value'))->render();
    }


    /**
     * @throws SMException
     */
    public function productColorIndex($product_id)
    {
        try {
            $_product = $this->productServices->getProduct($product_id);
            $_productColors = $this->productServices->productColorIndex($product_id);
            return view($this->basePath . "indexProductColor", compact('_productColors', 'product_id', '_product'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");

    }

    /**
     * @param $product_id
     * @return Factory|View|Application
     */
    public function productColorCreate($product_id): Factory|View|Application
    {
        $_colorSelectList = $this->colorServices->getSelectList();
        return view($this->basePath . "productColorCreate", compact('_colorSelectList', 'product_id'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param $product_id
     * @return RedirectResponse
     */
    public function productColorSave(Request $request, $product_id): RedirectResponse
    {
        try {
            $this->productServices->productColorSave($request, $product_id);
            alert()->success('Success', 'Created successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.product.productColorIndex', ['product_id' => $product_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $productColor_id
     * @return View|Factory|Application|RedirectResponse
     */
    public function productColorEdit(int $product_id, int $productColor_id): View|Factory|Application|RedirectResponse
    {
        try {
            $_colorSelectList = $this->colorServices->getSelectList();
            $_productColor = $this->productServices->getProductColor($productColor_id);
            return view($this->basePath . "productColorEdit", compact('_colorSelectList', 'product_id', '_productColor'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.product.productColorIndex', ['product_id' => $product_id]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $productColor_id
     * @param int $product_id
     * @return RedirectResponse
     */
    public function productColorUpdate(Request $request, int $product_id, int $productColor_id): RedirectResponse
    {
        try {
            $this->productServices->updateProductColor($productColor_id, $request);
            alert()->success('Success', 'updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.product.productColorIndex', ['product_id' => $product_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $productColor_id
     * @param int $product_id
     * @return RedirectResponse
     */
    public function productColorDelete(int $product_id, int $productColor_id): RedirectResponse
    {
        try {
            $this->productServices->deleteProductColor($productColor_id);
            alert()->success('Success', 'Deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.product.productColorIndex', ['product_id' => $product_id]);
    }


    public function productDiscount($product_id)
    {
        $_productDiscounts = $this->productServices->getProductDiscount($product_id);
        return view($this->basePath . "indexProductDiscount", compact('_productDiscounts', 'product_id'));
    }

    public function productDiscountCreate($product_id)
    {
        $_product = $this->productServices->getProduct($product_id);
        return view($this->basePath . "createProductDiscount", compact('product_id' , '_product'));
    }

    public function productDiscountSave(ProductDiscountRequest $request, $product_id)
    {
        try {
            $this->productDiscountServices->saveProductDiscount($request, $product_id);
            alert()->success('Success', 'Created successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.product.productDiscount', ['product_id' => $product_id]);
    }

    /**
     * @throws SMException
     */
    public function productDiscountEdit($productDiscount_id)
    {
        $_productDiscount = $this->productDiscountServices->getProductDiscount($productDiscount_id);
        $_product = $this->productServices->getProduct($_productDiscount->product_id);
        return view($this->basePath . "editProductDiscount", compact('_productDiscount','_product'));
    }

    public function productDiscountUpdate(ProductDiscountRequest $request, $productDiscount_id)
    {
        try {
            $product_id = $this->productDiscountServices->updateProductDiscount($productDiscount_id, $request);
            alert()->success('Success', 'Updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.product.productDiscount', ['product_id' => $product_id]);
    }

    public function productDiscountDelete($productDiscount_id): RedirectResponse
    {
        try {
            $product_id = $this->productDiscountServices->deleteProductDiscount($productDiscount_id);
            alert()->success('Success', 'updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.product.productDiscount', ['product_id' => $product_id]);
    }

    public function productDiscountChangeStatus($productDiscount_id)
    {
        try {
            return $this->productDiscountServices->changeStatus($productDiscount_id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function productTag($product_id)
    {
        try {
            $_product = $this->productServices->getProduct($product_id);
            return view($this->basePath . "productTag", compact('_product'))->render();
        } catch (Throwable $e) {
            return $e;
        }
    }


    public function productTagSave(Request $request, $product_id)
    {
        try {
            $this->productServices->updateProductTag($product_id, $request);
            alert()->success('Success', 'Updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route('admin.product.index');
    }


}
