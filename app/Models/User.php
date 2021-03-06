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
            'User' => '0',
            'Organizational Admin' => '1',
            'Admin' => '2',
        ];
    }

    public static function getTypeNames()
    {
        return [
            '0' => 'User',
            '1' => 'Organizational Admin',
            '2' => 'Admin',

        ];
    }

    public static function getUserName($id)
    {
        $user = self::find($id);
        return $user->name;
    }

    public static function getUserEmail($id)
    {
        $user = self::find($id);
        return $user->email;
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

    public static function getUserPhoto($userId)
    {

        $profile = Profile::where('user_id', $userId)->first();
        if ($profile) {
            return Profile::$_uploadPath . $profile->photo;
        } else {
            return Profile::$_defaultAvatarPath;
        }

    }

    public function createdOpportunities()
    {
        return $this->hasMany(Opportunity::class,'created_by','id');
    }

}