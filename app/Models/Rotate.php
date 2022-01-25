<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rotate extends Model
{
    use HasFactory;

    const STATUS_0 = 0;//禁用
    const STATUS_1 = 1;//启用

    protected $table = 'rotates';
    
    protected $dateFormat = 'U';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    //均可批量赋值
    protected $guarded = [];
}
