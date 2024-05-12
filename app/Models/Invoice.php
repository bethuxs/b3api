<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public static function generateNumber(User $user)
    {
        $last = static::where('user_id', $user->id)->orderBy('number', 'desc')->first();
        return $last ? $last->number + 1 : 1;
    }
}
