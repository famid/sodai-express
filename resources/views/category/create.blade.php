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

            <h1 class="mb-3 text-18">Create Category</h1>
            <form method="POST" action="{{ route('web.category.create') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control form-control-rounded @error('name')
                            is-invalid
                    @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <p>Do you want to publish your Category now ?</p>
                    <input type="radio" id="" name="status" value="{{ACTIVE}}">
                    <label for="male">Yes</label><br>
                    <input type="radio" id="" name="status" value="{{INACTIVE}}">
                    <label for="male">No</label><br>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-rounded mt-3">
                    {{ __('Create Category') }}
                </button>
            </form>
        </div>
    </div>

@endsection

@section('script')

@endsection

