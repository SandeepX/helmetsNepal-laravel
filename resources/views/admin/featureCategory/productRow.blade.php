
<tr>
    <td> .</td>
    <td>{{$_product->product_code}}</td>
    <td>{{$_product->title}}</td>
    <td>{{$_product->getCategory->name}}</td>
    <td>{{$_product->getBrand?->title}}</td>
    <td>{{ ucfirst($_product->status)}}</td>

    <td>{{$_product->product_price}}</td>
    <td>{{$_product->product_discount['discount_percent'] ?? 0.0}} %</td>
    <td>{{$_product->product_discount['discount_amount'] ?? 0.0}}</td>
    <td>{{$_product->final_product_price}}</td>
    <td>
        <input type="hidden" name="product_id[]" value="{{$_product->id}}">
    </td>
</tr>
