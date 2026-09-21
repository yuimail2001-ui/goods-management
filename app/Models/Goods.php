<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goods extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tour_id',
        'name',
        'category',
        'price',
        'purchase_status',
        'purchased_at',
        'description',
        'image_path',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
