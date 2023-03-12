<?php

namespace App\Jobs;

use App\Services\OrderItemServiceInterface;
use Illuminate\Support\Facades\Log;

class DeleteOrderItems extends BaseRetryUntilFailureJob
{


    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $order_id)
    {
        //

    }

    /**
     * Execute the job.
     */
    public function handle(OrderItemServiceInterface $service): void
    {
        Log::info(__CLASS__ . ' ' . __FUNCTION__ . ': Handling job');

        $order_items = $service->getOrderItemsByOrderId($this->order_id);
        if (is_null($order_items)) {
            // Possible connection issue
            $this->release(10);
        } else {
            foreach ($order_items as $order_item) {
                DeleteOrderItem::dispatch($order_item->external_id);
            }
        }

    }
}
