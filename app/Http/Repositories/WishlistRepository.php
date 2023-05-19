<?php

namespace App\Http\Repositories;

use App\Models\Customer\Wishlist;
use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;


class WishlistRepository
{

    public function __construct()
    {
        $this->wishlist = new Wishlist();
    }

    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->wishlist->create($data)->fresh();
        });
    }

    public function delete(Wishlist $wishlist): mixed
    {
        return DB::transaction(static function () use ($wishlist) {
            return $wishlist->delete();
        });
    }

    /**
     * @param $customer_id
     * @param $product_id
     * @return mixed
     */
    public function find($customer_id, $product_id): mixed
    {
        return $this->wishlist->where('product_id', $product_id)->where('customer_id', $customer_id)->first();
    }


    public function getWishlistOfCustomer($customer_id): mixed
    {
        return Product::join('wishlists', static function ($query) {
            $query->on('products.id', '=', 'wishlists.product_id');
        })
            ->where('wishlists.customer_id', $customer_id)
            ->select([
                DB::raw('products.id as id'),
                DB::raw('products.title as title'),
                DB::raw('products.slug as slug'),
                DB::raw('products.cover_image as cover_image'),
                DB::raw('products.quantity as quantity'),
            ])->get();
    }


}
