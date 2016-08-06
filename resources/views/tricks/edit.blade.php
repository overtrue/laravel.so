@extends('layouts.main')

@section('title', trans('tricks.trick'))

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('js/vendor/selectize/css/selectize.bootstrap3.css') }}">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style type="text/css">
    #editor {
      border:1px solid #ddd;
      border-top:0;
    }
    textarea, #editor #input, #editor #output {
      height: 400px;
      width: 100%;
      vertical-align: top;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
      padding: 8px 10px;
      font-family: 'Monaco', courier, monospace;

    }

    #output {
      overflow: auto;
    }

    textarea {
      resize: none;
      outline: none;
      background-color: #fff;
      font-size: 14px;
      font-family: 'Monaco', courier, monospace;
      padding: 20px;
      border:1px solid #eee;
    }

    .tab-pane {
      padding:10px;
    }
    </style>
@stop

@section('scripts')
<script type="text/javascript" src="{{ asset('js/vendor/selectize/js/standalone/selectize.min.js') }}"></script>
    <script src="{{ asset('js/vendor/prism.js')}}"></script>
    <script src="{{ asset('js/vendor/ace/src-min/ace.js') }}"></script>
    <script src="{{ asset('js/vendor/ace/src-min/theme-github.js') }}"></script>
    <script src="{{ asset('js/vendor/ace/src-min/mode-php.js') }}"></script>
    <script src="{{ asset('js/vendor/ace/src-min/ext-language_tools.js') }}"></script>
    <script src="{{ asset('js/vendor/ace/src-min/snippets/php.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vendor/marked.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/trick-new-edit.min.js') }}"></script>
@stop


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 col-sm-12 col-xs-12">
                <div class="content-box">
                    @if(Auth::check() && ($frontend->user->id == $trick->user_id))
                        <div class="pull-right">
                            <a data-toggle="modal" href="#deleteModal">{{ trans('tricks.delete') }}</a>
                            @include('tricks.delete',['link' => $trick->deleteLink])
                        </div>
                    @endif
                    <h1 class="page-title">
                        {{ trans('tricks.editing_trick') }}
                    </h1>
                    @include('partials.error')
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                             <h5>{{ Session::get('success') }}</h5>
                        </div>
                    @endif
                    @form(array('class'=>'form-vertical','id'=>'save-trick-form','role'=>'form'))
                        <div class="form-group">
                            <label for="title">{{ trans('tricks.title') }}</label>
                            @text('title', $trick->title, array('class'=>'form-control','placeholder'=>trans('tricks.title_placeholder')))
                        </div>
                        <div class="form-group">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#input-wrapper" aria-controls="input-wrapper" role="tab" data-toggle="tab">{{ trans('tricks.content') }}</a></li>
                                <li role="presentation"><a href="#output-wrapper" aria-controls="output-wrapper" role="tab" data-toggle="tab">{{ trans('tricks.preview') }}</a></li>
                              </ul>
                            <div id="editor">
                              <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="input-wrapper">
                                  <div id="content" style="height:400px"></div>
                                  @textarea('content', $trick->content, array('placeholder'=>trans('tricks.trick_content_placeholder'),'rows'=>'3','id' => 'input', 'class' => 'hide'))
                                </div>
                                <div role="tabpanel" class="tab-pane" id="output-wrapper">
                                  <div id="output"></div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @select('tags[]', $tagList, $selectedTags, array('multiple','id'=>'tags','placeholder'=>trans('tricks.tag_trick_placeholder'),'class' => 'form-control'))
                        </div>
                        <div class="form-group">
                            @select('categories[]', $categoryList, $selectedCategories, array('multiple','id'=>'categories','placeholder'=>trans('tricks.categorize_trick_placeholder'),'class' => 'form-control'))
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    @checkbox('is_draft', null, $trick->is_draft, array('id'=>'draft', 'class'=>'form-control'))
                                    <span class="checkbox__label">{{ trans('tricks.is_draft') }}</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-right">
                              <button type="submit"  id="save-section" class="btn btn-primary ladda-button" data-style="expand-right">
                                {{ trans('tricks.update_trick') }}
                              </button>
                            </div>
                        </div>
                    @endform
                </div>
            </div>
        </div>
    </div>
@stop
