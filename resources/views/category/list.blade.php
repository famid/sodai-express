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

    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="text-right p-4">
                    <a href="{{route('web.category.createView')}}"
                       class="btn btn-primary col-sm-3">{{__('Create Category')}}</a>
                </div>
                <!-- ICON BG -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class=" table-responsive">
                                <table class="table" id="categoryTable">
                                    <thead>
                                    <tr>
                                        <th class="all">{{__('Name')}}</th>
                                        <th class="all">{{__('Status')}}</th>
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
            $('#categoryTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: '{{route('web.category.categoryTableData')}}',
                autoWidth:false,
                columnDefs: [
                    {"className": "text-center", "targets": "_all"}
                ],
                columns: [
                    {data: "name", name:'categories.name'},
                    {data: "status", name:'categories.status'},
                    {data: "action", name: "action", orderable: false, searchable: false},
                ]
            });
        });
    </script>

@endsection
