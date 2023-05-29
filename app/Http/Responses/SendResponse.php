<?php


namespace App\Http\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;

class SendResponse
{
    /**
     * @param string $message
     * @return JsonResponse
     */
    public static function success(string $message = 'OK'): JsonResponse
    {

        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }

    public static function error(string $message, int $status = 200, ?array $data = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message
        ];
        if (isset($data)) {
            $response['data'] = $data;
        }
        return response()->json($response, $status);
    }

    /**
     * @param string $message
     * @param $data
     * @return JsonResponse
     */
    public static function successData($data, string $message = 'OK'): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function successPagination(LengthAwarePaginator $pagination, $totals = null, string $message = 'OK'): JsonResponse
    {
        return self::successData([
            'current' => $pagination->items(),
            'pagination' => [
                'total' => $pagination->total(),
                'per_page' => $pagination->perPage(),
                'current_page' => $pagination->currentPage(),
                'last_page' => $pagination->lastPage()
            ]
        ], $message);
    }
}
