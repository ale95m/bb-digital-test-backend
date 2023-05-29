<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository
{

    protected array|null $relationships = [
        'category:id,name',
        'images:id,url,product_sku',
        'tags:id,name'
    ];

    protected array $filters = [
        'sku',
        'name:like',
        'description:like',
        'additional_information:like',
        'price', 'price:>', 'price:<',
        'stock', 'stock:>', 'stock:<',
        'category_id',
        'category->name:like',
        'images->url:like',
        'tags->name:like'
    ];

    public function getModelClass(): Product
    {
        return new Product();
    }

    public function update(Model $model, array $data): Model
    {
        unset($data['sku']);
        return parent::update($model, $data);
    }

}
