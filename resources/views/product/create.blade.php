@extends('layout.app')

@section('content')
<div class="row">
    <div class="col-sm-8 col-md-8 margin-top-10">
        <h5>Create New Product</h5>
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
        <form class="product-create-form" id="product-create-form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="ext" name="name" class="form-control" id="name" placeholder="">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input  type="text" name="price" class="form-control" id="price" placeholder="">

                </div>               

            </div>           
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control"name="description" id="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" name="image" class="form-control-file" id="image">
            </div>
            <div>
                <button type="submit" class="btn btn-success">Save Product</button>
            </div>
        </form>


    </div>
    <div class="col-sm-4 col-md-4">
        <img id="uploadedImage" style="width: inherit; display: none;" class="img img-responsive img-thumbnail" src="#" alt="Uploaded Image" />
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div>

        </div>
    </div>
</div>

@endsection

