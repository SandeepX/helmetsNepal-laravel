<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureCategoryRequest;
use App\Http\Services\FeatureCategoryServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class FeatureCategoryController extends Controller
{
    private string $basePath = "admin.featureCategory.";
    private string $routePath = "admin.feature-category.";
    private string $error_message = "Oops! Something went wrong.";
    private FeatureCategoryServices $featureCategoryServices;

    public function __construct()
    {
        $this->featureCategoryServices = new FeatureCategoryServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_featureCategory = $this->featureCategoryServices->getList();
        return view($this->basePath . "index", compact('_featureCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view($this->basePath . "create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeatureCategoryRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(FeatureCategoryRequest $request): RedirectResponse
    {
        try {
            $this->featureCategoryServices->saveFeatureCategory($request);
            alert()->success('Success', 'FeatureCategory has been created successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->routePath . "index");
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
            $_featureCategory = $this->featureCategoryServices->getFeatureCategory($id);
            return view($this->basePath . "edit", compact('_featureCategory'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->routePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FeatureCategoryRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $this->featureCategoryServices->updateFeatureCategoryDetail($id, $request);
            alert()->success('Success', 'Feature Category has been updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->routePath . "index");
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
            $this->featureCategoryServices->deleteFeatureCategory($id);
            alert()->success('Success', 'FeatureCategory has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->routePath . "index");
    }


    public function updateFlashSale($feature_category, Request $request): View|Factory|Application|RedirectResponse
    {
        {
            try {
                DB::beginTransaction();
                $_feature_category = $this->featureCategoryServices->findFeatureCategoryBySlug($feature_category);
                $is_flash_sale = $_feature_category->slug === "flash-sale";
                if ($is_flash_sale) {
                    $sale_start_date = $request->sale_start_date;
                    $sale_end_date = $request->sale_end_date;
                    $this->featureCategoryServices->updateFlashSale($_feature_category->id, $sale_start_date, $sale_end_date);
                    alert()->success('Success', 'FeatureCategory has been created successfully');
                } else {
                    alert()->error($this->error_message, '');
                }
                DB::commit();
            } catch (Throwable $e) {
                DB::rollBack();
                alert()->error($this->error_message, $e->getMessage());
            }
            return redirect()->route("admin.featureCategory.listFeatureCategory", ['feature_category' => $feature_category]);
        }
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->featureCategoryServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function uploadImageFeatureCategoryItem($feature_category, Request $request)
    {

    }
}
