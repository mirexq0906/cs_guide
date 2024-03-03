<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    protected $error;

    public function __construct(string $error = '')
    {
        $this->error = $error;
    }

    public function toArray(Request $request): array
    {
        return [
            'success' => false,
            'message' => $this->error,
        ];
    }
}
