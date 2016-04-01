@extends('admin.layout')
@section('content')
<div class="console-content">
    <div class="well bs-component">
        <h1>欢迎回来！{{ $global->user->name }}</h1>
    </div>
</div>
@endsection