<?php

namespace App\Http\Resources;

use App\Models\Product\ProductColor;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $productColor = ProductColor::find($this->product_color_id );
        $product_quantity = $productColor?->quantity ?? 0;
        return [
            'id' => $this->cart_product_id,
            'product_id' => $this->product_id,
            'name' => $this->product_name,
            'image' => asset('/front/uploads/product_cover_image') .'/'. $this->cover_image,
            'amount' => $this->product_price,
            'qty' => round($this->quantity),
            'date' => date('Y-m-d h:i A', strtotime($this->created_at)),
            'product_custom_attributes' => $this->product_custom_attributes ?? "",
            'product_custom_attribute_value' => $this->product_custom_attribute_value ?? "",
            'product_color_id' => $this->product_color_id ?? "",
            'product_size_id' => $this->product_size_id ?? "",
            'product_size' => $this->product_size ?? "",
            'product_color' => $this->product_color ?? "",
            'product_quantity' => round($product_quantity),
            'minimum_order_quantity' => round($this->minimum_quantity ?? 0),
        ];
    }
}
