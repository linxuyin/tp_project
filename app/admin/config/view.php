<?php

return [
    // 静态资源
    'tpl_replace_string' => [
        '__CSS__'   => './../../static/admin/css',
        '__JS__'    => './../../static/admin/js',
        '__IMG__'    => './../../static/admin/img',
    ],

    // 是否开启模板编译缓存,设为false则每次都会重新编译
    'tpl_cache'          => false,

];