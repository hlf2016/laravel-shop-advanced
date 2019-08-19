<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CouponCodeUnavailableException;
use App\Models\CouponCode;

class CouponCodesController extends Controller
{
    public function show($code, Request $request)
    {
        if (!$record = CouponCode::where('code', $code)->first()) {
            // abort() 方法可以直接中断我们程序的运行，接受的参数会变成 Http 状态码返回。在这里如果用户输入的优惠码不存在或者是没有启用我们就返回 404 给用户。
            throw new CouponCodeUnavailableException('该优惠券不存在');
        }

        $record->checkAvailable($request->user());

        return $record;
    }
}
