@extends('admin.layouts.master')
@section('title', __('Product'))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/default/styles/css/dropify.min.css')}}">
    <style>

    </style>
@endsection

@section('content')

    <div class="breadcrumb">
        <h1 class="mr-2">Product</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="col-md-6">
        <div class="p-4">

            <h1 class="mb-3 text-18">Update Product</h1>
            <form method="POST" action="{{ route('web.product.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{isset($product['data']->id) ? $product['data']->id : ''}}">
                <input type="hidden" name="old_image" value="{{isset($product['data']->image) ?  $product['data']->image :''}}">
                <div class="form-group">
                    <label for="category_id">Select Category</label>
                    <select name="category_id" class="form-control form-control-rounded">
                        @if (isset($categories))
                            @foreach($categories['data'] as $category)
                                <option value="{{$category->id}}"
                                        @if(($category->id == $product['data']->category_id) ||
                                        ($category->id == old('category_id'))) selected
                                        @endif>

                                    {{$category->name}}
                                </option>
                            @endforeach
                        @else
                            <option value="default">No division found </option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control form-control-rounded @error('name')
                            is-invalid
                    @enderror" name="name" value="{{isset($product['data']->name) ? $product['data']->name : ''}}"
                           required
                           autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" required>{{$product['data']->description ?? ''}}</textarea>
                    <span class="input-filed-error" id="productDescriptionError"></span>
                </div>

                <div class="form-group">
                    <label for="unit">Unit</label>
                    <input id="unit" type="text" class="form-control form-control-rounded @error('unit')
                            is-invalid
                    @enderror" name="unit" value="{{isset($product['data']->unit) ? $product['data']->unit : ''}}"
                           required
                           autocomplete="unit" autofocus>

                    @error('unit')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="unit_amount">Unit amount</label>
                    <input id="unit_amount" type="text" class="form-control form-control-rounded @error('unit_amount')
                            is-invalid
                    @enderror" name="unit_amount" value="{{isset($product['data']->unit_amount) ?
                    $product['data']->unit_amount
                     : ''}}"
                           required autocomplete="unit_amount" autofocus>

                    @error('unit_amount')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input id="price" type="text" class="form-control form-control-rounded @error('price')
                            is-invalid
                    @enderror" name="price" value="{{isset($product['data']->price) ? $product['data']->price :''}}"
                           required autocomplete="price" autofocus>

                    @error('price')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="in_stock">In stock</label>
                    <input id="in_stock" type="text" class="form-control form-control-rounded @error('in_stock')
                            is-invalid
                    @enderror" name="in_stock" value="{{isset($product['data']->in_stock) ? $product['data']->in_stock : ''}}"
                           required
                           autocomplete="in_stock" autofocus>

                    @error('in_stock')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="product_discount">Product Discount</label>
                    <input id="product_discount" type="text" class="form-control form-control-rounded @error('product_discount')
                            is-invalid
                    @enderror" name="product_discount" value="{{isset($product['data']->product_discount) ? $product['data']->product_discount : ''}}" required autocomplete="product_discount" autofocus>

                    @error('product_discount')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tax_percentage">Tax Percentage</label>
                    <input id="tax_percentage" type="text" class="form-control form-control-rounded @error('tax_percentage')
                            is-invalid
                    @enderror" name="tax_percentage" value="{{isset($product['data']->tax_percentage) ?
                    $product['data']->tax_percentage :  ''}}" required autocomplete="tax_percentage" autofocus>

                    @error('tax_percentage')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" name="image" id="input-file-now" class="dropify"
                           data-default-file="{{$product['data']->image}}"/>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <p>Do you want to publish your Category now ?</p>
                    <input type="radio" id="" name="status" value="{{ACTIVE}}" @if ($product['data']->status == ACTIVE)
                    checked @endif>
                    <label for="male">Yes</label><br>
                    <input type="radio" id="" name="status" value="{{INACTIVE}}" @if ($product['data']->status == INACTIVE)
                    checked @endif>
                    <label for="male">No</label><br>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-rounded mt-3">
                    {{ __('Update Product') }}
                </button>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script type='text/javascript' src='{{ asset('assets/default/js/dropify.min.js') }}'></script>
    <script>
        $(document).ready(function () {
            $('.dropify').dropify();
        });
    </script>
@endsection

