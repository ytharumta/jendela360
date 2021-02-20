@extends('layout.global')

@section('title')
    Product
@endsection

@section('pagetitle')
    Products
@endsection

@section('pagetitledes')
    Edit Product
@endsection

@section('content')

<div class="card card-bordered card-preview">
    <div class="card-inner">
        <form id="product_update" action="{{route('product.update', $product->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="product_name">Product Name</label>
                <div class="form-control-wrap">
                    <input type="text" value="{{$product->vehicle_name}}" class="form-control" id="product_name" name='product_name' placeholder="Input Product Name" required>
                </div>
                <br>
                <label class="form-label" for="price">Price</label>
                <div class="form-control-wrap">
                    <input type="number" value="{{$product->price}}" class="form-control" id="price" name='price' placeholder="Input Price" required>
                </div>
                <br>
                <div class='float-right'>
                    <button class='btn btn-round btn-primary' type='submit'>Update</button>
                </div>
                <br>
            </div>
        </form>
    </div>
</div>

@endsection


@section('scripts')
    <script>
        $('#product_update').validate();
    </script>
@endsection