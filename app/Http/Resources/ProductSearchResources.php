<?php

namespace App\Http\Resources;


use App\Http\Services\CompanyDetailsServices;
use Html2Text\Html2Text;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSearchResources extends JsonResource
{
    public function toArray($request): array
    {
        $html2TextConverter = new Html2Text($this->details);
        $content = $html2TextConverter->getText();
        $companyDetailsServices = new CompanyDetailsServices();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => str_replace(["\n", "\t*", "\n\t*"], ' ', $content),
            'featured_media' => $this->product_cover_image_path,
            'categories' => [$this->getCategory->getParentCategory?->name, $this->getCategory?->name],
            'tags' => ($this->tag_name) ? [$this->tag_name] : [],
            'regular_price' => $this->product_price,
            'discounted_price' => $this->product_discount['discount_amount'],
            'stock' => (($this->quantity > 2) ? "instock" : ""),
            'gallery' => ProductImageResource::collection($this->getProductImage),
            'permalink' => ($companyDetailsServices->getFELink() ?? "") . "items/" . $this->slug,
            'brand' => $this->getBrand?->title ?? "",
            'productGraphic' => $this->getProductGraphic?->name ?? "",
            'productModel' => $this->getProductModel?->name ?? "",
            'size' => $this->getProductSize()->join('sizes', 'sizes.id', '=', 'product_sizes.size_id')->pluck('name'),
            'color' => $this->getProductColor()->join('colors', 'colors.id', '=', 'product_colors.color_id_1')->pluck('name')
        ];
    }
}
