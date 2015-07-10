@extends('layouts.main')

@section('title', $trick->pageTitle)

@section('description', $trick->pageDescription)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/prism.css') }}">
@stop

@section('scripts')
    <script src="{{ asset('js/prism.js')}}" data-default-language="php"></script>
    <script type="text/javascript" src="{{ asset('js/marked.min.js') }}"></script>
    <script type="text/javascript">
    (function($) {
        $('[data-toggle=tooltip]').tooltip();
        marked.setOptions({
          renderer: new marked.Renderer(),
          gfm: true,
          tables: true,
          breaks: false,
          pedantic: false,
          sanitize: true,
          smartLists: true,
          smartypants: false
        });
        $('#content').html(marked($('#markdown-source').html()));
    })(jQuery);
    </script>
    @if(Auth::check())
    <script>
    (function(e){e(".js-like-trick").click(function(t){t.preventDefault();var n=e(this).data("liked")=="0";var r={_token:"{{ csrf_token() }}"};e.post('{{ route("tricks.like", $trick->slug) }}',r,function(t){if(t!="error"){if(!n){e(".js-like-trick .fa").removeClass("text-primary");e(".js-like-trick").data("liked","0");e(".js-like-status").html("{{trans('tricks.like')}}")}else{e(".js-like-trick .fa").addClass("text-primary");e(".js-like-trick").data("liked","1");e(".js-like-status").html("{{ trans('liked') }}")}e(".js-like-count").html(t)}})})})(jQuery)
    </script>
    @endif
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="content-box">
                    @if(Auth::check() && (Auth::user()->id == $trick->user_id))
                        <div class="text-right">
                            <a data-toggle="modal" href="#deleteModal">删除</a> |
                            <a href="{{$trick->editLink}}">编辑</a>
                        </div>
                        @include('tricks.delete', ['link' => $trick->deleteLink])
                    @endif
                    <div class="trick-user">
                        <div class="trick-user-image">
                            <img src="{{ $trick->user->photocss }}" class="user-avatar">
                        </div>
                        <div class="trick-user-data">
                            <h1 class="page-title">
                                {{ $trick->title }}
                            </h1>
                            <div>
                                {{ trans('tricks.author') }} <b><a href="{{ route('user.profile', $trick->user->username) }}">{{ $trick->user->username }}</a></b> - {{ $trick->timeago }}
                            </div>
                        </div>
                    </div>
                    <script id="markdown-source" type="text/plain">{!! $trick->content !!}</script>
                    <article id="content"></article>
                </div>
            </div>
                <div class="col-lg-3 col-md-4">
                    <div class="content-box">
                        <b>{{ trans('tricks.stats') }}</b>
                        <ul class="nav nav-list push-down list-group trick-stats">
                            <li class="list-group-item">
                                <a href="#" class="js-like-trick" data-liked="{{ $trick->likedByUser(Auth::user()) ? '1' : '0'}}">

                                <span class="fa fa-heart @if($trick->likedByUser(Auth::user())) text-primary @endif"></span>
                                @if(Auth::check())
                                <span class="js-like-status">
                                    @if($trick->likedByUser(Auth::user()))
                                        {{ trans('tricks.liked') }}
                                    @else
                                        {{ trans('tricks.like') }}
                                    @endif
                                </span>
                                <span class="pull-right js-like-count">
                                @endif
                                    {{ $trick->vote_cache }}
                                @if(Auth::check())</span>@endif
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="javascript:;"><span class="fa fa-eye"></span> {{ $trick->view_cache }} {{ trans('tricks.views') }}</a>
                            </li>
                        </ul>
                        @if(count($trick->allCategories))
                            <b>{{ trans('tricks.categories') }}</b>
                            <ul class="nav nav-list push-down">
                                @foreach($trick->allCategories as $category)
                                    <li>
                                        <a href="{{ route('tricks.browse.category', $category->slug) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if(count($trick->tags))
                            <b>{{ trans('tricks.tags') }}</b>
                            <ul class="nav nav-list push-down">
                                @foreach($trick->tags as $tag)
                                    <li>
                                        <a href="{{ route('tricks.browse.tag', $tag->slug) }}">
                                            {{ $tag->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="clearfix">
                            @if($prev)
                                <a  href="{{ route('tricks.show', $prev->slug) }}"
                                    title="{{ $prev->title }}" data-toggle="tooltip"
                                    class="btn btn-sm btn-primary">
                                        &laquo; {{ trans('tricks.next') }}
                                </a>
                            @endif

                            @if($next)
                                <a  href="{{ route('tricks.show', $next->slug) }}"
                                    title="{{ $next->title }}" data-toggle="tooltip"
                                    class="btn btn-sm btn-primary pull-right">
                                         {{ trans('tricks.prev') }} &raquo;
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="content-box">
                <!-- 多说评论框 start -->
                    <div class="ds-thread" data-thread-key="trick.{{$trick->id}}" data-url="{{ URL::full() }}"></div>
                <!-- 多说评论框 end -->
                <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
                <script type="text/javascript">
                var duoshuoQuery = {short_name:"{{ config("services.disqus.shortname") }}"};
                    (function() {
                        var ds = document.createElement('script');
                        ds.type = 'text/javascript';ds.async = true;
                        ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
                        ds.charset = 'UTF-8';
                        (document.getElementsByTagName('head')[0]
                         || document.getElementsByTagName('body')[0]).appendChild(ds);
                    })();
                </script>
                <!-- 多说公共JS代码 end -->
                </div>
            </div>
        </div>
        {{--<div class="row">
            <div class="col-lg-12">
                <h2 class="title-between">Related tricks</h2>
            </div>
        </div>
        <div class="row">
            @for($i = 0; $i < 3; $i++)
                @include('tricks.card', [ 'test' => $i ])
            @endfor
        </div>--}}

    </div>
@stop
