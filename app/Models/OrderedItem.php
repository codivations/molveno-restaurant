<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Collection;

class OrderedItem extends Model
{
    protected $table = "orders_items";

    use HasFactory;

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = OrderStatus::tryFrom($status);
    }

    public static function getAllOrderedItems(): Collection
    {
        return OrderedItem::orderBy("order_id")->get();
    }

    public function item(): HasOne
    {
        return $this->hasOne(Item::class, "id", "menu_item_id");
    }
}
