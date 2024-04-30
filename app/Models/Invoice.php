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

    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
