<!DOCTYPE html>
<html lang="en">
    @include('admin.layouts.header')
<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large clearfix">
        <span style="position:absolute;top:0;left:0; z-index:999;width:100%;">
            @if(Session::has('success'))
                <div class="alert-float alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{Session::get('success')}}
            </div>
            @endif

            @if(Session::has('error'))
                <div class="alert-float alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{Session::get('error')}}
            </div>
            @endif
            @if(!empty($errors) && count($errors) > 0)
                <div class="alert-float alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{$errors->first()}}
            </div>
            @endif
        </span>
        <!--=============== Top Bar Start ================-->
        @include('admin.layouts.top_bar')
        <!--=============== Top Bar End ================-->

        <!--=============== Left side Start ================-->
        @include('admin.layouts.sidebar')
        <!--=============== Left side End ================-->

        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            @yield('content')
        <!-- ============ Body content End ============= -->
        <!-- ============ Footer Start ============= -->
            @include('admin.layouts.footer')
        <!-- ============ Footer End ============= -->
        </div>
    </div>
<!--=============== End app-admin-wrap ================-->
@include('admin.layouts.script')
@yield('script')
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('.close').trigger('click');
            }, 2500);
        });
    </script>
</body>

</html>
