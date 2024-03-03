<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessCollection extends JsonResource
{
    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'payload' => $this->data['items'],
            'total' => $this->data['total'],
        ];
    }
}
