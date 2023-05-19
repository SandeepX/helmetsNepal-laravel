<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EProductStatus;
use App\Http\Enums\EStatus;
use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ColorRepository;
use App\Http\Repositories\FeatureCategoryRepository;
use App\Http\Repositories\ProductGraphicRepository;
use App\Http\Repositories\ProductModelRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\ReviewRepository;
use App\Http\Repositories\WishlistRepository;
use App\Http\Resources\ChildCategoryResource;
use App\Http\Resources\GlobalProductSearchResources;
use App\Http\Resources\ProductColorImageResource;
use App\Http\Resources\ProductImageResource;
use App\Http\Resources\ProductSearchResources;
use App\Http\Resources\ShopSelectCommonResource;
use App\Models\Customer\CustomerLog;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductColor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use JsonException;
use function PHPUnit\Framework\isEmpty;

class ProductServices
{
    private string $notFoundMessage = "Sorry! Product not found";
    private SizeServices $sizeServices;
    private CategoryRepository $categoryRepository;
    private ColorServices $colorServices;
    private ProductRepository $productRepository;


    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->sizeServices = new SizeServices();
        $this->colorServices = new ColorServices();
        $this->wishlistRepository = new WishlistRepository();
        $this->brandRepository = new BrandRepository();
    }

    public function getList($request)
    {
        $search = $request->all();
        return $this->productRepository->findALl($request->all());
    }

    /**
     * @throws SMException
     * @throws JsonException
     */
    public function saveProduct($request)
    {
        $data = $request->all();
        if ($request->hasFile('cover_image')) {
            $_cover_image = Helper::uploadFile(file: $data['cover_image'], file_folder_name: "product_cover_image", width: 255, height: 255);
        } else {
            throw new SMException("Product Cover image not found");
        }

        $_slug = Helper::getSlugSimple($data['title']);

        if ($data['main_category_id'] && ($data['parent_category_id'] ?? false) && ($data['category_id'] ?? false)) {
            $category_id = $data['category_id'];
        } elseif ($data['main_category_id'] && ($data['parent_category_id'] ?? false)) {
            $category_id = $data['parent_category_id'];
        } else {
            $category_id = $data['main_category_id'];
        }


        $_product = $this->productRepository->save([
            'title' => $data['title'],
            'sub_title' => $data['sub_title'] ?? null,
            'product_code' => $data['product_code'],
            'slug' => $_slug,
            'cover_image' => $_cover_image,
            'short_details' => $data['short_details'] ?? null,
            'details' => $data['details'] ?? null,
            'product_price' => ($data['product_price'] ?? 0.0),
            'sku' => $data['sku'] ?? null,

            'category_id' => $category_id,
            'brand_id' => ($data['brand_id'] ?? null),
            'product_graphic_id' => ($data['product_graphic_id'] ?? null),
            'product_model_id' => ($data['product_model_id'] ?? null),
            'manufacture_id' => ($data['manufacture_id'] ?? null),

            'size_status' => $data['size_status'] ?? 0,
            'color_status' => $data['color_status'] ?? 0,
            'custom_status' => $data['custom_status'] ?? 0,

            'meta_title' => $data['meta_title'] ?? null,
            'meta_keys' => $data['meta_keys'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'alternate_text' => $data['alternate_text'] ?? null,

            'quantity' => 0.0,
            'minimum_quantity' => $data['minimum_quantity'] ?? 0.0,
            'vendor_price' => $data['vendor_price'] ?? 0.0,
            'status' => EProductStatus::active,
            'is_approved' => 1,
        ]);

        $product_id = $_product->id;

        if ($data['size_status']) {
            if (empty($data['product_size_id'])) {
                throw new SMException("Product Size not selected");
            }
            foreach ($data['product_size_id'] as $size) {
                $this->productRepository->saveProductSize($product_id, $size);
            }
        }

        if ($data['custom_status']) {
            if (!$data['product_custom_attributes'] || !$data['product_custom_attribute_value']) {
                throw new SMException("Product Size not selected");
            }
            $this->productRepository->saveProductCustom($product_id, $data['product_custom_attributes'], $data['product_custom_attribute_value']);
        }

        if ($data['color_status']) {
            $_productColors = Helper::smCombine6ArrayByKeyName(
                one_array: $data['color_id_1'] ?? [],
                two_array: $data['color_id_2'] ?? [],
                three_array: $data['color_gradient'] ?? [],
                four_array: $data['product_image_color'] ?? [],
                five_array: $data['quantity'] ?? [],
                six_array: $data['barcode'] ?? [],
                byNewKeys: ['color_id_1', 'color_id_2', 'color_gradient', 'product_image_color', 'quantity', 'barcode']
            );

            foreach ($_productColors as $productColor) {
                $product_image_color = '';
                if ($productColor['product_image_color']) {
                    $product_image_color = Helper::uploadFile(file: $productColor['product_image_color'], file_folder_name: "productColor", width: 255, height: 255);
                }
                if ($productColor['color_gradient'] === 'true') {
                    $this->productRepository->saveProductColor(
                        product_id: $product_id,
                        color_id_1: $productColor['color_id_1'],
                        color_id_2: $productColor['color_id_2'],
                        color_gradient: $productColor['color_gradient'],
                        product_image_color: $product_image_color,
                        quantity: $productColor['quantity'] ?? 0,
                        barcode: $productColor['barcode'] ?? " ",
                    );
                } else {
                    $this->productRepository->saveProductColor(
                        product_id: $product_id,
                        color_id_1: $productColor['color_id_1'],
                        color_id_2: $productColor['color_id_1'],
                        color_gradient: $productColor['color_gradient'],
                        product_image_color: $product_image_color,
                        quantity: $productColor['quantity'] ?? 0,
                        barcode: $productColor['barcode'] ?? ""
                    );
                }
            }
        }

        if ($request->hasFile('product_image')) {
            $product_image = $data['product_image'];
            foreach ($product_image as $image) {
                $product_image = Helper::uploadFile(file: $image, file_folder_name: "product_image", width: 500, height: 500);
                $this->productRepository->saveProductImage($product_image, $product_id);
            }
        }
        $this->productRepository->saveProductDiscount([
            'discount_percent' => 0,
            'discount_amount' => 0,
            'discount_start_date' => Helper::smTodayInYmd(),
            'discount_end_date' => Helper::smTodayInYmd(),
            'status' => EStatus::active,
            'product_id' => $product_id,
        ]);
        return $product_id;
    }

    /**
     * @throws SMException
     */
    public function getProduct($product_id)
    {
        $_product = $this->productRepository->find($product_id);
        if ($_product) {
            $this->getProductQuantity($_product);
            return $this->productRepository->find($product_id);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function getProductForEdit($product_id)
    {
        $_product = $this->productRepository->find($product_id);
        if ($_product) {
            return $this->productRepository->find($product_id);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    private function getProductQuantity(Product $_product): void
    {
        $sku = $_product->sku;

        $is_sku = true;

        if ($sku == null || $sku == " ") {
            $is_sku = false;
        }

        if ($is_sku) {
            $url = 'http://imswebpos.com:7400/api/getItemDetail?mcode=' . trim($_product->sku) . '&companyid=IMS159-074316-90316';

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);

            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                throw new SMException("Something went wrong. We are Looking into it.  " . $error_msg);
            }
            curl_close($ch); // Close the connection

            $result = json_decode($response);
            $barcodeStocks = $result->result->barcodeStocks;
            $product_id = $_product->id;
            if(empty($barcodeStocks)){
                $productColor_resp = ProductColor::where('product_id', $product_id)->get();
                foreach ($productColor_resp as $resp){
                    $resp->update(['quantity' => 0]);
                }
            }else{
                foreach ($barcodeStocks as $barcodeStock) {
                    $resp = ProductColor::where(DB::raw('BINARY barcode'), $barcodeStock->barcode)->where('product_id', $product_id)->first();
                    if ($resp) {
                        $availableStock = ($barcodeStock->availableStock) ?? '';
                        if($availableStock > 0){
                            if ($availableStock > 2) {
                                $availableStock = $availableStock - 2;
                            }
                            if (!empty($availableStock)) {
                                $resp->update(['quantity' => $availableStock]);
                            }
                        }else{
                            $resp->update(['quantity' => 0]);
                        }
                    }
                }
            }
        }
    }

    public function updateProductTag($product_id, $request): void
    {
        $_product = $this->productRepository->find($product_id);
        $this->productRepository->update($_product, [
            'tag_type' => $request['tag_type'] ?? null,
            'tag_name' => $request['tag_name'] ?? null,
        ]);
    }

    /**
     * @throws SMException
     */
    public function updateProduct($product_id, $request)
    {
        $data = $request->all();
        $_product = $this->productRepository->find($product_id);
        if ($_product) {
            $_cover_image = $_product->cover_image;
            if ($request->hasFile('cover_image')) {
                Helper::unlinkUploadedFile($_product->cover_image, "product_cover_image");
                $_cover_image = Helper::uploadFile(file: $data['cover_image'], file_folder_name: "product_cover_image", width: 255, height: 255);
            }
            if ($_product->title == $data['title']) {
                $_slug = $_product->slug;
            } else {
                $_slug = Helper::getSlug($data['title']);
            }
            if ($data['main_category_id'] && ($data['parent_category_id'] ?? false) && ($data['category_id'] ?? false)) {
                $category_id = $data['category_id'];
            } elseif ($data['main_category_id'] && ($data['parent_category_id'] ?? false)) {
                $category_id = $data['parent_category_id'];
            } else {
                $category_id = $data['main_category_id'];
            }
            $this->productRepository->update($_product, [
                'title' => $data['title'],
                'sub_title' => $data['sub_title'],
                'product_code' => $data['product_code'],
                'slug' => $_slug,
                'cover_image' => $_cover_image,
                'short_details' => $data['short_details'] ?? null,
                'details' => $data['details'] ?? null,
                'product_price' => ($data['product_price'] ?? 0.0),
                'sku' => $data['sku'] ?? null,

                'category_id' => $category_id,
                'brand_id' => ($data['brand_id'] ?? null),
                'product_graphic_id' => ($data['product_graphic_id'] ?? null),
                'product_model_id' => ($data['product_model_id'] ?? null),
                'manufacture_id' => ($data['manufacture_id'] ?? null),

                'size_status' => $data['size_status'] ?? 0,
                'custom_status' => $data['custom_status'] ?? 0,

                'meta_title' => $data['meta_title'] ?? null,
                'meta_keys' => $data['meta_keys'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'alternate_text' => $data['alternate_text'] ?? null,
                'minimum_quantity' => $data['minimum_quantity'] ?? 0.0,
                'vendor_price' => $data['vendor_price'] ?? 0.0,
            ]);
            $_product = $this->productRepository->find($product_id);


            if ($_product->size_status) {
                if (empty($data['product_size_id'])) {
                    throw new SMException("Product Size not selected");
                }
                $productSize_array = $_product->getProductSize()->pluck('size_id')->toArray();
                foreach ($data['product_size_id'] as $product_size_id) {
                    if (!in_array($product_size_id, $productSize_array)) {
                        $this->productRepository->saveProductSize($product_id, $product_size_id);
                    }
                }
                $productSize_array = $_product->getProductSize;
                foreach ($productSize_array as $product_size_value) {
                    if (!in_array($product_size_value->size_id, $data['product_size_id'])) {
                        $product_size_value->delete();
                    }
                }
            } else {
                $_product->getProductSize()->delete();
            }
            if ($_product->custom_status) {
                if (!$data['product_custom_attributes'] || !$data['product_custom_attribute_value']) {
                    throw new SMException("Product custom not found");
                }
                if ($_product->getProductCustom) {
                    $_product->getProductCustom()->update(
                        [
                            'product_custom_attributes' => $data['product_custom_attributes'],
                            'product_custom_attribute_value' => $data['product_custom_attribute_value'],
                        ]
                    );
                } else {
                    $this->productRepository->saveProductCustom($product_id, $data['product_custom_attributes'], $data['product_custom_attribute_value']);
                }

            } else {
                $_product->getProductCustom()->delete();
            }
            return $_product;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteProduct($product_id)
    {
        $_product = $this->productRepository->find($product_id);
        if ($_product) {
            $this->productRepository->update($_product, [
                'title' => $_product->title . "-(" . Helper::smTodayInYmdHis() . ")",
                'sub_title' => $_product->sub_title . "-(" . Helper::smTodayInYmdHis() . ")",
                'product_code' => $_product->product_code . "-(" . Helper::smTodayInYmdHis() . ")",
                'slug' => $_product->slug . "-(" . Helper::smTodayInYmdHis() . ")",
            ]);
            $_product->getFeatureCategoryItem()->delete();
            return $this->productRepository->delete($_product);
        }
        throw new SMException($this->notFoundMessage);
    }

    #[ArrayShape(['main_category_id' => "mixed", 'parent_category_id' => "mixed", 'category_id' => "mixed", 'parent_cat_list' => "array|mixed", 'cat_list' => "array|mixed"])]
    public function getEditProductCategoryDetails($product_category_id): array
    {
        $parent_category_id = null;
        $category_id = null;
        $parent_cat_list = [];
        $cat_list = [];
        $cat = $this->categoryRepository->find($product_category_id);
        $parent_cat = $cat->getParentCategory;
        if ($parent_cat) {
            $main_category_id = $parent_cat->id;
            $parent_category_id = $cat->id;
            $parent_cat_list = $this->categoryRepository->getChildCategorySelectList($main_category_id);
            $main_cat = $parent_cat->getParentCategory;
            if ($main_cat) {
                $main_category_id = $main_cat->id;
                $parent_category_id = $parent_cat->id;
                $category_id = $cat->id;
                $parent_cat_list = $this->categoryRepository->getChildCategorySelectList($main_category_id);
                $cat_list = $this->categoryRepository->getChildCategorySelectList($parent_category_id);
            }
        } else {
            $main_category_id = $product_category_id;
        }
        return [
            'main_category_id' => $main_category_id,
            'parent_category_id' => $parent_category_id,
            'category_id' => $category_id,
            'parent_cat_list' => $parent_cat_list,
            'cat_list' => $cat_list,
        ];
    }

    /**
     * @throws SMException
     */
    public function updateProductImages($request, $product_id): bool
    {
        $data = $request->all();
        $_product = $this->productRepository->find($product_id);
        if ($_product) {
            if ($request->hasFile('product_image')) {
                $product_image = $data['product_image'];
                foreach ($product_image as $image) {
                    $product_image = Helper::uploadFile(file: $image, file_folder_name: "product_image", width: 500, height: 500);
                    $this->productRepository->saveProductImage($product_image, $product_id);
                }
            }
            return true;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */

    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function deleteProductImages($productImage_id): array
    {
        $_productImage = $this->productRepository->findProductImage($productImage_id);
        if ($_productImage) {
            Helper::unlinkUploadedFile($_productImage->image, "product_image");
            $this->productRepository->deleteProductImage($_productImage);
            return ['success' => true, 'message' => 'ProductImage has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function productAttribute($type, $section)
    {
        switch ($type) {
            case "color":
                $_colorSelectList = $this->colorServices->getSelectList();
                return view('admin.product.color', compact('_colorSelectList', 'section'));
                break;
            case "size":
                $_sizeSelectList = $this->sizeServices->getSelectList();
                return view('admin.product.size', compact('_sizeSelectList', 'section'));
                break;
            case "image":
                return view('admin.product.image', compact('section'));
                break;
            case "custom":
                return view('admin.product.custom', compact('section'));
                break;
            default:
                return null;
        }
    }

    public function productAttributeDetail($product_id)
    {
        return ProductAttribute::where('product_id', $product_id)->first();
    }

    /**
     * @throws SMException
     * @throws JsonException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function deleteProductAttributeImages($productAttributeDetail_id, $request): array
    {
        $_productAttribute = $this->productRepository->findProductAttribute($productAttributeDetail_id);
        if ($_productAttribute) {

            $section = (int)$request->section;
            $productAttributeImage_id = $request->productAttributeImage_id;
            if ($section) {
                $product_attributes_one_value = json_decode($_productAttribute->product_attributes_one_value ?? null);
                $key = in_array($productAttributeImage_id, $product_attributes_one_value, true);
                if (false !== $key) {
                    array_splice($product_attributes_one_value, array_search($productAttributeImage_id, $product_attributes_one_value, true), 1);
                    Helper::unlinkUploadedFile($productAttributeImage_id, "product_attribute");
                    $this->productRepository->updateProductAttribute(
                        $_productAttribute,
                        ['product_attributes_one_value' => json_encode($product_attributes_one_value, JSON_THROW_ON_ERROR)]
                    );
                    return ['success' => true, 'message' => 'Product Attribute Image has been updated successfully'];
                }
            } elseif ($section === 2) {
                $product_attributes_two_value = json_decode($_productAttribute->product_attributes_two_value ?? null);
                $key = in_array($productAttributeImage_id, $product_attributes_two_value, true);
                if (false !== $key) {
                    array_splice($product_attributes_two_value, array_search($productAttributeImage_id, $product_attributes_two_value, true), 1);
                    Helper::unlinkUploadedFile($product_attributes_two_value, "product_attribute");
                    $this->productRepository->updateProductAttribute(
                        $_productAttribute,
                        ['product_attributes_two_value' => json_encode($product_attributes_two_value, JSON_THROW_ON_ERROR)]
                    );
                    return ['success' => true, 'message' => 'Product Attribute Image has been updated successfully'];
                }
            } elseif ($section === 3) {
                $product_attributes_three_value = json_decode($_productAttribute->product_attributes_three_value ?? null);
                $key = in_array($productAttributeImage_id, $product_attributes_three_value, true);
                if (false !== $key) {
                    array_splice($product_attributes_three_value, array_search($productAttributeImage_id, $product_attributes_three_value, true), 1);
                    Helper::unlinkUploadedFile($product_attributes_three_value, "product_attribute");
                    $this->productRepository->updateProductAttribute(
                        $_productAttribute,
                        ['product_attributes_three_value' => json_encode($product_attributes_three_value, JSON_THROW_ON_ERROR)]
                    );
                    return ['success' => true, 'message' => 'Product Attribute Image has been updated successfully'];
                }
            }
            throw new SMException($this->notFoundMessage);
        }
        throw new SMException($this->notFoundMessage);

    }

    public function productSearch($request)
    {
        if ($request->has('q')) {
            $search = $request->q;
            $_products = $this->productRepository->getProductSearch($search);
            $return_array = [];
            foreach ($_products as $product) {
                $return_array[] = ['id' => $product->id, 'name' => $product->name];
            }
            return $return_array;
        }
        return [];
    }

    public function productSearchDetails($product_id)
    {
        $_product = $this->productRepository->findActiveProduct($product_id);
        if ($_product) {
            return view('admin.featureCategory.productRow', compact('_product'))->render();
        }
        return null;
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($product_id): array
    {
        $_product = $this->productRepository->find($product_id);
        if ($_product) {
            $this->productRepository->update($_product, ['status' => (($_product->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function changeApproveStatus($product_id): array
    {
        $_product = $this->productRepository->find($product_id);
        if ($_product) {
            $this->productRepository->update($_product, [
                'is_approved' => (($_product->is_approved) ? 0 : 1)
            ]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function changeColorStatus($product_id): array
    {
        $_product = $this->productRepository->find($product_id);
        if ($_product) {
            $this->productRepository->update($_product, [
                'color_status' => (($_product->color_status) ? 0 : 1)
            ]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function productColorIndex($product_id)
    {
        $_product = $this->productRepository->find($product_id);
        if ($_product) {
            return $this->productRepository->getProductColor($product_id);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function getProductColor($product_color_id)
    {
        $_productColor = $this->productRepository->findProductColor($product_color_id);
        if ($_productColor) {
            return $_productColor;
        }
        throw new SMException($this->notFoundMessage);
    }

    public function productColorSave($request, $product_id)
    {
        $data = $request->all();

        $product_image_color = '';
        if ($request->hasFile('product_image_color')) {
            $product_image_color = Helper::uploadFile(file: $data['product_image_color'], file_folder_name: "productColor", width: 255, height: 255);
        }
        if ($data['color_gradient'] === 'true') {
            return $this->productRepository->saveProductColor(
                product_id: $product_id,
                color_id_1: $data['color_id_1'],
                color_id_2: $data['color_id_2'],
                color_gradient: $data['color_gradient'],
                product_image_color: $product_image_color,
                quantity: $data['quantity'] ?? 0,
                barcode: $data['barcode']
            );
        }
        return $this->productRepository->saveProductColor(
            product_id: $product_id,
            color_id_1: $data['color_id_1'],
            color_id_2: $data['color_id_1'],
            color_gradient: $data['color_gradient'],
            product_image_color: $product_image_color,
            quantity: $data['quantity']  ?? 0,
            barcode: $data['barcode']
        );
    }

    /**
     * @throws SMException
     */
    public function updateProductColor($product_color_id, $request)
    {
        $data = $request->all();
        $_productColor = $this->productRepository->findProductColor($product_color_id);
        if ($_productColor) {
            $product_image_color = $_productColor->product_image_color;

            if ($request->hasFile('product_image_color')) {
                if ($product_image_color) {
                    Helper::unlinkUploadedFile($product_image_color, "productColor");
                }
                $product_image_color = Helper::uploadFile(file: $data['product_image_color'], file_folder_name: "productColor", width: 255, height: 255);
            }
            if ($data['color_gradient']) {
                return $this->productRepository->updateProductColor($_productColor, [
                    'color_id_1' => $data['color_id_1'],
                    'color_id_2' => $data['color_id_2'],
                    'color_gradient' => $data['color_gradient'],
                    'product_image_color' => $product_image_color,
                    'quantity' => $data['quantity']  ?? 0,
                    'barcode' => $data['barcode'],
                ]);
            }
            return $this->productRepository->updateProductColor($_productColor, [
                'color_id_1' => $data['color_id_1'],
                'color_id_2' => $data['color_id_1'],
                'color_gradient' => $data['color_gradient'],
                'product_image_color' => $product_image_color,
                'quantity' => $data['quantity']  ?? 0,
                'barcode' => $data['barcode'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteProductColor($product_color_id)
    {
        $_productColor = $this->productRepository->findProductColor($product_color_id);
        if ($_productColor) {
            Helper::unlinkUploadedFile($_productColor->product_image_color, "productColor");
            return $this->productRepository->deleteProductColor($_productColor);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getProductDiscount($product_id)
    {
        return $this->productRepository->productDiscountList($product_id);
    }

    public function getApiProductByCategory($request): array|string
    {
        $per_page = 12;
        $orderBy = 'id';
        $orderByType = 'desc';
        $_customer = Auth::guard('customerApi')->user();
        $customer_id = $_customer?->id;
        $is_helmet = false;
        if ($request->has('slug')) {
            if ($request->has('per_page')) {
                $per_page = $request->per_page;
            }

            if (!is_null($request->sort_by_price ?? null)) {
                $orderBy = 'product_price';
                $orderByType = $request->sort_by_price;
            }
            $filter = $request->all();
            $category_slug = $request->slug;
            $return_array = [];

            $_category = $this->categoryRepository->getCategoryFromSlugArray($category_slug);
            if ($_category[0]->parent_id) {
                $_category_id_array = $_category->pluck('id')->toArray();
            } else {
                $_category_id_array = $this->categoryRepository->getActiveChildCategoryList($_category[0]->id)->pluck('id')->toArray();
            }
            if ($_category_id_array) {
                $_customer = Auth::guard('customerApi')->user();

                if ($_customer) {
                    $customerLog = CustomerLog::where('customer_id', $_customer->id)->first();
                    if ($customerLog) {
                        $customerLog->update([
                            'category_id_array' => json_encode($_category_id_array)
                        ]);
                    } else {
                        CustomerLog::create([
                            'category_id_array' => json_encode($_category_id_array),
                            'customer_id' => $_customer->id
                        ]);
                    }
                }
                $_product_query = $this->productRepository->getActiveProductListByCategory(category_ids: $_category_id_array, per_page: $per_page, orderBy: $orderBy, orderByType: $orderByType, filter: $filter);
                $_products = $_product_query->paginate($per_page);

                if ($_category[0]->parent_id) {
                    $parent_category = $this->categoryRepository->find($_category[0]->parent_id);
                    $child_category = $this->categoryRepository->getActiveChildCategoryList($_category[0]->parent_id);
                } else {
                    $parent_category = $this->categoryRepository->find($_category[0]->id);
                    $child_category = $this->categoryRepository->getActiveChildCategoryList($_category[0]->id);
                }
                if (str_contains($parent_category->name, 'helmet')) {
                    $is_helmet = true;
                }
                if (str_contains($parent_category->name, 'Helmet')) {
                    $is_helmet = true;
                }
                if (str_contains($parent_category->name, 'HELMET')) {
                    $is_helmet = true;
                }
                $_helmet_category_list = [];
                if ($is_helmet) {
                    if ($_category[0]->parent_id) {
                        $child_category_2 = $this->categoryRepository->getActiveChildCategoryList_2($_category[0]->parent_id);
                    } else {
                        $child_category_2 = $this->categoryRepository->getActiveChildCategoryList_2($_category[0]->id);
                    }
                    $_helmet_category_list = ChildCategoryResource::collection($child_category_2);
                }
                $_category_list = ChildCategoryResource::collection($child_category);

                $page_details = $_products->toArray();
                $_review = new ReviewRepository();
                foreach ($_products as $_product) {
                    $product_id = $_product->id;
                    $images = [];
                    $colors = [];
                    if ($_product->color_status) {
                        $_ProductColors = $this->productRepository->getProductColorDetails($product_id);
                        foreach ($_ProductColors as $productColor) {
                            $images[] = [
                                'id' => $productColor->id ?? "",
                                'color_name' => $productColor->color_1_name ?? "",
                                'color' => [$productColor->color_1_color_value, ($productColor->color_2_color_value) ?: $productColor->color_1_color_value],
                                'image' => ($productColor->product_image_color) ? $productColor->product_image_color_path : asset('/front/uploads/product_cover_image/img-' . $productColor->cover_image),
                            ];
                            $colors[] = [$productColor->color_1_color_value, ($productColor->color_2_color_value) ?: $productColor->color_1_color_value];
                        }
                    } else {
                        $images[] = [
                            'id' => "",
                            'color_name' => "",
                            'color' => "",
                            'image' => asset('/front/uploads/product_cover_image/img-' . $_product->cover_image),
                        ];
                    }

                    $_review_list = $_review->getPublishedReviewListByProductID($product_id);
                    $wishlist_status = false;
                    if ($customer_id) {
                        $wishlist_resp = $this->wishlistRepository->find($customer_id, $product_id);
                        $wishlist_status = (bool)$wishlist_resp;
                    }
                    $_push_array = [
                        'id' => $product_id,
                        'tag' => ['type' => $_product->tag_type, 'name' => $_product->tag_name],
                        'slug' => $_product->product_slug,
                        'name' => $_product->product_title,
                        'rating' => '',
                        'reviews' => '',
                        'oldPrice' => $_product->product_price,
                        'discount_percent' => $_product->discount_percent,
                        'discount_amount' => $_product->discount_amount,
                        'newPrice' => $_product->final_product_price,
                        'colors' => $colors,
                        'images' => $images,
                        'review_star' => Helper::countReviewStar($_review_list),
                        'wishlist_status' => $wishlist_status,
                    ];
                    $return_array[] = $_push_array;
                }
                unset($page_details['data']);



                $_product_query_resp = $this->productRepository->getActiveProductListByCategoryForFilter($_category_id_array);

                $brand_ids = $_product_query_resp->pluck('brand_id')->toArray();
                $product_model_ids = $_product_query_resp->pluck('product_model_id')->toArray();

                $_brand = new BrandRepository();
                $brand = ShopSelectCommonResource::collection($_brand->getDistinctActiveList(array_unique($brand_ids)));

                $_productGraphic = new ProductGraphicRepository();
                $productGraphic = ShopSelectCommonResource::collection($_productGraphic->getActiveList());

                $_productModel = new ProductModelRepository();
                $productModel = ShopSelectCommonResource::collection($_productModel->getDistinctActiveList(array_unique($product_model_ids)));

                $_colors = new ColorRepository();
                $color = ShopSelectCommonResource::collection($_colors->getActiveList());

                return [
                    'page_details' => $page_details,
                    'product' => $return_array,
                    'brand' => $brand,
                    'productGraphic' => $productGraphic,
                    'productModel' => $productModel,
                    'category' => $_category_list,
                    'helmet_category_list' => $_helmet_category_list,
                    'color' => $color,
                    'is_helmet' => $is_helmet,
                ];
            }
        }
        return "Product Not Found";
    }

    public function getApiProductByBrand($request): array|string
    {
        $per_page = 20;
        $orderBy = 'id';
        $orderByType = 'desc';
        $_customer = Auth::guard('customerApi')->user();
        $customer_id = $_customer?->id;
        $brand_id = $request->brand_id;

        $_brand = $this->brandRepository->find($brand_id);
        if ($_brand) {
            $return_array = [];
            $_products = $this->productRepository->getActiveProductListByBrand(brand_id: $brand_id, per_page: $per_page, orderBy: $orderBy, orderByType: $orderByType);

            $page_details = $_products->toArray();
            $_review = new ReviewRepository();
            foreach ($_products as $_product) {
                $product_id = $_product->id;
                $images = [];
                $colors = [];
                if ($_product->color_status) {
                    $_ProductColors = $this->productRepository->getProductColorDetails($product_id);
                    foreach ($_ProductColors as $productColor) {
                        $images[] = [
                            'id' => $productColor->id ?? "",
                            'color_name' => $productColor->color_1_name ?? "",
                            'color' => [$productColor->color_1_color_value, ($productColor->color_2_color_value) ?: $productColor->color_1_color_value],
                            'image' => ($productColor->product_image_color) ? $productColor->product_image_color_path : asset('/front/uploads/product_cover_image/img-' . $productColor->cover_image),
                        ];
                        $colors[] = [$productColor->color_1_color_value, ($productColor->color_2_color_value) ?: $productColor->color_1_color_value];
                    }
                } else {
                    $images[] = [
                        'id' => "",
                        'color_name' => "",
                        'color' => "",
                        'image' => asset('/front/uploads/product_cover_image/img-' . $_product->cover_image),
                    ];
                }

                $_review_list = $_review->getPublishedReviewListByProductID($product_id);
                $wishlist_status = false;
                if ($customer_id) {
                    $wishlist_resp = $this->wishlistRepository->find($customer_id, $product_id);
                    $wishlist_status = (bool)$wishlist_resp;
                }
                $_push_array = [
                    'id' => $product_id,
                    'tag' => ['type' => $_product->tag_type, 'name' => $_product->tag_name],
                    'slug' => $_product->product_slug,
                    'name' => $_product->product_title,
                    'rating' => '',
                    'reviews' => '',
                    'oldPrice' => $_product->product_price,
                    'discount_percent' => $_product->discount_percent,
                    'discount_amount' => $_product->discount_amount,
                    'newPrice' => $_product->final_product_price,
                    'colors' => $colors,
                    'images' => $images,
                    'review_star' => Helper::countReviewStar($_review_list),
                    'wishlist_status' => $wishlist_status,
                ];
                $return_array[] = $_push_array;
            }
            unset($page_details['data']);

            $_brand = new BrandRepository();
            $brand = ShopSelectCommonResource::collection($_brand->getActiveList());
            return [
                'page_details' => $page_details,
                'product' => $return_array,
                'brand' => $brand,
            ];
        }
        return "Product Not Found";
    }

    /**
     * @throws SMException
     */
    public function getProductDetailBySlug($product_slug): array
    {
        $_product = $this->productRepository->findActiveProductBySlug($product_slug);

        if ($_product) {
            $this->getProductQuantity($_product);
            $_customer = Auth::guard('customerApi')->user();
            $customer_id = $_customer?->id;
            $product_id = $_product->id;
            $_product = $this->productRepository->find($product_id);
            $_productSize = $this->productRepository->getProductSizeDetails($product_id)->toArray();
            $_productImage = $this->productRepository->getProductImage($product_id);
            $wishlist_status = false;
            if ($customer_id) {
                $wishlist_resp = $this->wishlistRepository->find($customer_id, $product_id);
                $wishlist_status = (bool)$wishlist_resp;
            }

            $images = [];
            $colors = [];

            if ($_product->color_status) {
                $_ProductColors = $this->productRepository->getProductColorDetails($product_id);
                foreach ($_ProductColors as $productColor) {
                    $images[] = [
                        'id' => $productColor->id ?? "",
                        'color_name' => $productColor->color_1_name ?? "",
                        'color' => [$productColor->color_1_color_value, ($productColor->color_2_color_value) ?: $productColor->color_1_color_value],
                        'image' => ($productColor->product_image_color) ? $productColor->product_image_color_path : asset('/front/uploads/product_cover_image/img-' . $productColor->cover_image),
                        'quantity' => $productColor->quantity ?? "",
                    ];
                    $colors[] = [$productColor->color_1_color_value, ($productColor->color_2_color_value) ?: $productColor->color_1_color_value];
                }
            } else {
                $images[] = [
                    'id' => "",
                    'color_name' => "",
                    'color' => "",
                    'image' => asset('/front/uploads/product_cover_image/img-' . $_product->cover_image),
                    'quantity' => 0
                ];
            }

            return [
                'id' => $_product->id,
                'slug' => $_product->slug,
                'title' => $_product->title,
                'sub_title' => $_product->sub_title,
                'product_cover_image_path' => $_product->product_cover_image_path,

                'short_details' => $_product->short_details,
                'details' => $_product->details,

                'old_product_price' => $_product->product_price,
                'final_product_price' => $_product->final_product_price,
                'tag' => ['type' => $_product->tag_type, 'name' => $_product->tag_name],

                'category_name' => $_product->getCategory->name,
                'brand_name' => ($_product->getBrand?->title ?? "-"),
                'brand_image' => ($_product->getBrand?->image_path ?? null),
                'product_graphic' => ($_product->getProductGraphic?->name ?? null),
                'product_model' => ($_product->getProductModel?->name ?? null),
                'manufacture' => ($_product->geManufacture?->name ?? null),

                'meta_title' => ($_product->meta_title ?? null),
                'meta_keys' => ($_product->meta_keys ?? null),
                'meta_description' => ($_product->meta_description ?? null),
                'alternate_text' => ($_product->alternate_text ?? null),

                'product_quantity' => (round($_product->quantity ?? 0)),
                'vendor_price' => ($_product->vendor_price ?? null),
                'vendor_minimum_quantity' => (round($_product->minimum_quantity ?? 0)),

                'discount_percent' => ($_product->product_discount['discount_percent']),
                'discount_amount' => ($_product->product_discount['discount_amount']),

                'colors' => $colors,
                'color_product_images' => $images,
                'size' => $_productSize,
                'product_images' => ProductImageResource::collection($_productImage),
                'wishlist_status' => $wishlist_status,
            ];

        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function getProductImage($product_id)
    {
        $_productImage = $this->productRepository->getProductImage($product_id);
        if ($_productImage) {
            return $_productImage;
        }
        throw new SMException($this->notFoundMessage);
    }

    public function productSearchApi($request): array|AnonymousResourceCollection
    {
        $title = $request->title ?? null;
        $min_amount = $request->min ?? 0;
        $max_amount = $request->max ?? null;
        $paginate = $request->paginate ?? 20;
        $category_slug = $request->category_slug ?? '';

        $_category = $this->categoryRepository->getCategoryFromSlug($category_slug);
        if ($_category) {
            if ($_category->parent_id) {
                $_products = $this->productRepository->searchProductByCategory(category_id: $_category->id, paginate: $paginate, title: $title, min_amount: $min_amount, max_amount: $max_amount);
            } else {
                $category_query = $_category->getChildCategory();
                $_category = $category_query->pluck('id')->toArray();
                $_products = $this->productRepository->searchProductByParentCategory(category: $_category, paginate: $paginate, title: $title, min_amount: $min_amount, max_amount: $max_amount);
            }
        } else {
            $_products = $this->productRepository->searchProductByTitle(paginate: $paginate, title: $title, min_amount: $min_amount, max_amount: $max_amount);
        }
        if ($_products->count() === 0) {
            return ['Product Not Found'];
        }
        return ProductSearchResources::collection($_products);
    }

    public function globalProductSearch($request): AnonymousResourceCollection
    {
        $title = $request->title ?? null;
        $paginate = 10;
        $_products = $this->productRepository->searchProductByTitle(paginate: $paginate, title: $title);
        return GlobalProductSearchResources::collection($_products);
    }

    public function getApiRecommendedItem(): array|string
    {
        $return_array = [];
        $_customer = Auth::guard('customerApi')->user();
        $featureCategoryRepository = new FeatureCategoryRepository();
        $return_array['section_sub_title'] = "";
        if ($_customer) {
            $customer_id = $_customer->id;
            $customerLog = CustomerLog::where('customer_id', $customer_id)->first();
            if ($customerLog) {
                $featureCategoryItems = $featureCategoryRepository->getRecommendedItemList(json_decode($customerLog->category_id_array));
            } else {
                $featureCategoryItems = $featureCategoryRepository->getRandomFeatureItemList();
            }
        } else {
            $_customer = Auth::guard('customerApi')->user();
            $customer_id = $_customer?->id;

            $featureCategoryItems = $featureCategoryRepository->getRandomFeatureItemList();
        }
        $_review = new ReviewRepository();
        foreach ($featureCategoryItems as $featureCategoryItem) {
            $product_id = $featureCategoryItem->product_id;

            $images = [];
            $colors = [];
            if ($featureCategoryItem->color_status) {
                $_ProductColors = $this->productRepository->getProductColorDetails($product_id);
                foreach ($_ProductColors as $productColor) {
                    $images[] = [
                        'id' => $productColor->id ?? "",
                        'color_name' => $productColor->color_1_name ?? "",
                        'color' => [$productColor->color_1_color_value, ($productColor->color_2_color_value) ?: $productColor->color_1_color_value],
                        'image' => ($productColor->product_image_color) ? $productColor->product_image_color_path : asset('/front/uploads/product_cover_image/img-' . $productColor->cover_image),
                    ];
                    $colors[] = [$productColor->color_1_color_value, ($productColor->color_2_color_value) ?: $productColor->color_1_color_value];
                }
            } else {
                $images[] = [
                    'id' => "",
                    'color_name' => "",
                    'color' => "",
                    'image' => asset('/front/uploads/product_cover_image/img-' . $featureCategoryItem->cover_image),
                ];
            }

            $_review_list = $_review->getPublishedReviewListByProductID($featureCategoryItem->product_id);
            $wishlist_status = false;
            if ($customer_id) {
                $wishlist_resp = $this->wishlistRepository->find($customer_id, $product_id);
                $wishlist_status = (bool)$wishlist_resp;
            }
            $_push_array = [
                'id' => $featureCategoryItem->product_id,
                'tag' => ['type' => ($featureCategoryItem->tag_type ?? ""), 'name' => ($featureCategoryItem->tag_name ?? "")],
                'slug' => $featureCategoryItem->product_slug,
                'name' => $featureCategoryItem->product_title,
                'rating' => '',
                'reviews' => '',
                'oldPrice' => $featureCategoryItem->product_price,
                'discount_percent' => $featureCategoryItem->discount_percent,
                'discount_amount' => $featureCategoryItem->discount_amount,
                'newPrice' => $featureCategoryItem->final_product_price,
                'colors' => $colors,
                'images' => $images,
                'review_star' => Helper::countReviewStar($_review_list),
                'wishlist_status' => $wishlist_status,
            ];

            $return_array['product'][] = $_push_array;
        }
        return $return_array;
    }


}
