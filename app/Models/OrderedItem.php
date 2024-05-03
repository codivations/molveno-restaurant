<?php

namespace App\Models;

use App\Enums\ItemStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderedItem extends Model
{
    use HasFactory;

    protected $table = "orders_items";

    public function getStatus(): ItemStatus
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = ItemStatus::tryFrom($status);
    }

    public function getOrderedItemId()
    {
        return $this->id;
    }

    public static function getAllOrderedItems(): Collection
    {
        return OrderedItem::orderBy("order_id")->get();
    }

    public function item(): HasOne
    {
        return $this->hasOne(Item::class, "id", "menu_item_id");
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, "order_id");
    }
}
