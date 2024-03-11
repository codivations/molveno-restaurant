<?php

namespace App\Models;

use App\Enums\MenuService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ["service"];

    public function getService(): MenuService
    {
        return $this->service;
    }

    public function setService(string $service): void
    {
        $this->service = MenuService::tryFrom($service);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, "menus_items");
    }
}
