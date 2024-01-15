<?php

namespace App\Exceptions;

use App\Utility\ResponseBuilder;
use Exception;
use Illuminate\Http\JsonResponse;

class NotFoundException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(string $message = "", int $code = 404)
    {
        parent::__construct($message, $code);
        $this->message = $message;
        $this->code = $code;
    }

    public function report() {}

    public function render(): JsonResponse {
        return ResponseBuilder::error($this->message, $this->code);
    }

}
