<div class="row trick-container">
    @if($tricks->count())
        @foreach($tricks as $trick)
            @include('tricks.card', [ 'trick' => $trick ])
        @endforeach
    @else
        <div class="col-lg-12">
            <div class="alert alert-danger">
                {{ trans('tricks.no_tricks_found') }}
            </div>
        </div>
    @endif
</div>
@if($tricks->count())
    <div class="row">
        <div class="col-md-12 text-center">
            @if(isset($appends))
                {!! $tricks->appends($appends)->render(); !!}
            @else
                {!! $tricks->render(); !!}
            @endif
        </div>
    </div>
@endif
