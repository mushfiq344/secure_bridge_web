<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public static $_uploadPath = 'uploads/images/users/';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getTypes()
    {
        return [
            'generic' => '0',
            'startup' => '1',
            'mentor' => '2',
            'investor' => '3',
            'admin' => '4',
        ];
    }

    public static function getTypeNames()
    {
        return [
            '0' => 'generic',
            '1' => 'startup',
            '2' => 'mentor',
            '3' => 'investor',
            '4' => 'admin',
        ];
    }

    public static function getUserName($id)
    {
        $user = self::find($id);
        return $user->name;
    }

    public function opportunities()
    {
        return $this->belongsToMany(Opportunity::class);
    }

    public function wishes()
    {
        return $this->belongsToMany(Opportunity::class, 'wish_list', 'user_id', 'opportunity_id');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

}