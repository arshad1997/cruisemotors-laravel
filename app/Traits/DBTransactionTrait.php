<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait DBTransactionTrait
{
    use ResponseTrait;
    public function doDBTransaction(callable $callback, string $successMessage = "", string $errorMessage = "")
    {
        try {
            DB::beginTransaction();
            $result = $callback();
            DB::commit();
            if (!$result) {
                return $this->sendSuccess(
                    [],
                    $successMessage,
                );
            } else {
                return $this->sendSuccess(
                    $result,
                    $successMessage
                );
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(
                ['message' => $exception->getMessage(), 'trace' => $exception->getFile() . ' at ' . $exception->getLine()],
                500
            );
        }
    }
}
