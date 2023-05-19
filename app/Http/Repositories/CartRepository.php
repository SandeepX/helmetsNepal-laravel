<?php

namespace App\Http\Repositories;


use App\Http\Enums\EProductStatus;
use App\Models\Cart\Cart;
use App\Models\Cart\CartProduct;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\Cart\_IH_CartProduct_C;

class CartRepository
{
    public function __construct()
    {
        $this->cart = new Cart();
        $this->cartProduct = new CartProduct();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->cart->create($data)->fresh();
        });
    }

    /**
     * @param $data
     * @return mixed
     */
    public function saveCartProduct($data): mixed
    {
        return DB::transaction(function () use ($data) {
            return $this->cartProduct->create($data)->fresh();
        });
    }

    /**
     * @param CartProduct $cartProduct
     * @return mixed
     */
    public function deleteCartProduct(CartProduct $cartProduct): mixed
    {
        return DB::transaction(static function () use ($cartProduct) {
            return $cartProduct->delete();
        });
    }

    /**
     * @param Cart $cart
     * @return mixed
     */
    public function delete(Cart $cart): mixed
    {
        return DB::transaction(static function () use ($cart) {
            return $cart->delete();
        });
    }

    /**
     * @param $cartProduct
     * @param $data
     * @return mixed
     */
    public function updateCartProduct($cartProduct, $data): mixed
    {
        return DB::transaction(static function () use ($cartProduct, $data) {
            return $cartProduct->update($data);
        });
    }

    /**
     * @param $cart
     * @param $data
     * @return mixed
     */
    public function update($cart, $data): mixed
    {
        return DB::transaction(static function () use ($cart, $data) {
            return $cart->update($data);
        });
    }

    public function findByCustomerId($customer_id)
    {
        return $this->cart->where('customer_id', $customer_id)->orderBy('id', 'desc')->first();
    }

    public function findByCartNumber($cart_number)
    {
        return $this->cart->where('cart_number', $cart_number)->first();
    }

    public function findCartProduct($cart_product_id, $product_id, $cart_id)
    {
        return $this->cartProduct->where('id', $cart_product_id)->where('cart_id', $cart_id)->where('product_id', $product_id)->first();
    }

    public function findCartProductWithCartID($cart_id, $product_id)
    {
        return $this->cartProduct->where('cart_id', $cart_id)->where('product_id', $product_id)->first();
    }

    public function findCartProductWithCartIDQuery($cart_id, $product_id)
    {
        return $this->cartProduct->where('cart_id', $cart_id)->where('product_id', $product_id);
    }

    public function findCartProductWithCartIDAndSizeId($cart_id, $product_id, $size_id)
    {
        return $this->cartProduct->where('cart_id', $cart_id)->where('product_id', $product_id)->where('product_size_id', $size_id)->first();
    }

    public function findCartProductWithCartIDAndColorId($cart_id, $product_id, $color_id)
    {
        return $this->cartProduct->where('cart_id', $cart_id)->where('product_id', $product_id)->where('product_color_id', $color_id)->first();
    }

    public function findCartProductWithAll($cart_id, $product_id, $color_id, $size_id)
    {
        return $this->cartProduct->where('cart_id', $cart_id)->where('product_id', $product_id)->where('product_size_id', $size_id)->where('product_color_id', $color_id)->first();
    }

    public function findCartProductDetail($cartProduct_id)
    {
        return $this->cartProduct->find($cartProduct_id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->cart->findOrFail($id);
    }

    public function getCartProductList($cart_id)
    {
        return $this->cartProduct->join('products', static function ($query) {
            $query->on('products.id', '=', 'cart_products.product_id');
        })
            ->where('products.status', EProductStatus::active)
            ->where('products.is_approved', 1)
            ->where('cart_products.cart_id', $cart_id)
            ->select([
                DB::raw('products.title as product_name'),
                DB::raw('products.product_code as product_code'),
                DB::raw('products.id as product_id'),
                DB::raw('products.category_id as category_id'),
                DB::raw('products.brand_id as brand_id'),
                DB::raw('cart_products.product_id as product_id'),
                DB::raw('products.cover_image as cover_image'),
                DB::raw('cart_products.product_price as product_price'),
                DB::raw('cart_products.quantity as quantity'),
                DB::raw('cart_products.product_color_id as product_color_id'),
                DB::raw('cart_products.product_size_id as product_size_id'),
                DB::raw('cart_products.product_size as product_size'),
                DB::raw('cart_products.product_color as product_color'),
                DB::raw('cart_products.product_custom_attributes as product_custom_attributes'),
                DB::raw('cart_products.product_custom_attribute_value as product_custom_attribute_value'),
                DB::raw('cart_products.id as cart_product_id'),
                DB::raw('cart_products.created_at as created_at'),
                DB::raw('products.quantity as product_quantity'),
                DB::raw('products.minimum_quantity as minimum_quantity'),
            ])->get();
    }


}
