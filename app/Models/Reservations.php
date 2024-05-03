<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservations extends Model
{
    use HasFactory;

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class, "seated_reservation");
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, "reservation_id");
    }
}
