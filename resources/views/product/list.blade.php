@extends('admin.layouts.master')
@section('title', __('Product'))
@section('style')
    <style>

    </style>
@endsection

@section('content')

    <div class="breadcrumb">
        <h1 class="mr-2">Product</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="text-left p-4 font-weight-bold">
                    @if (isset($nav))
                        {{$nav}}
                    @endif
                </div>
                <div class="text-right p-4">
                    <a href="{{route('web.product.createView')}}"
                       class="btn btn-primary col-sm-3">{{__('Create Product')}}</a>
                </div>
                <!-- ICON BG -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class=" table-responsive">
                                <table class="table" id="productTable">
                                    <thead>
                                    <tr>
                                        <th class="all">{{__('Name')}}</th>
                                        <th class="all">{{__('Category Name')}}</th>
                                        <th class="all">{{__('In Stock')}}</th>
                                        <th class="all">{{__('Price')}}</th>
                                        <th class="all">{{__('Description')}}</th>
                                        <th class="all">{{__('Status')}}</th>
                                        <th class="all">{{__('Unit')}}</th>
                                        <th class="all">{{__('Unit Amount')}}</th>
                                        <th class="all">{{__('Image')}}</th>
                                        <th class="desktop">{{__('Actions')}}</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#productTable').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{isset($categoryId)?
                        route('web.product.filterProductTableData', $categoryId):
                        route('web.product.productTableData')}}',
                autoWidth:false,
                columnDefs: [
                    {
                        "className": "text-center",
                        "targets": "_all",
                        "orderable": true,
                    }
                ],
                columns: [
                    {"data": "name", name:"products.name"},
                    {"data": "category_name", name:"category_name"},
                    {"data": "in_stock", name:"in_stock"},
                    {"data": "price", name:"products.price"},
                    {"data": "description", name:"products.description"},
                    {"data": "status", name:"products.status"},
                    {"data": "unit", name:"products.unit"},
                    {"data": "unit_amount", name:"unit_amount"},
                    {"data": "image", name:"products.image"},
                    {"data": "action", name: "action", orderable: false,searchable: false},
                    // {"data": "tax_percentage", name:"tax_percentage"},
                    // {"data": "product_discount", name:"products.product_discount"},
                ]
            });
        });
    </script>

@endsection
