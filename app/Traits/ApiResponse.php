<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ApiResponse
{
    protected function success(
        mixed $data = null,
        string $message = 'Sucesso',
        int $status = 200
    ): JsonResponse {

        if ($data instanceof JsonResource) {
            return $data
                ->additional([
                    'success' => true,
                    'message' => $message,
                ])
                ->response()
                ->setStatusCode($status);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null,
        ], $status);
    }

    protected function created(
        mixed $data = null,
        string $message = 'Recurso criado com sucesso'
    ): JsonResponse {
        return $this->success($data, $message, 201);
    }

    protected function error(
        string $message = 'Erro',
        int $status = 400,
        mixed $errors = null
    ): JsonResponse {

        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'errors' => $this->normalizeErrors($errors),
        ], $status);
    }

    protected function notFound(string $message = 'Recurso não encontrado'): JsonResponse
    {
        return $this->error($message, 404);
    }

    protected function forbidden(string $message = 'Sem permissão'): JsonResponse
    {
        return $this->error($message, 403);
    }

    /**
     * Normaliza erros para formato consistente
     */
    private function normalizeErrors(mixed $errors): mixed
    {
        if (is_null($errors)) {
            return null;
        }

        if ($errors instanceof \Illuminate\Support\MessageBag) {
            return $errors->toArray();
        }

        if (is_object($errors) && method_exists($errors, 'errors')) {
            return $errors->errors();
        }

        return $errors;
    }
}