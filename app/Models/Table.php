<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Reservations;

class Table extends Model
{
    use HasFactory;

    protected $table = "tables";

    public function seated(): HasOne
    {
        return $this->hasOne(Reservations::class, "id");
    }
}
