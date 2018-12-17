@extends('layout.app')

@section('content')
<div class="row">
    <div class="col-sm-4 col-md-4">
        <h5>Product</h5>
        <hr>
        <img id="uploadedImage" style="width: inherit;" class="img img-responsive img-thumbnail" src="{{$product->getImage()}}" alt="Uploaded Image" />

    </div>
    <div class="col-sm-8 col-md-8">
        <h5>Product Details</h5>
        <hr>
        <table>
            <tr>
                <th>Name:</th>
                <td>{{$product->name}}</td>
            </tr>
            <tr>
                <th>Price:</th>
                <td>$ {{$product->price}}</td>
            </tr>
            <tr>
                <th>Description:</th>
                <td>{{$product->description}}</td>
            </tr>
        </table>


    </div>


</div>


@endsection
