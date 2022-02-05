<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalOfficePic extends BaseModel
{
    use HasFactory;

    const STATUS_0 = 0;
    const STATUS_1 = 1;
    const STATUS_2 = 2;

    protected $table = 'technical_office_pics';
    
    protected $dateFormat = 'U';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    //均可批量赋值
    protected $guarded = [];
}
