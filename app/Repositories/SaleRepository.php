<?php

namespace App\Repositories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Model;

class SaleRepository extends BaseRepository
{

    protected array|null $relationships = [
        'product:sku,name,category_id',
        'product.category:id,name',
        'user:id,name,email'

    ];

    public function getModelClass(): Sale
    {
        return new Sale();
    }
}
