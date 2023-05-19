
@if($section === 1)
    {!! Form::select('product_attributes_one_value[]',$_colorSelectList, $value =  (json_decode($product_attributes_one_value ?? "")), ['id'=>'product_attributes_one_value','class'=>'form-select','placeholder'=>'Select Color' ,'multiple']) !!}
    {!! Form::hidden('product_attributes_one',$value = 'color',['id'=>'product_attributes_one']) !!}
@elseif($section === 2)
    {!! Form::select('product_attributes_two_value[]',$_colorSelectList, $value =  (json_decode($product_attributes_two_value ?? "")), ['id'=>'product_attributes_two_value','class'=>'form-select','placeholder'=>'Select Color' ,'multiple']) !!}
    {!! Form::hidden('product_attributes_two',$value = 'color',['id'=>'product_attributes_two']) !!}
@elseif($section === 3)
    {!! Form::select('product_attributes_three_value[]',$_colorSelectList, $value =  (json_decode($product_attributes_three_value ?? "")), ['id'=>'product_attributes_three_value','class'=>'form-select','placeholder'=>'Select Color' ,'multiple']) !!}
    {!! Form::hidden('product_attributes_three',$value = 'color',['id'=>'product_attributes_three']) !!}
@endif
