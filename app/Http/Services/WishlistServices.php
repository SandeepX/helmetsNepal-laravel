<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Http\Repositories\WishlistRepository;
use App\Http\Resources\WishlistResources;
use Illuminate\Support\Facades\Auth;

class WishlistServices
{
    public function __construct()
    {
        $this->wishlistRepository = new WishlistRepository();
    }


    /**
     * @throws SMException
     */
    public function saveWishlist($request)
    {
        $product_id = $request->product_id;
        $_customer = Auth::guard('customerApi')->user();

        if ($_customer) {
            $wishlist_resp = $this->wishlistRepository->find($_customer->id , $product_id);
            if($wishlist_resp){
               return  true;
            }
            return $this->wishlistRepository->save(['product_id' => $product_id, 'customer_id' => $_customer->id,]);
        }
        throw new SMException("Must login To add to wishlist");
    }

    /**
     * @throws SMException
     */
    public function getWishlist()
    {
        $_customer = Auth::guard('customerApi')->user();
        if ($_customer) {
            $wishlist = $this->wishlistRepository->getWishlistOfCustomer($_customer->id);
            if (($wishlist->count()) > 0) {
                return WishlistResources::collection($wishlist);
            }
            return [];
        }
        throw new SMException("Must login To view wishlist");
    }


    /**
     * @throws SMException
     */
    public function deleteWishlist($request)
    {
        $product_id = $request->product_id;
        $_customer = Auth::guard('customerApi')->user();

        if ($_customer) {
            $wishlist = $this->wishlistRepository->find($_customer->id, $product_id);
            if ($wishlist) {
                return $this->wishlistRepository->delete($wishlist);
            }
            throw new SMException("Product is not in wishlist");
        }
        throw new SMException("Must login To add to wishlist");
    }


}
