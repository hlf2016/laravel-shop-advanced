<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // 如果访问的 URL 能够匹配上 $except 里任意一项，Laravel 就不会去检查 CSRF Token
        'payment/alipay/notify',
        'payment/wechat/notify',
        'payment/wechat/refund_notify',
        'installments/alipay/notify',
        'installments/wechat/notify',
    ];
}
