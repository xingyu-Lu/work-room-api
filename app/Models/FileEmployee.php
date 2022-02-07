<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\UploadFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileEmployee extends BaseModel
{
    use HasFactory;

    const STATUS_0 = 0;
    const STATUS_1 = 1;

    protected $table = 'file_employees';
    
    protected $dateFormat = 'U';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    //均可批量赋值
    protected $guarded = [];

    public function files()
    {
        return $this->belongsTo(UploadFile::class, 'file_id');
    }
}
