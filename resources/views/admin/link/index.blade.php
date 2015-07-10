@extends('admin.layout')

@section('content')
<div class="console-content">
    <div class="page-header">
        <h2>友情链接 <a href="{{ admin_url('links/create') }}" class="btn btn-xs btn-info">新建链接</a></h2>
    </div>
    <div class="well">
        @include('partials.error')
        @include('partials.message')
        <table class="table table-wechat">
            <thead>
                <tr>
                    <td>名称</td>
                    <td>网址</td>
                    <td>添加时间</td>
                    <td>操作</td>
                </tr>
            </thead>
            <tbody>
                @unless(!$links->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">无数据</td>
                </tr>
                @endunless
                @foreach($links as $link)
                <tr>
                    <td>{{ $link->name }}</td>
                    <td><a href="{{ $link->url }}" target="_blank">{{ $link->url }}</a></td>
                    <td>{{ $link->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ admin_url('links/'.$link->id.'/edit') }}" class="btn btn-xs btn-info" >编辑</a>
                        <a href="{{ admin_url('links/'.$link->id) }}" class="btn btn-xs btn-danger" method="DELETE">删除</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr><td colspan="4">{!! $links->render() !!}</td></tr>
            </tfoot>
        </table>
    </div>
</div>
@stop