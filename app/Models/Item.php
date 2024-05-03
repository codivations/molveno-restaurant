<?php

namespace App\Models;

use App\Enums\ItemCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["name", "description", "price", "category"];

    public function getCategory(): ItemCategory
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = ItemCategory::tryFrom($category);
    }

    public function getPrice(): string
    {
        $priceWithCents = $this->price / 100;

        return "€ " . number_format($priceWithCents, 2);
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, "menus_items");
    }

    public function orderedItems(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, "orders_items");
    }
}
