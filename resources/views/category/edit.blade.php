@extends('admin.layouts.master')
@section('title', __('Category'))
@section('style')
    <style>

    </style>
@endsection

@section('content')

    <div class="breadcrumb">
        <h1 class="mr-2">Category</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="col-md-6">
        <div class="p-4">
            <h1 class="mb-3 text-18">Edit Category</h1>
            <form method="POST" action="{{ route('web.category.update') }}">
                @csrf
                <input type="hidden" name="category_id" value="{{$data->id}}">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control form-control-rounded @error('name') is-invalid
                    @enderror" name="name" value="{{$data->name}}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <p>Do you want to publish your Category now ?</p>
                    <input type="radio" id="" name="status" value="{{ACTIVE}}" @if ($data->status == ACTIVE)
                    checked @endif>
                    <label for="male">Yes</label><br>
                    <input type="radio" id="" name="status" value="{{INACTIVE}}" @if ($data->status == INACTIVE)
                    checked @endif>
                    <label for="male">No</label><br>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-rounded mt-3">
                    {{ __('Update Category') }}
                </button>
            </form>
        </div>
    </div>

@endsection

@section('script')

@endsection

