<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HrisClientService
{
    protected function request()
    {
        return Http::timeout(config('services.hris.timeout'))
            ->withHeaders([
                'X-API-KEY' => config('services.hris.api_key'),
                'Accept' => 'application/json',
            ]);
    }

    public function getEmployees(): array
    {
        $baseUrl = rtrim(config('services.hris.base_url'), '/');

        $resp = $this->request()->get($baseUrl . '/getEmployees');
        $resp->throw();

        $data = $resp->json();

        return $data ?? [];
    }
}
