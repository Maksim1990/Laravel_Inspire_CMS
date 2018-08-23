<!DOCTYPE html>
<html>
@include('website::partials.header_html')
<body>
@yield('content')
@if(isset($blnShowContectForm) && !$blnShowContectForm)
@include('website::partials.contact_form')
@endif
@include('website::partials.footer')



</body>
</html>


