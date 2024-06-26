<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Table extends Model
{
    use HasFactory;

    protected $table = "tables";

    public function seated(): HasOne
    {
        return $this->hasOne(Reservations::class, "id", "seated_reservation");
    }

    public function unseatReservation(): void
    {
        $this->seated_reservation = null;
        $this->save();
        return;
    }
}
