(function(){
    window.__page = 0;

    // 后台基础 URI
    var baseURI = baseURI || '/admin/';
    var util = {
        // 生成后台uri
        // example: /admin/user
        makeUri: function(uri){
            if(0 === uri.indexOf('http://')){
                return uri;
            }
            return baseURI.trim('/') + uri;
        },

        // 表单错误
        formError: function($obj, $errors) {
            $obj.find('.has-error').removeClass('has-error');
            _.mapObject($errors, function(msg, field) {
                var formInput = $obj.find('[name='+field+']');
                formInput.siblings('span.help-block').remove();
                formInput.after('<span class="help-block red">'+msg+'</span>');
                formInput.closest('.form-group').addClass('has-error');
            });
        },

        // ajax 请求
        request: function($method, $uri, $data, $success, $error){
            var params = {
                url: util.makeUri($uri),
                type: $method || 'GET',
                dataType: 'json',
                data: $data,
            };

            var success = function($resp){
                window.last_response = $resp;

                console.log('request success:' + params.url, $resp);

                if (typeof $resp['current_page'] != 'undefined') {
                    window.__page = $resp.current_page;
                    $resp = $resp.data;
                };

                if (typeof $success == 'function') {
                    $success($resp);
                };
            };

            var err = function($err){
                window.last_response = $err;

                error('网络错误...', $err.status + ' ' + $err.statusText);

                console.log('request error:', $err);

                if (typeof $error == 'function') {
                    $error($err);
                }
            };

            $('.loading').show();

            console.log('request begin:', params);

            $.ajax(params).done(success).fail(err).always(function() {
                console.log('request finished:', params.url);
                $('.loading').hide();
            });
        },

        // 获取表单内的值对象
        parseForm: function (form) {
            var formdata = form.serializeArray();

            var data = {};

            _.each(formdata, function (element) {

                var value = _.values(element);

                // Parsing field arrays.
                if (value[0].indexOf('[]') > 0) {
                    var key = value[0].replace('[]', '');

                    if (!data[key])
                        data[key] = [];

                    data[value[0].replace('[]', '')].push(value[1]);
                } else

                // Parsing nested objects.
                if (value[0].indexOf('.') > 0) {

                    var parent = value[0].substring(0, value[0].indexOf("."));
                    var child = value[0].substring(value[0].lastIndexOf(".") + 1);

                    if (!data[parent])
                        data[parent] = {};

                    data[parent][child] = value[1];
                } else {
                    data[value[0]] = value[1];
                }
            });

            return data;
        },
    };


    return window.Util = util;
})();