<?php

namespace App\Jobs;

use App\Services\OrderItemServiceInterface;
use Illuminate\Support\Facades\Log;

class DeleteOrderItem extends BaseRetryUntilFailureJob
{
    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $order_item_id)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(OrderItemServiceInterface $service): void
    {
        Log::info(__CLASS__ . ' ' . __FUNCTION__ . ': Handling job');

        $success = $service->deleteOrderItem($this->order_item_id);

        // Delete failed so try again
        if (!$success) {
            $this->release(10);
        }
    }
}
