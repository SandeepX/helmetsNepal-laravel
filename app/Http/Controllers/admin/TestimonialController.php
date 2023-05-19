<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Http\Services\TestimonialServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

class TestimonialController extends Controller


{
    private string $basePath = "admin.testimonial.";
    private string $error_message = "Oops! Something went wrong.";
    private TestimonialServices $testimonialServices;

    public function __construct()
    {
        $this->testimonialServices = new TestimonialServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_testimonials = $this->testimonialServices->getList();
        return view($this->basePath . "index", compact('_testimonials'));
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
     * @param TestimonialRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(TestimonialRequest $request): RedirectResponse
    {
        try {
            $this->testimonialServices->savePeopleExperience($request);
            alert()->success('Success', 'Testimonial has been created successfully');
        } catch (Throwable $e) {
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
            $_testimonial = $this->testimonialServices->getPeopleExperience($id);
            return view($this->basePath . "edit", compact('_testimonial'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TestimonialRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(TestimonialRequest $request, int $id): RedirectResponse
    {
        try {
            $this->testimonialServices->updatePeopleExperience($id, $request);
            alert()->success('Success', 'Testimonial has been updated successfully');
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
            $this->testimonialServices->deletePeopleExperience($id);
            alert()->success('Success', 'Testimonial has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->testimonialServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
