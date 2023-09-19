<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'completed' => 'datetime',
        'exp_date' => 'date:Y-m-d',
    ];

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
