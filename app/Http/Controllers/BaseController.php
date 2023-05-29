<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Http\Responses\SendResponse;
use App\Repositories\IRepository;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $repository;
    protected int $per_page = 10;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return SendResponse::successData($this->repository->search($request->all())->get());
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        return SendResponse::successData($this->repository->findOrFail($id, false));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        return SendResponse::successData($this->repository->delete($id));
    }

    public function paginate(PaginateRequest $request, string|Builder $search = 'search'): JsonResponse
    {
        $per_page = $request['per_page'] ?? $this->per_page;
        $current_page = $request['page'] ?? 1;
        $query = is_string($search)
            ? $this->repository->$search($request->all())
            : $search;
        return SendResponse::successPagination(
            $query->paginate($per_page, ['*'], 'page', $current_page)
        );
    }
}
