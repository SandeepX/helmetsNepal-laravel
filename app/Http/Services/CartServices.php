<?php

namespace App\Http\Services;

use App\Events\EmailVerificationEvent;
use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Resources\CartProductResource;
use App\Models\Cart\CartProduct;
use App\Models\Product\ProductColor;
use Illuminate\Support\Facades\Auth;

class CartServices
{
    private CartRepository $cartRepository;
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->cartRepository = new CartRepository();
        $this->productRepository = new ProductRepository();
    }


//    /**
//     * @throws SMException
//     */
//    public function addToCart($request): array|string
//    {
//        $product_id = $request->product_id;
//        $_customer = Auth::guard('customerApi')->user();
//        $data = $request->all();
//        if ($_customer) {
//            $customer_id = $_customer->id;
//            $_product = $this->productRepository->findActiveProduct($product_id);
//            if ($_product) {
//                $_cart = $this->cartRepository->findByCustomerId($customer_id);
//                $product_price = $_product->final_product_price;
//                $product_custom_attributes = $data['product_custom_attributes'] ?? null;
//                $product_custom_attribute_value = $data['product_custom_attribute_value'] ?? null;
//                if ($_cart) {
//                    $cart_id = $_cart->id;
//                    $_cartProduct = null;
//                    if (isset($data['product_color_id'], $data['product_size_id'])) {
//                        $_cartProduct = $this->cartRepository->findCartProductWithAll(cart_id: $cart_id, product_id: $product_id, color_id: $data['product_color_id'], size_id: $data['product_size_id']);
//
//                    } else if (isset($data['product_size_id'])) {
//                        $_cartProduct = $this->cartRepository->findCartProductWithCartIDAndSizeId(cart_id: $cart_id, product_id: $product_id, size_id: $data['product_size_id']);
//
//                    } else if (isset($data['product_color_id'])) {
//                        $_cartProduct = $this->cartRepository->findCartProductWithCartIDAndColorId(cart_id: $cart_id, product_id: $product_id, color_id: $data['product_color_id']);
//                    } else if (!isset($data['product_color_id'], $data['product_size_id'])) {
//                        $_cartProduct = $this->cartRepository->findCartProductWithCartID(cart_id: $cart_id, product_id: $product_id);
//                    }
//                    if ($_cartProduct) {
//                        $this->updateCartProduct($data, $_cartProduct);
//                    } else {
//                        $this->cartRepository->saveCartProduct([
//                            'cart_id' => $_cart->id,
//                            'product_id' => $product_id,
//                            'product_custom_attributes' => $product_custom_attributes,
//                            'product_custom_attribute_value' => $product_custom_attribute_value,
//                            'product_color_id' => $data['product_color_id'] ?? null,
//                            'product_size_id' => $data['product_size_id'] ?? null,
//                            'product_price' => $product_price,
//                            'quantity' => $data['quantity'] ?? 1,
//                            'product_size' => $data['product_size'] ?? '',
//                            'product_color' => $data['product_color'] ?? '',
//                        ]);
//                    }
//                    $total_price = (float)$product_price + (float)$_cart->total_price;
//                    $this->cartRepository->update($_cart, [
//                        'total_price' => $total_price,
//                    ]);
//                    return $this->getCartDetail();
//                }
//                $_cart_resp = $this->cartRepository->save([
//                    'customer_id' => $customer_id,
//                    'cart_number' => Helper::generateCartNumber(),
//                    'created_on' => Helper::smTodayInYmdHis(),
//                    'total_price' => $product_price,
//                    'note' => $data['note'] ?? '',
//                ]);
//                $this->cartRepository->saveCartProduct([
//                    'cart_id' => $_cart_resp->id,
//                    'product_id' => $product_id,
//                    'product_custom_attributes' => $product_custom_attributes,
//                    'product_custom_attribute_value' => $product_custom_attribute_value,
//                    'product_color_id' => $data['product_color_id'] ?? null,
//                    'product_size_id' => $data['product_size_id'] ?? null,
//                    'product_size' => $data['product_size'] ?? '',
//                    'product_color' => $data['product_color'] ?? '',
//                    'product_price' => $product_price,
//                    'quantity' => $data['quantity'] ?? 1,
//                ]);
//                return $this->getCartDetail();
//            }
//            return "Sorry! Product Not Found";
//        }
//        throw new SMException("Must login To add to Cart");
//    }

    /**
     * @param mixed $data
     * @param CartProduct $_cartProduct
     * @return void
     */
    public function updateCartProduct(mixed $data, CartProduct $_cartProduct): void
    {
        $product_custom_attributes = $data['product_custom_attributes'] ?? null;
        $product_custom_attribute_value = $data['product_custom_attribute_value'] ?? null;
        $product_color_id = $data['product_color_id'] ?? null;
        $product_size_id = $data['product_size_id'] ?? null;
        $quantity = ($_cartProduct->quantity + $data['quantity']) ?? 1;
        $ProductColor = ProductColor::find($product_color_id);
        $product_color= $ProductColor?->getColorOne?->name;
        $_cartProduct->update([
            'product_custom_attributes' => $product_custom_attributes,
            'product_custom_attribute_value' => $product_custom_attribute_value,
            'product_color_id' => $product_color_id,
            'product_size_id' => $product_size_id,
            'product_size' => $data['product_size'] ?? '',
            'product_color' => $product_color ?? '',
            'quantity' => $quantity,
        ]);
    }

    public function updateCartItemProduct(mixed $data, CartProduct $_cartProduct): void
    {
        $quantity = $data['quantity'] ?? $_cartProduct->quantity;
        $_cartProduct->update([
            'quantity' => $quantity,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getCartDetail(): array|string
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $_cart = $this->cartRepository->findByCustomerId($_customer->id);

            if ($_cart) {
                $_cartProduct = $this->cartRepository->getCartProductList($_cart->id);
                $total_cart_item = $_cartProduct->count();
                return [
                    'cart_id' => $_cart->id,
                    'cart_number' => $_cart->cart_number,
                    'created_on' => $_cart->created_on,
                    'total_price' => $_cart->total_price,
                    'total_cart_item' => $total_cart_item,
                    'cartItems' => CartProductResource::collection($_cartProduct),
                ];
            }
            return "Sorry! Cart Not Found";
        }
        throw new SMException("Must login To add to Cart");
    }

    /**
     * @throws SMException
     */
    public function addToCart_2($request): array|string
    {
        $_customer = Auth::guard('customerApi')->user();
        $data = $request->all();

        if ($_customer) {
            if ($_customer->user_type == 'customer' && !($_customer->is_verified)) {
                throw new SMException("Please verify your email address sent in your mail to access your account.");
            }
            $customer_id = $_customer->id;
            $_cart = $this->cartRepository->findByCustomerId($customer_id);
            if ($_cart) {
                foreach ($data as $value) {
                    $product_id = $value['product_id'];
                    $_product = $this->productRepository->find($product_id);

                    if ($_product) {

                        $product_price = $_product->final_product_price;
                        $product_custom_attributes = $value['product_custom_attributes'] ?? null;
                        $product_custom_attribute_value = $value['product_custom_attribute_value'] ?? null;
                        $cart_id = $_cart->id;
                        $_cartProduct = null;



                        if (isset($value['product_color_id'], $value['product_size_id'])) {
                            $_cartProduct = $this->cartRepository->findCartProductWithAll(cart_id: $cart_id, product_id: $product_id, color_id: $value['product_color_id'], size_id: $value['product_size_id']);
                        } else if (isset($value['product_size_id'])) {
                            $_cartProduct = $this->cartRepository->findCartProductWithCartIDAndSizeId(cart_id: $cart_id, product_id: $product_id, size_id: $value['product_size_id']);
                        } else if (isset($value['product_color_id'])) {
                            $_cartProduct = $this->cartRepository->findCartProductWithCartIDAndColorId(cart_id: $cart_id, product_id: $product_id, color_id: $value['product_color_id']);
                        } else if (!isset($value['product_color_id'], $value['product_size_id'])) {
                            $_cartProduct = $this->cartRepository->findCartProductWithCartID(cart_id: $cart_id, product_id: $product_id);
                        }
                        $ProductColor = ProductColor::find($value['product_color_id']);
                        $value['product_color'] = $ProductColor->getColorOne->name;
                        if ($_cartProduct) {
                            $this->updateCartProduct($value, $_cartProduct);
                        } else {
                            $this->cartRepository->saveCartProduct([
                                'cart_id' => $_cart->id,
                                'product_id' => $product_id,
                                'product_custom_attributes' => $product_custom_attributes,
                                'product_custom_attribute_value' => $product_custom_attribute_value,
                                'product_color_id' => $value['product_color_id'] ?? null,
                                'product_size_id' => $value['product_size_id'] ?? null,
                                'product_price' => $product_price,
                                'quantity' => $value['quantity'] ?? 1,
                                'product_size' => $value['product_size'] ?? '',
                                'product_color' => $value['product_color'] ?? '',
                            ]);
                        }
                        $total_price = (float)$product_price + (float)$_cart->total_price;
                        $this->cartRepository->update($_cart, [
                            'total_price' => $total_price,
                        ]);

                    } else {
                        return "Sorry! Product Not Found";
                    }

                }
            } else {
                $total_price = 0;

                $_cart_resp = $this->cartRepository->save([
                    'customer_id' => $customer_id,
                    'cart_number' => Helper::generateCartNumber(),
                    'total_price' => $total_price,
                    'created_on' => Helper::smTodayInYmdHis(),
                    'note' => $value['note'] ?? '',
                ]);
                $final_total_price = 0;
                foreach ($data as $value) {
                    $product_id = $value['product_id'];
                    $_product = $this->productRepository->find($product_id);
                    if ($_product) {
                        $product_price = $_product->final_product_price;
                        $product_custom_attributes = $value['product_custom_attributes'] ?? null;
                        $product_custom_attribute_value = $value['product_custom_attribute_value'] ?? null;

                        $ProductColor = ProductColor::find($value['product_color_id']);
                        $value['product_color'] = $ProductColor->getColorOne->name;
                            $quantity = $value['quantity'] ?? 1;
                        $this->cartRepository->saveCartProduct([
                            'cart_id' => $_cart_resp->id,
                            'product_id' => $product_id,
                            'product_custom_attributes' => $product_custom_attributes,
                            'product_custom_attribute_value' => $product_custom_attribute_value,
                            'product_color_id' => $value['product_color_id'] ?? null,
                            'product_size_id' => $value['product_size_id'] ?? null,
                            'product_size' => $value['product_size'] ?? '',
                            'product_color' => $value['product_color'] ?? '',
                            'product_price' => $product_price,
                            'quantity' => $quantity,
                        ]);
                        $total_price = (float)$product_price * $quantity;
                        $final_total_price =+ $total_price;
                    } else {
                        return "Sorry! Product Not Found";
                    }
                }
                $this->cartRepository->update($_cart_resp, [
                    'total_price' => $final_total_price,
                ]);
            }
            return $this->getCartDetail();
        }
        throw new SMException("Must login To add to Cart");
    }

    /**
     * @throws SMException
     */
    public function deleteCartItem($request): mixed
    {
        $product_id = $request->product_id;
        $cart_number = $request->cart_number;
        $cart_product_id = $request->cart_product_id;
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            if ($_customer->user_type == 'customer' && !($_customer->is_verified)) {
                throw new SMException("Please verify your email address sent in your mail to access your account.");
            }
            $_cart = $this->cartRepository->findByCartNumber($cart_number);
            if ($_cart) {
                $_cartProduct = $this->cartRepository->findCartProduct(cart_product_id: $cart_product_id, product_id: $product_id, cart_id: $_cart->id);
                if ($_cartProduct) {
                    $product_price = (float)$_cartProduct->product_price + (float)$_cartProduct->quantity;
                    $this->cartRepository->deleteCartProduct($_cartProduct);
                    $_cart = $this->cartRepository->findByCartNumber($cart_number);
                    $cart_item_count = $_cart->getCartItem->count();
                    if($cart_item_count !== 0){
                        $this->cartRepository->update($_cart, [
                            'total_price' => $_cart->total_price - $product_price,
                        ]);
                    }else{
                        $this->cartRepository->delete($_cart);
                    }
                    return Helper::successResponseAPI('Successfully Deleted', []);
                }
                return Helper::errorResponseAPI('Sorry! Product Not Found', []);
            }
            return Helper::errorResponseAPI('Sorry! Cart Not Found', []);
        }
        throw new SMException("Must login To add to Cart");
    }

    /**
     * @throws SMException
     */
    public function updateCart($request)
    {

        $_customer = Auth::guard('customerApi')->user();
        $data = $request->all();
        if ($_customer) {
            if ($_customer->user_type == 'customer' && !($_customer->is_verified)) {
                throw new SMException("Please verify your email address sent in your mail to access your account.");
            }
            $customer_id = $_customer->id;
            $_cart = $this->cartRepository->findByCustomerId($customer_id);
            if ($_cart) {
                $cartProduct_id = $data['cart_product_id'];
                $_cartProduct = $this->cartRepository->findCartProductDetail($cartProduct_id);

                $this->updateCartItemProduct(data: $data, _cartProduct: $_cartProduct);

                $_product = $this->productRepository->findActiveProduct($_cartProduct->product_id);
                $_cart = $this->cartRepository->findByCustomerId($customer_id);
                $product_price = $_product->final_product_price;

                $quantity = $data['quantity'] ?? $_cartProduct->quantity;
                $total_price = (float)$product_price * $quantity;
                $this->cartRepository->update($_cart, [
                    'total_price' => $total_price,
                ]);
                return $this->getCartDetail();

            }
            return "Sorry! Cart Not Found";
        }
        throw new SMException("Must login To add to Cart");

    }
}
