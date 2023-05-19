<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ReviewServices;
use Throwable;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->reviewServices =  new ReviewServices();
    }


    public function index()
    {
        $_review = $this->reviewServices->getList();
        return view("admin.review.index", compact('_review'));
    }
    public function changeStatus(int $id): array
    {
        try {
            return $this->reviewServices->changeStatus($id);
        } catch (Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
