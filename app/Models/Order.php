<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = OrderStatus::tryFrom($status);
    }

    public function getOrderId(): int
    {
        return $this->id;
    }

    public static function getAllOrders(): Collection
    {
        return Order::orderBy("id")
            ->whereNot(function (Builder $query) {
                $query->where("status", "done");
            })
            ->get();
    }

    public function orderedItems(): HasMany
    {
        return $this->hasMany(OrderedItem::class);
    }

    public function user(): HasOne
    {
        return $this->HasOne(User::class, "id", "staff_id");
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservations::class);
    }

    public function table(): ?Table
    {
        return $this->reservation->tables->first();
    }
}
