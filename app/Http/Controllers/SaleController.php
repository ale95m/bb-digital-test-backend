<?php

namespace App\Http\Controllers;

use App\Http\Responses\SendResponse;
use App\Models\Role;
use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Http\Request;

class SaleController extends BaseController
{
    public function __construct(SaleRepository $saleRepository)
    {
        $this->repository = $saleRepository;
    }

    public function total(): \Illuminate\Http\JsonResponse
    {
        return SendResponse::successData(Sale::query()->sum('income'));
    }
}
