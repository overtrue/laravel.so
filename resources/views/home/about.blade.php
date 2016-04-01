@extends('layouts.main')

@section('title', trans('home.about_tricks_website'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center">{!! trans('home.about_title') !!}</h1>
            <div class="content-box">
              <p>Laravel.so 是一个专注于分享 Laravel 使用经验、技巧、以及教程的网站。</p>
              <p>我们致力于让你在最短的时间内学到真正有用的技巧，快速查找关注的知识点。</p>
            </div>
        </div>
    </div>
</div>
@stop



