<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Category
 *
 * @mixin Builder
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $keyType = 'string';
    protected $casts = ['id' => 'string'];
    public $timestamps = false;

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }

    function products(): HasMany {
        return $this->hasMany(Product::class);
    }

}
