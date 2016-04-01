@extends('admin.layout')

@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">修改密码</h2>
    </div>
    <div class="well row">
        @include('partials.error')
        @include('partials.message')
        <form class="form-horizontal" action="{{ admin_url('users/update/'.$global->user->id) }}" method="POST">
            <div class="form-group">
                <label for="password" class="col-lg-2 control-label"><span class="text-danger">*</span> 新密码</label>
                <div class="col-lg-6">
                    <input type="password" value="" name="password" class="form-control" id="password" />
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirmnation" class="col-lg-2 control-label"><span class="text-danger">*</span> 确认密码</label>
                <div class="col-lg-6">
                    <input type="password" value="" name="password_confirmation" class="form-control" id="password_confirmnation" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-6 col-lg-offset-2">
                    <button class="btn btn-default">取消</button>
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop