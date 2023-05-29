<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const ADMIN = 1;
    public const EDITOR = 2;

    use HasFactory;

    /**
     * Genera el string requerido para usar el middleware hasRole evitando errores
     *
     * @param ...$roles
     * @return string
     */
    public static function stringMiddleware(...$roles): string
    {
        return 'hasRole:' . implode('|', $roles);
    }
}
