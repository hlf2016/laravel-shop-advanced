<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ProductSku;

class AddCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku_id' => [
                'required',
                function($attribute, $value, $fail) {
                    if(!$sku = ProductSku::find($value)) {
                        $fail('商品不存在');
                        return;
                    }
                    if(!$sku->product->on_sale) {
                        $fail('商品未上架');
                        return;
                    }
                    if($sku->stock == 0) {
                        $fail('该商品已售空');
                        return;
                    }
                    $amount = $this->input('amount');
                    if($amount > 0 && $sku->stock < $amount) {
                        $fail('该商品库存不足');
                        return;
                    }
                }
            ],
            'amount' => ['required', 'integer', 'min:1']
        ];
    }

    public function attributes()
    {
        return[
            'amount' => '商品数量'
        ];
    }

    public function messages()
    {
        return [
            'sku_id.required' => '请选择商品'
        ];
    }
}
