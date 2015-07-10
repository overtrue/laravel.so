@extends('admin.auth.layout')

@section('content')
<div id="form-wrapper">
    <form class="form" action="{{ admin_url('auth/login') }}" method="post">
        <div class="page-header">
          <h2 class="text-center">用户登录</h2>
          @include('admin.partials.error')
          @include('admin.partials.message')
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="ion-ios-person"></i></span>
                <input type="name" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="用户名">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="ion-ios-locked-outline"></i></span>
                <input type="password" class="form-control" name="password" id="password" placeholder="密码">
            </div>
          </div>
          <div class="form-group">
            <label>
              <input type="checkbox" name="remember" class="js-switch" data-size="small"> 记住登录
            </label>
              <a href="" class="pull-right">忘记密码？</a>
          </div>
          <div class="form-group">
              <button type="submit" class="btn btn-block btn-success">登 录</button>
          </div>
    </form>
</div>
@stop