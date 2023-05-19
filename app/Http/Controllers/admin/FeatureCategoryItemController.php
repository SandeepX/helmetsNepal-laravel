<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Services\FeatureCategoryServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class FeatureCategoryItemController extends Controller
{
    private string $basePath = "admin.featureCategory.";
    private string $error_message = "Oops! Something went wrong.";
    private FeatureCategoryServices $featureCategoryServices;

    public function __construct()
    {
        $this->featureCategoryServices = new FeatureCategoryServices();
    }


    /**
     * @throws SMException
     */
    public function listFeatureCategory($feature_category): View|Factory|RedirectResponse|Application
    {
        $_feature_category = $this->featureCategoryServices->findFeatureCategoryBySlug($feature_category);

        if ($_feature_category) {
            $is_flash_sale = $_feature_category->slug === "flash-sale";
            $featureCategoryItem = $this->featureCategoryServices->listFeatureCategoryItemWithProduct($_feature_category->id);
            return view($this->basePath . "indexFeatureProduct", compact('featureCategoryItem', '_feature_category', 'is_flash_sale'));
        }
        alert()->error($this->error_message, '');
        return redirect()->back();
    }

    public function createFeatureCategory($feature_category): View|Factory|RedirectResponse|Application
    {
        $_feature_category = $this->featureCategoryServices->findFeatureCategoryBySlug($feature_category);
        if ($_feature_category) {
            $is_flash_sale = $_feature_category->slug === "flash-sale";
            return view($this->basePath . "createFeatureProduct", compact('_feature_category', 'is_flash_sale'));
        }
        alert()->error($this->error_message, '');
        return redirect()->back();
    }

    public function storeFeatureCategory($feature_category, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $this->featureCategoryServices->saveFeatureCategoryItem($request, $feature_category);
            alert()->success('Success', 'FeatureCategory has been created successfully');
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route("admin.featureCategory.listFeatureCategory", ['feature_category' => $feature_category]);
    }

    public function deleteFeatureCategoryItem($feature_category_item_id, $feature_category,): RedirectResponse
    {
        try {
            $this->featureCategoryServices->deleteFeatureCategoryItem($feature_category_item_id);
            alert()->success('Success', 'Removed successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route("admin.featureCategory.listFeatureCategory", ['feature_category' => $feature_category]);
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->featureCategoryServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    public function uploadImageFeatureCategoryItem(Request $request , $feature_category_item_id, $feature_category,): RedirectResponse
    {
        try {
            $this->featureCategoryServices->uploadImageFeatureCategoryItem($request , $feature_category_item_id);
            alert()->success('Success', 'Successfully Updated');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route("admin.featureCategory.listFeatureCategory", ['feature_category' => $feature_category]);
    }







}
