<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Http\Requests\Product\StoreProduct;
use App\Http\Requests\Product\UpdateProduct;
use App\Http\Requests\Product\UpdateProductStock;
use App\Http\Responses\SendResponse;
use App\Models\Product;
use App\Models\Role;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
        $this->middleware(Role::stringMiddleware(Role::ADMIN, Role::EDITOR))
            ->only('store', 'update', 'destroy');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProduct $request): JsonResponse
    {
        return SendResponse::successData($this->repository->create($request->all()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProduct $request, Product $product): JsonResponse
    {
        return SendResponse::successData($this->repository->update($product, $request->all()));
    }


    public function addStock(UpdateProductStock $request, Product $product): JsonResponse
    {
        return SendResponse::successData($this->repository->addStock($product, $request['amount']));
    }

    public function removeStock(UpdateProductStock $request, Product $product): JsonResponse
    {
        return SendResponse::successData($this->repository->addStock($product, $request['amount']));
    }

    public function count(Request $request): JsonResponse
    {
        return SendResponse::successData($this->repository->search($request->all())->count());
    }

    public function outOfStock(Request $request): JsonResponse
    {
        return SendResponse::successData($this->repository->search($request->all())->where('stock', 0)->get());
    }

    /**
     * @throws \Exception
     */
    public function sell(Product $product): JsonResponse
    {
        $product->sell(1);
        return SendResponse::success();
    }

}
