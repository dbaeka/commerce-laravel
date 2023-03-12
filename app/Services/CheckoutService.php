<?php

namespace App\Services;

use App\Exceptions\ApiRequestException;
use App\Jobs\CreateOrderItem;
use App\Jobs\DeleteOrder;
use App\Jobs\DeleteOrderItems;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

class CheckoutService implements CheckoutServiceInterface
{
    public function __construct(
        private readonly OrderServiceInterface $order_service
    )
    {
    }

    public function createCheckout(array $data): ?string
    {
        $order = $this->order_service->createOrder($data);
        if (!empty($order)) {
            $jobs = array();
            foreach ($data['order']['items'] as $item) {
                $data = [
                    'order_item' => $item,
                    'order_external_id' => $order->external_id,
                    'order_slug' => $order->slug,
                ];
                $jobs[] = new CreateOrderItem($data);
            }
            try {
                $this->dispatchBatchJobs($jobs, $order);
            } catch (Throwable $e) {
                // Rollback Order Creation if Batch Setup Wrong
                if (!$e instanceof ApiRequestException) {
                    Log::error(__CLASS__ . ' ' . __FUNCTION__ . ': Error making the call: ' . $e->getMessage());
                    DeleteOrder::dispatch($order->external_id);
                }
            }
            return $order->external_id;
        }
        return null;
    }

    /**
     * @throws Throwable
     */
    private function dispatchBatchJobs(array $jobs, $order)
    {
        Bus::batch($jobs)
            ->then(function (Batch $batch) {
                // All jobs completed successfully...
                // Can dispatch email notification here
            })->catch(function () use ($order) {
                // First batch job failure detected so rollback created items and then order
                Log::info(__CLASS__ . ' ' . __FUNCTION__ . ': Failed to create an order time. Rolling back');
                Bus::chain([
                    new DeleteOrder($order->external_id),
                    new DeleteOrderItems($order->external_id),
                ])->dispatch();
            })->dispatch();
    }

    public function defaultConfig(): object
    {
        return (object)[
            'max_quantity' => config('services.ycode.default_max_quantity'),
            'base_currency' => config('services.ycode.default_currency'),
            'shipping_cost' => config('services.ycode.default_shipping_cost')
        ];
    }
}
