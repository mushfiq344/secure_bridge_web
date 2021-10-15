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

        return array_values($usersList->toArray());
    }

    public static function totalUnreadMessagesSentFromUser($id)
    {

        return self::where('from', $id)->where('to', auth()->user()->id)->where('is_read', 0)->count();
    }

    public static function unreadMessagesSentFromUserExists($id)
    {

        return self::where('from', $id)->where('to', auth()->user()->id)->where('is_read', 0)->exists();
    }
}