<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\BrandRepository;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\CouponRepository;
use App\Http\Repositories\ProductRepository;
use App\Models\Order\Coupon;
use Exception;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class CouponServices

{
    private string $notFoundMessage = "Sorry! Coupon not found";
    private CouponRepository $couponRepository;
    private CategoryRepository $categoryRepository;
    private BrandRepository $brandRepository;
    private ProductRepository $productRepository;


    public function __construct()
    {
        $this->couponRepository = new CouponRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->brandRepository = new BrandRepository();
        $this->productRepository = new ProductRepository();
    }

    public function getList()
    {
        return $this->couponRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveCoupon($request): void
    {
        $data = $request->all();
        $starting_date = $data['starting_date'];
        $expiry_date = $data['expiry_date'];
//        $d1 = strtotime($starting_date);
//        $d2 = strtotime($expiry_date);
//        if ($d1 >= $d2) {
//            throw new SMException("Expiry date cannot be greater than Starting date");
//        }

//        $min_amount = $data['min_amount'];
//        $max_amount = $data['max_amount'];

//        if ($min_amount >= $max_amount) {
//            throw new SMException("Coupon Minimum Value cannot be greater than Coupon Maximum Value");
//        }
        if ($request->hasFile('campaign_image')) {
            $_campaign_image = Helper::uploadFile(file: $request->campaign_image, file_folder_name: "coupon", width: 134, height: 134);
        } else {
            throw new SMException("Coupon Banner Image not found");
        }
        $this->couponRepository->save([
            'campaign_name' => $data['campaign_name'],
            'campaign_code' => $data['campaign_code'],
            'campaign_image' => $_campaign_image,
            'coupon_type' => $data['coupon_type'],
            'coupon_value' => $data['coupon_value'],
            'min_amount' => $data['min_amount'],
            'max_amount' => $data['max_amount'],
            'coupon_for' => $data['coupon_for'],
            'coupon_apply_on' => $data['coupon_apply_on'] ?? null,
            'starting_date' => $starting_date,
            'expiry_date' => $expiry_date,
            'status' => EStatus::active,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getCoupon($coupon_id)
    {
        $_coupon = $this->couponRepository->find($coupon_id);
        if ($_coupon) {
            return $_coupon;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updateCoupon($coupon_id, $request)
    {
        $data = $request->all();
        $starting_date = $data['starting_date'];
        $expiry_date = $data['expiry_date'];
        $_coupon = $this->couponRepository->find($coupon_id);
        if ($_coupon) {

            $_campaign_image = $_coupon->campaign_image;
            if ($request->hasFile('campaign_image')) {
                Helper::unlinkUploadedFile($_coupon->campaign_image, "coupon");
                $_campaign_image = Helper::uploadFile(file: $request->campaign_image, file_folder_name: "coupon", width: 134, height: 134);
            }


            return $this->couponRepository->update($_coupon, [
                'campaign_name' => $data['campaign_name'],
                'campaign_code' => $data['campaign_code'],
                'campaign_image' => $_campaign_image,
                'coupon_type' => $data['coupon_type'],
                'coupon_value' => $data['coupon_value'],
                'min_amount' => $data['min_amount'],
                'max_amount' => $data['max_amount'],
                'coupon_for' => $data['coupon_for'],
                'coupon_apply_on' => $data['coupon_apply_on'] ?? null,
                'starting_date' => $starting_date,
                'expiry_date' => $expiry_date,
                'status' => EStatus::active,
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteCoupon($coupon_id)
    {
        $_coupon = $this->couponRepository->find($coupon_id);
        if ($_coupon) {
            $this->couponRepository->update($_coupon, [
                'campaign_name' => $_coupon->campaign_name . "-(" . Helper::smTodayInYmdHis() . ")",
                'campaign_code' => $_coupon->campaign_code . "-(" . Helper::smTodayInYmdHis() . ")",
            ]);
            Helper::unlinkUploadedFile($_coupon->campaign_image, "coupon");
            return $this->couponRepository->delete($_coupon);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->couponRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_coupon = $this->couponRepository->find($user_id);
        if ($_coupon) {
            $this->couponRepository->update($_coupon, ['status' => (($_coupon->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function checkCoupon(Coupon $_coupon)
    {

        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $starting_date = strtotime($_coupon->starting_date);
            $expiry_date = strtotime($_coupon->expiry_date);

            $coupon_type = $_coupon->coupon_type;
            $coupon_value = $_coupon->coupon_value;
            $min_amount = $_coupon->min_amount;
            $max_amount = $_coupon->max_amount;
            $coupon_for = $_coupon->coupon_for;
            $coupon_apply_on = $_coupon->coupon_apply_on;

            if (strtotime(now()) < $starting_date) {
                return Helper::errorResponseAPI("Invalid Coupon");
            }
            if ($expiry_date < strtotime(now())) {
                return Helper::errorResponseAPI("Coupon expired");
            }

            $cartRepository = new CartRepository();
            $cart = $cartRepository->findByCustomerId($_customer->id);
            if ($cart) {
                $product_amount_for_discount = 0;
                $_products = $cartRepository->getCartProductList($cart->id);

                foreach ($_products as $product) {
                    $total = $product->product_price;
                    if ($coupon_for == "category") {
                        if ($product->category_id == $coupon_apply_on) {
                            $product_amount_for_discount += $total;
                        }else{
                            $cat = $this->categoryRepository->find($coupon_apply_on);
                            $child_ids = $cat->getChildCategory()->pluck('id')->toArray();
                            if(in_array($product->category_id, $child_ids)){
                                $product_amount_for_discount += $total;
                            }
                        }
                    }
                    if ($coupon_for == "brand" && $product->brand_id == $coupon_apply_on) {
                        $product_amount_for_discount += $total;
                    }

                    if ($coupon_for == "product" && $product->product_id == $coupon_apply_on) {
                        $product_amount_for_discount += $total;
                    }
                }
                $total_price = $cart->total_price;
                $final_discount_amount = 0;
                $final_amount = $cart->total_price;
                if ($product_amount_for_discount !== 0) {
                    if ($min_amount > $total_price) {
                        return Helper::errorResponseAPI("Purchase Amount must be greater than " . $min_amount);
                    }
                    if ($coupon_type === 'percentage') {

                        $discount_amount = round((($coupon_value / 100) * $product_amount_for_discount), 2);
                        if ($discount_amount < $max_amount) {
                            $final_amount = $total_price - $discount_amount;
                            $final_discount_amount = $discount_amount;
                        } else {
                            $final_amount = $total_price - $max_amount;
                            $final_discount_amount = $max_amount;
                        }
                    } else {
                        $final_amount = $total_price - $coupon_value;
                        $final_discount_amount = $coupon_value;
                    }
                } elseif($coupon_for === "all") {
                    if ($min_amount > $total_price) {
                        return Helper::errorResponseAPI("Purchase Amount must be greater than " . $min_amount);
                    }
                    if ($coupon_type === 'percentage') {

                        $discount_amount = round((($coupon_value / 100) * $total_price), 2);
                        if ($discount_amount < $max_amount) {
                            $final_amount = $total_price - $discount_amount;
                            $final_discount_amount = $discount_amount;
                        } else {
                            $final_amount = $total_price - $max_amount;
                            $final_discount_amount = $max_amount;
                        }
                    } else {
                        $final_amount = $total_price - $coupon_value;
                        $final_discount_amount = $coupon_value;
                    }
                }
                if((float)$final_discount_amount === 0.0){
                    return Helper::errorResponseAPI("Coupon cannot be applied to this products");
                }
                return Helper::successResponseAPI('Success', [
                    'status' => 'valid',
                    'sub_total' => $total_price,
                    'discount_amount' => $final_discount_amount,
                    'total' => $final_amount,
                ]);
            }
            return null;
        }
        throw new SMException("Must login");
    }

    public function getByCampaignCode($campaign_code)
    {
        return $this->couponRepository->getByCampaignCode($campaign_code);
    }

    public function getListToApplyCouponOn($couponFor)
    {
        try {
            switch ($couponFor) {
                case 'category' :
                    $categorySelect = ['id', 'name'];
                    return $this->categoryRepository->getAllActiveCategory($categorySelect);

                case 'brand' :
                    $brandSelect = ['id', 'title'];
                    return $this->brandRepository->getActiveList($brandSelect);

                case 'product' :
                    $productSelect = ['id', 'title'];
                    return $this->productRepository->getAllActiveProductList($productSelect);

                default :
                    return null;
            }
        } catch (Exception $exception) {
            throw $exception;
        }

    }


}
