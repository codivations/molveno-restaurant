<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["name", "login_name", "password"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "password" => "hashed",
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, "users_roles");
    }

    public function hasRole(array $roleList = []): bool
    {
        $userRoles = $this->getRoles();
        $roleMatches = array_intersect($roleList, $userRoles);

        if (in_array("admin", $userRoles) || !empty($roleMatches)) {
            return true;
        }

        return false;
    }

    private function getRoles(): array
    {
        $roleList = [];

        foreach ($this->roles as $role) {
            array_push($roleList, $role->name);
        }

        return $roleList;
    }
}
