<?php

namespace App\Http;

use Illuminate\Support\Facades\Response as ResponseFacade;

class Response
{
    public const SUCCESS = 200;
    public const INTERNAL_ERROR = 500;

    public static function send(mixed $data, int $code = self::SUCCESS, array $headers = [])
    {
        $response = new static([
            'success' => true,
            'data' => $data,
        ], $code, $headers);

        return $response();
    }

    public static function error(mixed $data, int $code = self::INTERNAL_ERROR, array $headers = [])
    {
        $response = new static([
            'success' => false,
            'data' => $data,
        ], $code, $headers);

        return $response();
    }

    public function __construct(
        private mixed $data,
        private int $code,
        private array $headers
    ) {
        //
    }

    public function __invoke()
    {
        return ResponseFacade::json(
            $this->data,
            $this->code,
            $this->headers
        );
    }
}
