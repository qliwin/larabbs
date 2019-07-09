<?php

function route_class()
{
    return Route::currentRouteName();
}

function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

// 生成摘要
function make_excerpt($value, $length = 200)
{
    // strip_tags:从字符串中去除 HTML 和 PHP 标记
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}
