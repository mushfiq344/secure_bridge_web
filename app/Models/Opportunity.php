<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;
    public static $_uploadPath = 'uploads/images/opportunities/';
    protected $table = "opportunities";

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}