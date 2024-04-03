<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use App\Models\OrderedItem;

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

    public static function getAllOrders(): Collection
    {
        return Order::orderBy("id")->get();
    }

    public function orderedItems(): HasMany
    {
        return $this->hasMany(OrderedItem::class);
    }
}
