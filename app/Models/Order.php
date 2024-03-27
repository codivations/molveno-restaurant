<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Order extends Model
{
    protected $table = "orders";

    use HasFactory;

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
        return Order::orderBy("created_at")->get();
    }
}
