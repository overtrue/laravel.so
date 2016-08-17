@extends('admin.layout')

@section('content')
    <div class="console-content">
        <div class="page-header">
            <h2>所有技巧 <a href="{{ url('/user/tricks/new') }}" class="btn btn-xs btn-info">新建技巧</a></h2>
        </div>
        <div class="well">
            @include('partials.error')
            @include('partials.message')
            <table class="table table-wechat">
                <thead>
                <tr>
                    <td>标题</td>
                    <td>作者</td>
                    <td>浏览数</td>
                    <td>添加时间</td>
                    <td>操作</td>
                </tr>
                </thead>
                <tbody>
                    @unless(!$tricks->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">无数据</td>
                    </tr>
                    @endunless
                    @foreach($tricks as $trick)
                        <tr>
                            <td>{{ $trick->title }}</td>
                            <td>{{ $trick->user->username }}</td>
                            <td>{{ $trick->view_cache }}</td>
                            <td>{{ $trick->created_at }}</td>
                            <td>
                                <a href="{{ url('/user/tricks', ['slug' => $trick->slug]) }}" class="btn btn-default btn-xs">编辑</a>
                                <a href="javascript:;" class="btn btn-danger btn-xs" onclick="deleteTrick({{ $trick->id }})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr><td colspan="5">{!! $tricks->render() !!}</td></tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        function deleteTrick(id) {
            var url = '{{ admin_url('tricks') }}' + '/' + id;
            console.log(url);
            $.ajax({
                type: 'DELETE',
                url : url,
                success: function (data) {
                    if (data) {
                        location.href = '{{ admin_url('tricks')  }}';
                    }
                }
            });
        }
    </script>
@stop
