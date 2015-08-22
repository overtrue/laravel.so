<div id="footer">
  <div class="container">
    <div class="text-muted row credit">
        <div class="col-md-4 links">
            <label for="">合作伙伴</label>
            @foreach(trans('partials.friends_links') as $label => $url)
                ・ <a href="{{ $url }}" target="_blank" title="{{$label}}"> {{$label}} </a>
            @endforeach
        </div>
        <div class="col-md-4 visible-lg-block">
            <div class="sns-share">
                <a href="" class="qzone"><i class="icon iconfont icon-qzone"></i></a>
                <a href="" class="qq"><i class="icon iconfont icon-qq"></i></a>
                <a href="" class="weibo"><i class="icon iconfont icon-weibo"></i></a>
                <a href="" class="wechat"><i class="icon iconfont icon-wechat"></i></a>
                <a href="" class="douban"><i class="icon iconfont icon-douban"></i></a>
            </div>
        </div>
        <div class="col-md-4 about"> {!! trans('partials.credits') !!} ・ <a href="{{ url('about') }}"> {!! trans('partials.about') !!} </a> ・ {!! trans('partials.footer_links') !!} </div>
    </div>
  </div>
</div>
