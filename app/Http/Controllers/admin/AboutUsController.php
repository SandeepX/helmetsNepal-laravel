<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutUsRequest;
use App\Http\Services\AboutUsServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class AboutUsController extends Controller
{
    private string $basePath = "admin.aboutUs.";
    private string $error_message = "Oops! Something went wrong.";
    private AboutUsServices $aboutUsServices;


    public function __construct()
    {
        $this->aboutUsServices = new AboutUsServices();
    }

    public function aboutUsCreate(): Application|Factory|View
    {

        $_aboutUs = $this->aboutUsServices->getAboutUs();
        return view($this->basePath . "create", compact('_aboutUs'));
    }

    public function aboutUsSave(AboutUsRequest $request): RedirectResponse
    {
        try {
            $this->aboutUsServices->saveAboutUs($request);
            alert()->success('Success', 'About Us has been created successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "aboutUsCreate");
    }

}
