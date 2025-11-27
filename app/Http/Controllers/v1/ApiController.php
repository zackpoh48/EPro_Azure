<?php

namespace App\Http\Controllers\v1;

use App\Traits\ApiResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Log;

class ApiController extends Controller
{
    use ApiResponse;

    public function sendSoapRequest($method, $uri, $headers = [], $body = [])
    {
        try {
            $url = env('SOAP_URL') . '/' . $uri;
            $client = new Client(['auth' => [env('NAV_USERNAME'), env('NAV_PASSWORD'), env('NAV_AUTHTYPE')]]);
            $request = new Request(
                $method,
                $url,
                $headers,
                $body
            );

            $response = $client->send($request);
            if ($response->getStatusCode() == "200") {
                return $this->successResponse($response->getBody(), "");
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $error = Psr7\Message::toString($e->getResponse());
            }
            return $this->errorResponse($error, 500);
        }
    }
}
