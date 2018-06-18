
@extends('layouts.admin')

@section('scripts_header')

@endsection
@section('General')
    <h1>Dashboard</h1>
    <div class="w3-row">
        <div class="container">
            <h3>Tooltip Example</h3>
            <a href="#" data-toggle="tooltip5" title="Hooray!">Hover over me</a>
        </div>
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip5"]').tooltip();
            });
        </script>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip5"]').tooltip();
    });
</script>
@endsection
