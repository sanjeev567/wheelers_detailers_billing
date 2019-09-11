<?php

namespace App\Http\Middleware;

use App\Entities\AccessLog;
use Closure;
use Illuminate\Support\Facades\Request;

class ApplicationLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        try {
            $log = [
                'user_id' => (!empty(\Auth::id())) ? \Auth::id() : '0',
                'client_ip' => json_encode($request->ip()),
                'request_url' => $request->path(),
                'request_headers' => json_encode(getallheaders()),
                'request' => json_encode($request->all()),
                'response_status' => $response->status(),
                'response_headers' => json_encode(headers_list()),
                // 'response' => json_encode($response->content()),
                'response' => json_encode(''),
                'extra' => json_encode(''),
            ];

            if ((Request::isMethod('post') && $request->ajax()) || $request->is('api/*')) {
                $result = json_decode($response->content());

                if (json_last_error() === JSON_ERROR_NONE) {
                    // JSON is valid
                    $log['response'] = $response->content();
                } else {
                    // encode data as it is not json
                    $log['response'] = substr(json_encode($response->content()), 0, 1000);
                }
            }

            // log request & response
            AccessLog::create($log);

            return $response;
        } catch (\Throwable $th) {
            return $response;
        }
    }
}
