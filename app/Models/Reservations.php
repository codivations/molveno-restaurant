<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    use HasFactory;

    public function table(): BelongsToMany
    {
        return $this->belongsToMany(Table::class, "seated_reservation");
    }
}
