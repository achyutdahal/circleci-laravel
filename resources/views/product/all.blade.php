@extends('layout.app')

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h3>All Available Products</h3>

        <br>
        <table class="table table-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">SN</th>
                    <th scope="col">Image</th>
                    <th scope="col">@sortablelink('Name')</th>
                    <th scope="col">@sortablelink('Price')</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index=>$product)
                <tr>
                    <th scope="row">{{ $index + $products->firstItem() }}</th>
                    <td><a class="productLink" href="/product/{{$product->id}}"><img src="{{$product->smallThumbnail()}}"></a></td>
                    <td><a class="productLink" href="/product/{{$product->id}}">{{$product->name}}</a></td>

                    <td>${{$product->price}}</td>
                    <td>{{getSummary($product->description)}}</td>

                    <td><a class="margin-r-5" style="margin-right:5px;" href="/edit-product/{{$product->id}}"><span ><i class="fas fa-edit"></i></span></a><a href="javascript:void(0)"><span class="deleteProduct" data-id="{{$product->id}}"><i class="fas fa-trash-alt"></i></span></a></td>
                </tr>

                @endforeach               
            </tbody>
        </table>


    </div>


</div>
<div class="row">
    <div class="col-sm-12">
        <div>
            {{ $products->links() }}

        </div>
    </div>
</div>

@endsection
