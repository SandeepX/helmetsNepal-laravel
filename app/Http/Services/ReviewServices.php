<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\ReviewRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\ArrayShape;

class ReviewServices
{
    private string $error_message = "Oops! Something went wrong.";
    private ReviewRepository $reviewRepository;
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->reviewRepository = new ReviewRepository();
        $this->productRepository = new ProductRepository();
    }

    /**
     * @throws SMException
     */
    public function saveReview($request)
    {
        $data = $request->all();
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $validator_register = $this->checkReviewValidation($request);
            if ($validator_register->fails()) {
                $validation_error = [];
                if ($validator_register->errors()->has('review')) {
                    $validation_error['error']['review'] = $validator_register->errors()->first('review');
                }
                return Helper::errorResponseAPI(message: "Invalid Validation", data: $validation_error);
            }
            $product = $this->productRepository->findActiveProductBySlug($data['product_slug']);
            if ($product) {
                $review = $this->reviewRepository->save([
                    'product_id' => $product->id,
                    'customer_id' => $_customer->id,
                    'review' => $data['review'] ?? "",
                    'review_star' => $data['review_star'],
                    'publish_status' => 0,
                ]);
                if ($review) {
                    return Helper::successResponseAPI(message: "Review saved");
                }
                return Helper::errorResponseAPI(message: $this->error_message);
            }
            throw new SMException("Product Not Found");
        }
        throw new SMException("Must login");
    }

    private function checkReviewValidation($request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'review_star' => 'required',
        ]);
    }

    public function getList()
    {
       return $this->reviewRepository->findALl();
    }
    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($review): array
    {
        $_review = $this->reviewRepository->find($review);
        if ($_review) {
            $this->reviewRepository->update($_review, ['publish_status' => !$_review->publish_status]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->error_message);
    }
}
