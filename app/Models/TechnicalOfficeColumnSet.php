<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalOfficeColumnSet extends BaseModel
{
    use HasFactory;

    protected $table = 'technical_office_column_sets';
    
    protected $dateFormat = 'U';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    //均可批量赋值
    protected $guarded = [];
}
