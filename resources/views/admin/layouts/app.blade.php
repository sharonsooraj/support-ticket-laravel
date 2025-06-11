<!DOCTYPE html>
<html lang="en">


<head>
    <title>Support Ticket System</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


    <link href="{{ asset('admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet">
    <link class="main-css" href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

</head>

<body>

    @include('admin.layouts.header')

    @include('admin.layouts.sidebar')

    <main>
        @yield('content')
    </main>

    @include('admin.layouts.footer')


</body>

</html>
