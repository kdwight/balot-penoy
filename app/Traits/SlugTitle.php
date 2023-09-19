<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait SlugTitle
{
    protected static function bootSlugTitle()
    {
        static::created(function ($model) {
            $model->update(['slug' => $model->title ?? $model->name]);
        });

        static::updating(function ($model) {
            $model->slug =  Str::slug($model->title ?? $model->name);
        });
    }

    protected function setSlugAttribute($value)
    {
        if (static::where('id', '!=', $this->id)->whereSlug($slug = Str::slug($value))->exists()) {
            $slug = "{$slug}-{$this->id}";
        }

        $this->attributes['slug'] = $slug;
    }
}
