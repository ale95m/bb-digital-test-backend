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

    public function create(array $data): Model
    {
        $product = parent::create($data);
        /** @var Product $product */
        if (isset($data['tags'])) {
            $product->tags()->sync($data['tags']);
        }
        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $product->images()->create(['url' => $image]);
            }
        }
        return $product;
    }

    public function update(Model $model, array $data): Model
    {
        unset($data['sku']);
        $model = parent::update($model, $data);
        /** @var Product $model */
        if (isset($data['tags'])) {
            $model->tags()->sync($data['tags']);
        }
        return $model;
    }

}
