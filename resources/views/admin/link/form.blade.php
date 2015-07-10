@extends('admin.layout')

@section('content')
<div class="console-content">
    <div class="well bs-component">
        @include('partials.error')
        @include('partials.message')
        <form class="form-horizontal" action="{{ admin_url(isset($link) ? 'links/'.$link->id : 'links') }}" method="POST">
            <fieldset>
                <legend>{{ isset($link) ? '编辑':'新建' }}友情链接</legend>
                <div class="form-group">
                    <label for="name" class="col-lg-2 control-label"><span class="text-danger">*</span> 名称</label>
                    <div class="col-lg-8">
                        <input type="text" value="{{ old('name', isset($link) ? $link->name : '') }}" name="name" class="form-control" id="name" placeholder="ex：海外医疗导航" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="url" class="col-lg-2 control-label"><span class="text-danger">*</span> 网址</label>
                    <div class="col-lg-8">
                        <input type="text" value="{{ old('url', isset($link) ? $link->url : '') }}" name="url" class="form-control" id="url" placeholder="ex：http://www.goyiliao.com" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-8 col-lg-offset-2">
                        @if(isset($link))
                        <input type="hidden" name="_method" value="PATCH">
                        @endif
                        <button class="btn btn-default">取消</button>
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@stop