
@extends('layouts.admin')

@section('scripts_header')

@endsection
@section('General')
    <h1>Dashboard</h1>
    <div class="w3-row">
        <div class="container">
            <h3>Tooltip Example</h3>
        </div>

    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip5"]').tooltip();
    });
</script>
@endsection
