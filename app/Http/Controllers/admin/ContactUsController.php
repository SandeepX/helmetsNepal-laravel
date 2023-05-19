<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Services\ContactUsServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ContactUsController extends Controller

{
    private string $basePath = "admin.contactUs.";
    private string $error_message = "Oops! Something went wrong.";
    private ContactUsServices $contactUsServices;

    public function __construct()
    {
        $this->contactUsServices = new ContactUsServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_contacts = $this->contactUsServices->getList();
        return view($this->basePath . "index", compact('_contacts'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws SMException
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->contactUsServices->deleteContactUs($id);
            alert()->success('Success', 'Contact Us has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->contactUsServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function show(int $id)
    {
        try {
            $contact_us = $this->contactUsServices->getContactUs($id);
            return view($this->basePath . "show", compact('contact_us'));
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
