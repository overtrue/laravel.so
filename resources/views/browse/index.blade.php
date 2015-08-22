@extends('layouts.main')

@section('title', $pageTitle)

@section('content')
    <div class="container">
        <div class="row push-down">
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                @if(Request::is('/') || Request::is('popular') || Request::is('comments'))
                    <div class="row push-down">
                        <div class="col-lg-12">
                            <ul class="nav nav-pills">
                                {!! Navigation::make(Request::path(), 'browse') !!}
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                @include('partials.search')
            </div>
        </div>



        @include('tricks.grid', ['tricks' => $tricks])
    </div>
@stop
