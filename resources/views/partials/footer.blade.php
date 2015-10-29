<div id="footer">
  <div class="container">
    <div class="text-muted row credit">
        <div class="col-md-7 links">
            <label for="">合作伙伴</label>
            @foreach(trans('partials.friends_links') as $label => $url)
                ・ <a href="{{ $url }}" target="_blank" title="{{$label}}"> {{$label}} </a>
            @endforeach
        </div>
        <div class="col-md-5 about"> {!! trans('partials.credits') !!} ・ <a href="{{ url('about') }}"> {!! trans('partials.about') !!} </a> ・ {!! trans('partials.footer_links') !!} </div>
    </div>
  </div>
</div>
