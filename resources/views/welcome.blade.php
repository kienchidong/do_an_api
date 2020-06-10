<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" value="{{ csrf_token() }}">
    <meta name="locale" content="{{ App::getLocale() }}"/>
    <meta name="userName" content="{{ Auth::user()->name }}">
    <meta name="userEmail" content="{{ Auth::user()->email }}">
    <meta name="userAvatar" content="null">
    <title>Admin</title>
    <link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/lte/css/library.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('alertify/alertify.bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('alertify/alertify.core.css')}}">
    <link rel="stylesheet" href="{{ asset('alertify/alertify.default.css')}}">
    <script src="{{ asset('alertify/alertify.min.js') }}"></script>
    <style>
    .box{
        border-radius: 10px;
        box-shadow: 10px 10px 15px 0px grey;
    }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="app">
</div>

<script src="{{ asset('admin/js/app.js') }}"></script>
<script src="{{ asset('admin/lte/js/library.min.js') }}"></script>
<script>
    $('.sidebar-menu').children('li').click(function () {
        $('.menu-open').removeClass('menu-open');
        $('.active').removeClass('active');
        $(this).addClass('active');
    })
</script>
</body>
</html>
