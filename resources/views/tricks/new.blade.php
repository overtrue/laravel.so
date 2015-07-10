@extends('layouts.main')

@section('title', trans('tricks.trick'))

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('js/vendor/selectize/css/selectize.bootstrap3.css') }}">
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
    <script src="{{ asset('js/prism.js')}}"></script>
    <script src="{{ asset('js/vendor/ace/src-min/ace.js') }}"></script>
    <script src="{{ asset('js/vendor/ace/src-min/theme-github.js') }}"></script>
    <script src="{{ asset('js/vendor/ace/src-min/mode-php.js') }}"></script>
    <script src="{{ asset('js/vendor/ace/src-min/ext-language_tools.js') }}"></script>
    <script src="{{ asset('js/vendor/ace/src-min/snippets/php.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/marked.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/trick-new-edit.min.js') }}"></script>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 col-sm-12 col-xs-12">
                <div class="content-box">
                    <h1 class="page-title">
                        {{ trans('tricks.creating_new_trick') }}
                    </h1>
                    @include('partials.error')
                    @form(array('class'=>'form-vertical','id'=>'save-trick-form','role'=>'form'))
                        <div class="form-group">
                            <label for="title">{{ trans('tricks.title') }}</label>
                            @text('title', null, array('class'=>'form-control','placeholder' => trans('tricks.title_placeholder')))
                        </div>
                        <div class="form-group">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#input-wrapper" aria-controls="home" role="tab" data-toggle="tab">{{ trans('tricks.content') }}</a></li>
                                <li role="presentation"><a href="#output-wrapper" aria-controls="home" role="tab" data-toggle="tab">{{ trans('tricks.preview') }}</a></li>
                              </ul>
                            <div id="editor">
                              <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="input-wrapper">
                                  <div id="content" style="height:400px"></div>
                                  @textarea('content',null, array('placeholder'=>trans('tricks.trick_content_placeholder'),'rows'=>'3','id' => 'input', 'class' => 'hide'))
                                </div>
                                <div role="tabpanel" class="tab-pane" id="output-wrapper">
                                  <div id="output"></div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <p>@select('tags[]', $tagList, null, array('multiple','id'=>'tags','placeholder'=>trans('tricks.tag_trick_placeholder'),'class' => 'form-control'))</p>
                        </div>
                        <div class="form-group">
                            <p>@select('categories[]', $categoryList, null, array('multiple','id'=>'categories','placeholder'=>trans('tricks.categorize_trick_placeholder'),'class' => 'form-control'))</p>
                        </div>
                        <div class="form-group">
                            <div class="text-right">
                              <button type="submit"  id="save-section" class="btn btn-primary ladda-button" data-style="expand-right">
                                {{ trans('tricks.save_trick') }}
                              </button>
                            </div>
                        </div>
                    @endform
                </div>
            </div>
        </div>
    </div>
@stop
