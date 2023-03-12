<?php

namespace App\Jobs;

use App\Services\OrderServiceInterface;
use Illuminate\Support\Facades\Log;

class DeleteOrder extends BaseRetryUntilFailureJob
{
    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $order_id)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(OrderServiceInterface $service): void
    {
        Log::info(__CLASS__ . ' ' . __FUNCTION__ . ': Handling job');

        $success = $service->deleteOrder($this->order_id);

        // Delete failed so try again
        if (!$success) {
            $this->release(10);
        }
    }
}
