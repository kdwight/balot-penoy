<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'pages', 'description'];
    protected $casts = [
        'pages' => 'array',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_replace(' ', '-', $value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ucwords($value);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
