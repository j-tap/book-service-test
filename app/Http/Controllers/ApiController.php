<?php
namespace App\Http\Controllers;

use \Exception;
use App\Http\Controllers\Controller as Controller;

class ApiController extends Controller
{
    /**
     * sendResponse
     *
     * @param  $response
     * @return json
     */
    public function sendResponse($response)
    {
        $code = 200;
        $result = [];

        try
        {
            if (method_exists($response, 'status')) $code = $response->status();

            if (method_exists($response, 'content'))
            {
                if ($code === 200 || $code === 201)
                {
                    $result['data'] = $response->content();
                }
                elseif ($code === 409)
                {
                    $result['errors'] = is_string($response->content())
                        ? json_decode($response->content()) : $response->content();
                }
                else {
                    $result['message'] = $response->content();
                }
            }
            else
            {
                $result['data'] = $response;
            }

            $result['status'] = $code;
        }
        catch (Exception $e)
        {
            $result = $this::getError($result, $e);
        }

        return response()->json($result, $code);
    }

    /**
     * getError
     *
     * @param  Array $result
     * @param  Exception $e
     * @return Array
     */
    private function getError(Array $result, Exception $e)
    {
        $code = 500;
        $result['message'] = $e->getMessage();

        if (config('app.debug'))
        {
            $result['data'] = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),
            ];
        }
        if ($e->getCode()) $code = $e->getCode();
        $result['status'] = $code;

        return $result;
    }
}
