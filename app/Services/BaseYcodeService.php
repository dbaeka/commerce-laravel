<?php

namespace App\Services;

use App\Exceptions\MissingEnvVariableException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class BaseYcodeService
{
    protected string $collection_id;

    /**
     * Make sure that env variables are set.
     *
     * @return void
     */
    protected function validateEnvVariables(): void
    {
        if (!config('services.ycode') || empty(config('services.ycode.token'))
            || empty(config('services.ycode.base_url'))) {
            throw new MissingEnvVariableException();
        }
    }

    protected function getBaseRequest(): PendingRequest
    {
        $token = config("services.ycode.token");
        $base_url = config("services.ycode.base_url");
        return Http::withToken($token)->acceptJson()->baseUrl($base_url)->timeout(30);
    }

    protected function getCollectionId()
    {
        if (empty($this->collection_id) || empty(config('services.ycode.collections.' . $this->collection_id))) {
            throw new MissingEnvVariableException();
        }
        return config('services.ycode.collections.' . $this->collection_id);
    }

}
