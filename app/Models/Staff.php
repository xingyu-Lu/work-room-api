<?php

namespace App\Models;

use App\Models\TechnicalOffice;
use App\Models\TechnicalOfficeMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Staff extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasFactory;

    const STATUS_0 = 0;
    const STATUS_1 = 1;
    const STATUS_2 = 2;

    protected $table = 'staffs';

    protected $guard_name = 'h-api';
    
    protected $dateFormat = 'U';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    //均可批量赋值
    protected $guarded = [];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function guardName()
    {
        return $this->guard_name;
    }

    public function office()
    {
        return $this->belongsTo(TechnicalOfficeMember::class, 'id', 'staff_id');
    }
}
