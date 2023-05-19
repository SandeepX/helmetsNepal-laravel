<option value = ''>Select Category</option>
@foreach($_categories as $_category)
    <option value="{{ $_category['id'] }}">{{ $_category['name'] }}</option>
@endforeach

