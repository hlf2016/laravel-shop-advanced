<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidRequestException extends Exception
{
    public function __construct(string $message = '', int $code = 400)
    {
        parent::__construct($message, $code);
    }

    public function render(Request $request)
    {
        // 判断是否为ajax请求，是的话 返回json，否则返回 错误页面
        if ($request->expectsJson()) {
            return response()->json(['msg' => $this->message], $this->code);
        }
        return view('pages.error', ['msg' => $this->message]);
    }
}
