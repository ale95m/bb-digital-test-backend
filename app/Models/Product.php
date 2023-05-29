<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use voku\helper\ASCII;

/**
 * @property double stock
 * @property string sku
 * @property double price
 */
class Product extends Model
{
    use HasFactory/*, SoftDeletes*/;

    protected $primaryKey = 'sku';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'sku' => 'string',
    ];

    protected $relations = [
        'category',
        'images',
        'tags'
    ];

    protected $fillable = [
        'sku',
        'name',
        'description',
        'additional_information',
        'price',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function addStock($amount): void
    {
        DB::beginTransaction();
        $this->stock += $amount;
        $this->save();
        DB::commit();;
    }

    /**
     * @throws \Exception
     */
    public function removeStock($amount): void
    {
        DB::beginTransaction();
        if ($amount > $this->stock) {
            throw new \Exception(trans('messages.products.insufficient_stock'));
        }
        $this->stock -= $amount;
        $this->save();
        DB::commit();;
    }

    /**
     * @throws \Exception
     */
    public function sell($amount)
    {
        $this->removeStock($amount);
        Sale::query()->create([
            'product_sku' => $this->sku,
            'user_id' => Auth::id(),
            'amount' => $amount,
            'income' => $amount * $this->price
        ]);
    }
}
