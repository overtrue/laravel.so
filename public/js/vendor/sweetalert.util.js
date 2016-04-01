var defaultTimer = 2000;

/**
 * 成功消息
 *
 * @param {String} title
 * @param {String} message
 * @param {Integer} timer
 *
 * @return {boolean}
 */
function success(title, message, timer) {
    return swal({
            title: title,
            text: message,
            type: "success",
            html: true,
            timer: timer || defaultTimer
        });
}

/**
 * 普通消息
 *
 * @param {String} title
 * @param {String} message
 * @param {Integer} timer
 *
 * @return {boolean}
 */
function info(title, message, timer) {
    return swal({
            title: title,
            text: message,
            type: "info",
            html: true,
            timer: timer || defaultTimer
        });
}

/**
 * 失败消息
 *
 * @param {String} title
 * @param {String} message
 * @param {Integer} timer
 *
 * @return {boolean}
 */
function error(title, message, timer) {
    return swal({
            title: title,
            text: message,
            type: "error",
            html: true,
            timer: timer || defaultTimer
        });
}

/**
 * 警告消息
 *
 * @param {String}   title
 * @param {String}   message
 * @param {Function} callback
 * @param {String}   confirmButtonText
 * @param {Boolean}  closeOnConfirm
 * @param {Boolean}  showCancelButton
 *
 * @return {Boolean}
 */
function warning(title, message, callback, confirmButtonText, closeOnConfirm, showCancelButton) {
    return swal({
        title: title,
        text: message,
        type: "warning",
        showCancelButton: showCancelButton,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: confirmButtonText || 'OK，没问题！',
        closeOnConfirm: closeOnConfirm,
        html: true
    }, callback);
}

/**
 * 自动关闭
 *
 * @param {String}  title
 * @param {String}  message
 * @param {Integer} timer
 *
 * @return {boolean}
 */
function flush(title, message, timer) {
    return swal({   title: title,   text: message,   timer: timer || 2000 });
}

window.alert = function(string){
    swal('' + string);
};

window.confirm = function(title){
    sweetAlert({
        title: title,
        showCancelButton: true,
        confirmButtonText: '确认',
        cancelButtonText: '取消'
    }, function() {
        if (window.event && window.event.toElement) {
            var btn = $(window.event.toElement);
            window.location.href=btn.attr('href');
        };
    });

    return false;
};