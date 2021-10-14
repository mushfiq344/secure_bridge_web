<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public static function messageIds()
    {
        $fromIds = self::orWhere('to', auth()->user()->id)->orWhere('from', auth()->user()->id)->distinct()->pluck('from')->toArray();
        $toIds = self::orWhere('to', auth()->user()->id)->orWhere('from', auth()->user()->id)->distinct()->pluck('to')->toArray();
        $usersList = collect(array_merge($fromIds, $toIds))->unique();
        $usersList = $usersList->reject(function ($element) {
            return $element == auth()->user()->id;
        });
        return $usersList->implode(',');
    }

    public static function lastMessageCreatedAt($id)
    {

        return self::where('from', $id)->where('to', auth()->user()->id)->max('id');
    }
}