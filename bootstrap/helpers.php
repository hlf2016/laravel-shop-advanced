<?php

// 将路由转化为每个页面的css类名
function route_class()
{
    return str_replace('.','-', Route::currentRouteName());
}