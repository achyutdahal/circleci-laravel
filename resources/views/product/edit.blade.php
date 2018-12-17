@extends('layout.app')

@section('content')
<div class="row">
    <div class="col-sm-8 col-md-8 margin-top-10">
        <h5>Update Product</h5>
        <hr>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form class="product-edit-form" id="product-edit-form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$product->id}}"/>
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="ext" name="name" value="{{$product->name}}" class="form-control" id="name" placeholder="">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input  type="text" name="price" value="{{$product->price}}" class="form-control" id="price" placeholder="">
            </div>           
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control"name="description" id="description" rows="3">{{$product->description}}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" name="image" class="form-control-file" id="image">
            </div>
            <div>
                <button type="submit" class="btn btn-success">Update Product</button>
            </div>
        </form>
    </div>
    <div class="col-sm-4 col-md-4">
        <img id="uploadedImage" style="width: inherit;" class="img img-responsive img-thumbnail" src="{{$product->getImage()}}" alt="Uploaded Image" />
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div>

        </div>
    </div>
</div>

@endsection

