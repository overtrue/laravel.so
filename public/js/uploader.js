(function(){
    var $Uploader,
        $uploadUrl = '/admin/upload/image',
        $filters = {
        image: {
            mime_types : [
                { title : "图片", extensions : "bmp, png, jpeg, jpg, gif" },
            ],
            max_file_size: "2mb"
        },
        video: {
            mime_types : [
                { title : "视频", extensions : "rm, rmvb, wmv, avi, mpg, mpeg, mp4" },
            ],
            max_file_size: "20mb"
        },
        voice: {
            mime_types : [
                { title : "语音", extensions : "mp3, wma, wav, amr" },
            ],
            max_file_size: "5mb"
        },
    };

    /**
     * 创建上传信息窗口
     *
     * @return {Object}
     */
    function createQueueContainer ($button) {
        var $position = $($button).offset();
        var $buttonWidth = $($button).width();

        $('#uploader-upload-container').remove();

        $('body').append('<div id="uploader-upload-container"></div>');

        var $container = $('#uploader-upload-container');
        var $windowWith = $(window).width();

        if ($position.left > ($windowWith/2)) {
            $position.left -= $container.width() + 20;
        };

        $container.css({position:"absolute", top: $position.top + $($button).height() + 20, left: $position.left, display:'none'});

        return $container;
    }

    $Uploader = {
        /**
         * 创建一个上传器
         *
         * @param {String} $buttonSelector
         * @param {String} $type
         *
         * @return {plupload.Uploader}
         */
        make: function($buttonSelector, $type, $options){
            var $button = $($buttonSelector).get(0);
            var $callback = $options.callback || function($resp){ console.log('Uploaded:'. $resp) };

            if (!$button) {
                return console.error('Button "'+ $buttonSelector + '" not found.');
            };

            var $up = new plupload.Uploader({
                    browse_button: $button,
                    url: $uploadUrl,
                    file_data_name: 'file',
                    multipart: $options.multipart || true,
                });
            var $container = createQueueContainer($buttonSelector);

            // init
            $up.init();

            // 添加完文件
            $up.bind('FilesAdded', function(up, files) {
                $container.show();
                plupload.each(files, function(file) {
                    var $filename = file.name.length > 12 ? '...' + file.name.substr(-11) : file.name;
                    $container.append('<div id="' + file.id + '" class="uploader-file-item"><div class="uploader-filename"><span>' + $filename + ' (' + plupload.formatSize(file.size) + ') </span></div><div class="uploader-upload-progress"><div class="uploader-upload-progress-bar"></div></div></div>');
});
              // 自动上传
              $up.start();
            });

            // 上传中
            $up.bind('UploadProgress', function(up, file) {
                $('#' + file.id + ' .uploader-upload-progress-bar').css('width', file.percent + '%');
            });

            // 上传完一个文件
            $up.bind('FileUploaded', function(up, file, response) {
                console.log('uploaded:');
                console.log(eval('(' + response.response + ')'));
                $callback(eval('(' + response.response + ')'), file);
                $('#' + file.id).animate({opacity: 0}, 400, function() {
                        $('#' + file.id).animate({opacity: 1},
                            400, function() {
                            $('#' + file.id).slideUp(300, function(){
                            });
                        });
                });
            });

            // 全部上传完成
            $up.bind('UploadComplete', function(up, file, response) {
                $container.remove();
            });

            // 上传失败
            $up.bind('Error', function(up, err) {
                $('#' + err.file.id + ' .uploader-upload-progress-bar').css({width:'100%', background:'red'});
            });

            return $up;
        }
    }

    return window.uploader = $Uploader;
})();