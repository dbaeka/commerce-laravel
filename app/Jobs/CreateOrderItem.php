<?php

namespace App\Jobs;

use App\Exceptions\ApiRequestException;
use App\Services\OrderItemServiceInterface;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateOrderItem implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Batchable;


    /**
     * Create a new job instance.
     */
    public function __construct(private readonly array $data)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(OrderItemServiceInterface $service): void
    {
        Log::info(__CLASS__ . ' ' . __FUNCTION__ . ': Handling job');

        if (!$this->batching()) {
            return; // @codeCoverageIgnore
        }

        $oder_id = $service->createOrderItem($this->data);

        // Creation failed so rollback all others by cancelling batch
        if (empty($oder_id)) {
            throw new ApiRequestException();
        }
    }
}
