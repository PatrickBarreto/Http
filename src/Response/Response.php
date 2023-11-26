<?php

namespace Http\Response;

class Response {

    private static array $headers;

    private static int $statusCode;

    private static string $body;

    /**
     * This method gonna prepare and execute the response
     *
     * @param integer $statusCode
     * @param array|null $body
     * @param array $headers
     */
    public static function exec (array $body = null, int $statusCode = 200, array $headers = ["Content-Type" => "application/json"]) {
        self::$statusCode = $statusCode;
        self::$body = $body ? json_encode($body, JSON_PRETTY_PRINT) : "";
        self::$headers = $headers;
       
        self::prepareHttpResponseHeader();

        echo self::$body;
        exit;
    }


    /**
     * This method goona prepare the HTTP response headers
     */
    private static function prepareHttpResponseHeader() {
        foreach(self::$headers as $header => $value) {
            header("{$header}: {$value}", true, self::$statusCode);
        }
    }

}