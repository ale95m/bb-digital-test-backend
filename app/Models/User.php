<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    function getToken(): string
    {
        return $this->createToken(env('APP_NAME'))->plainTextToken;
    }

    function removeToken(): ?bool
    {
        return $this->tokens()->delete();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }


    /**
     *  Returns true if the worker has a specific role
     * @param $role int|string
     * @return bool
     */
    public function hasRole(int|string $role): bool
    {
        return $this->roles()->where(is_numeric($role) ? 'roles.id' : 'roles.name', $role)->exists();
    }
}
