<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'province',
        'city',
        'district',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at'
    ];

    // 表示last_used_at是一个时间日期类型的字段，$address->last_used_at 返回的是一个时间日期类型的对象，也就是一个Carbon对象
    protected $dates = ['last_used_at'];

    // User 模型关联，关联关系是一对多（一个 User 可以有多个 UserAddress，一个 UserAddress 只能属于一个 User）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 访问器  直接返回完整地址 无需次次拼接
    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}
