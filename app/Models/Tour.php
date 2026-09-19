<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'description',
    ];

    public function goods(): HasMany
    {
        return $this->hasMany(Goods::class);
    }

    public function tradingCards(): HasMany
    {
        return $this->hasMany(TradingCard::class);
    }
}
