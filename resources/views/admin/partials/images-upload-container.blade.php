<div class="form-group">
    <div class="col-lg-2"></div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">图片</div>
            <div class="panel-body images-container">
                @if($images = old('images', isset($object) ? $object->images->lists('path') : []))
                    @foreach($images as $image)
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <img src="{{ image($image) }}" alt="" class="img-responsive">
                            <input type="hidden" name="images[]" value="{{ $image }}">
                            <div class="control">
                                <a href="#" class="btn btn-danger btn-block delete">删除</a></div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="panel-footer">
                <button class="btn btn-info upload-image">选择图片</button>
            </div>
        </div>
    </div>
</div>