<?php

/**
 * helpers.php.
 *
 * 工具函数
 *
 * @author overtrue <i@overtrue.me>
 */
function admin_url($uri)
{
    return url('dashboard/'.$uri);
}

function admin_view($name)
{
    $args = func_get_args();
    $args[0] = 'admin.'.$name;

    return call_user_func_array('view', $args);
}

function image($path)
{
    return url(config('image.prefix').'/'.$path);
}

function least($type, $items)
{
    foreach ($items as $item) {
        if (gettype($item) == $type) {
            return $item;
        }
    }
}
