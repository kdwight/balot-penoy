<?php

namespace App\Models;

use App\Traits\SlugTitle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory, SlugTitle;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $with = ['items'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function items()
    {
        return $this->hasMany(TodoItem::class);
    }
}
