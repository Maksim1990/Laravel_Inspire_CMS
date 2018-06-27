<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">
@if(isset($title))
    <title>{{$title}}</title>
@else
    <title>Inspire CMS</title>
@endif



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="{{asset('lib/noty.css')}}" rel="stylesheet">
<script src="{{asset('lib/noty.js')}}" type="text/javascript"></script>



<link href="{{asset('css/libs.css')}}" rel="stylesheet">
<link href="{{asset('css/layout_admin.css')}}" rel="stylesheet">
<link href="{{asset('css/style.css')}}" rel="stylesheet">

@yield('styles')
@yield('scripts_header')