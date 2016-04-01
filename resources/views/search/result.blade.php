@extends('layouts.main')

@section('title', trans('search.search_results_for', array('term' => $term)))

@section('content')
    <div class="container">
        @if($term != '')
        <div class="row push-down">
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                <h1 class="page-title">&quot;<strong>{!! $term !!}</strong>&quot; 有 {{ $tricks->total() }} 个搜索结果 </h1>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                @include('partials.search',['term'=>$term])
            </div>
        </div>

        @include('tricks.grid', ['tricks' => $tricks, 'appends' => [ 'q' => $term ]])

        @else
            <div class="row push-down">
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                    <h1 class="page-title">{{ trans('search.please_provide_search_term') }}</h1>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    @include('partials.search')
                </div>
            </div>
        @endif
    </div>
@stop
