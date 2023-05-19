<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Services\NewsLetterSubscriptionServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class NewsLetterSubscriptionController extends Controller
{
    private string $basePath = "admin.newsLetterSubscription.";
    private string $error_message = "Oops! Something went wrong.";
    private NewsLetterSubscriptionServices $newsLetterSubscriptionServices;

    public function __construct()
    {
        $this->newsLetterSubscriptionServices = new NewsLetterSubscriptionServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_newsLetterSubscriptions = $this->newsLetterSubscriptionServices->getList();
        return view($this->basePath . "index", compact('_newsLetterSubscriptions'));
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
            $this->newsLetterSubscriptionServices->deleteNewsLetterSubscription($id);
            alert()->success('Success', 'NewsLetter Subscription has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->newsLetterSubscriptionServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
