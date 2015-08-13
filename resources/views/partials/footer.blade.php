<div id="footer">
  <div class="container">
    <p class="text-muted credit">
    <span><label for="">合作伙伴：</label>
        @foreach(trans('partials.friends_links') as $label => $url)
            <a href="{{ $url }}" target="_blank" title="{{$label}}">{{$label}}</a>
        @endforeach
    </span>
    <span class="pull-right">{!! trans('partials.credits') !!} | <a href="{{ url('about') }}">{!! trans('partials.about') !!}</a> | {!! trans('partials.footer_links') !!}</span>
    </p>

  </div>
</div>
