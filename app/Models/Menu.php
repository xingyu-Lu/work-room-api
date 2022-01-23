<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    const IS_ENABLED_0 = 0;//不启用
    const IS_ENABLED_1 = 1;//启用

    protected $table = 'menus';

    protected $dateFormat = 'U';

    //均可批量赋值
    protected $guarded = [];
}
