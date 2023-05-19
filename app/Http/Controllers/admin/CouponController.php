<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\SMException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Services\CouponServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Throwable;

class CouponController extends Controller
{
    private string $basePath = "admin.coupon.";
    private string $error_message = "Oops! Something went wrong.";
    private CouponServices $couponServices;

    public function __construct()
    {
        $this->couponServices = new CouponServices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $_coupons = $this->couponServices->getList();
        return view($this->basePath . "index", compact('_coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $couponTypes = ['flat' => 'Flat Discount', 'percentage' => 'Percentage'];
        return view($this->basePath . "create", compact('couponTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CouponRequest $request
     * @return RedirectResponse
     * @throws SMException
     */
    public function store(CouponRequest $request): RedirectResponse
    {
        try {
            $this->couponServices->saveCoupon($request);
            alert()->success('Success', 'Coupon has been created successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
            return redirect()->route($this->basePath . "create");
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
            $_coupon = $this->couponServices->getCoupon($id);
            $couponTypes = ['flat' => 'Flat Discount', 'percentage' => 'Percentage'];
            return view($this->basePath . "edit", compact('_coupon', 'couponTypes'));
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CouponRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CouponRequest $request, int $id): RedirectResponse
    {
        try {
            $this->couponServices->updateCoupon($id, $request);
            alert()->success('Success', 'Coupon has been updated successfully');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
            return redirect()->back();
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
            $this->couponServices->deleteCoupon($id);
            alert()->success('Success', 'Coupon has been deleted');
        } catch (Throwable $e) {
            alert()->error($this->error_message, $e->getMessage());
        }
        return redirect()->route($this->basePath . "index");
    }

    public function changeStatus(int $id): array
    {
        try {
            return $this->couponServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getListToApplyCoupon($couponFor): JsonResponse|RedirectResponse
    {
        try {
            $detail = $this->couponServices->getListToApplyCouponOn($couponFor);
            return response()->json([
                'data' => $detail
            ]);
        } catch (Throwable $exception) {
            return redirect()->back()->with('danger', $exception->getMessage());
        }
    }
}
