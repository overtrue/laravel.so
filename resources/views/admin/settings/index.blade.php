@extends('admin.layout')

@section('content')
<div class="console-content">
    <div class="page-header">
        <h2 id="nav">系统设置</h2>
    </div>
    <div class="well bs-component">
        <form class="form-horizontal">
            <fieldset>
                <legend>SEO</legend>
                <div class="form-group">
                    <label for="site_name" class="col-lg-2 control-label">网站名称</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="site_name" placeholder="例如：Laravel.so">
                    </div>
                </div>
                <div class="form-group">
                    <label for="site_title" class="col-lg-2 control-label">副标题</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="site_title" placeholder="例如：Laravel教程，技巧分享... 10-15字左右">
                    </div>
                </div>
                <div class="form-group">
                    <label for="site_keywords" class="col-lg-2 control-label">SEO关键字</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="site_keywords" placeholder="80字左右">
                    </div>
                </div>
                <div class="form-group">
                    <label for="site_description" class="col-lg-2 control-label">SEO描述</label>
                    <div class="col-lg-10">
                        <textarea class="form-control" id="site_description"  placeholder="120字以内，80字左右最佳"></textarea>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>联系方式</legend>
                <div class="form-group">
                    <label for="site_tel" class="col-lg-2 control-label">电话</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="site_tel" placeholder="80字左右">
                    </div>
                </div>
                <div class="form-group">
                    <label for="site_email" class="col-lg-2 control-label">邮箱</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="site_email" placeholder="80字左右">
                    </div>
                </div>
            </fieldset>
             <fieldset>
                <legend>统计代码</legend>
                <div class="form-group">
                    <label for="site_tel" class="col-lg-2 control-label"></label>
                    <div class="col-lg-10">
                        <textarea name="site_anaylsis_code" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button class="btn btn-default">取消</button>
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection