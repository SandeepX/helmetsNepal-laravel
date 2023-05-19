<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\YoutubeTypeRequest;
use App\Http\Services\SlidingContentServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class SlidingContentController extends Controller
{
    private string $basePath = "admin.slidingContent.";
    private string $error_message = "Oops! Something went wrong.";
    private SlidingContentServices $slidingContentServices;


    public function __construct()
    {
        $this->slidingContentServices = new SlidingContentServices();
    }

    public function indexImageType(): Application|Factory|View
    {
        $_slidingContents = $this->slidingContentServices->getListSlidingContentImageType();
        return view($this->basePath . "indexImageType", compact('_slidingContents'));
    }

    public function createImageType(): View|Factory|Application
    {
        return view($this->basePath . "createImageType");
    }

    public function storeImageType(Request $request): RedirectResponse
    {
        try {
            $this->slidingContentServices->saveSlidingContentImageType($request);
            alert()->success('Success', 'SlidingContent has been created successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "indexImageType");
    }

    public function editImageType(int $id): View|Factory|Application|RedirectResponse
    {
        try {
            $_slidingContent = $this->slidingContentServices->getSlidingContentImageType($id);
            return view($this->basePath . "editImageType", compact('_slidingContent'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "indexImageType");
    }

    public function updateImageType(Request $request, int $id): RedirectResponse
    {
        try {
            $this->slidingContentServices->updateSlidingContentImageType($id, $request);
            alert()->success('Success', 'SlidingContent has been updated successfully');
        } catch (Throwable $e) {

            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "indexImageType");
    }

    public function destroyImageType(int $id): RedirectResponse
    {
        try {
            $this->slidingContentServices->deleteSlidingContent($id);
            alert()->success('Success', 'SlidingContent has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "indexImageType");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->slidingContentServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function indexYoutubeType(): Application|Factory|View
    {
        $_slidingContents = $this->slidingContentServices->getListSlidingContentYoutubeType();
        return view($this->basePath . "indexYoutubeType", compact('_slidingContents'));
    }

    public function createYoutubeType(): View|Factory|Application
    {
        return view($this->basePath . "createYoutubeType");
    }

    public function storeYoutubeType(YoutubeTypeRequest $request): RedirectResponse
    {
        try {
            $this->slidingContentServices->saveSlidingContentYoutubeType($request);
            alert()->success('Success', 'SlidingContent has been created successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "indexYoutubeType");
    }

    public function editYoutubeType(int $id): View|Factory|Application|RedirectResponse
    {
        try {
            $_slidingContent = $this->slidingContentServices->getSlidingContentYoutubeType($id);
            return view($this->basePath . "editYoutubeType", compact('_slidingContent'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "indexYoutubeType");
    }

    public function updateYoutubeType(YoutubeTypeRequest $request, int $id): RedirectResponse
    {
        try {
            $this->slidingContentServices->updateSlidingContentYoutubeType($id, $request);
            alert()->success('Success', 'SlidingContent has been updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "indexYoutubeType");
    }

    public function destroyYoutubeType(int $id): RedirectResponse
    {
        try {
            $this->slidingContentServices->deleteSlidingContent($id);
            alert()->success('Success', 'SlidingContent has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "indexYoutubeType");
    }


}
