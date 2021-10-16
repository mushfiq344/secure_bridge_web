<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public static $_uploadPath = 'uploads/images/profiles/';
    public static $_defaultAvatarPath = 'images/static_images/default_avatar.png';
    use HasFactory;
}