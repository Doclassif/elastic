<?php

namespace Kali\Elastic;

use Illuminate\Support\Facades\Auth;
use Monolog\Formatter\ElasticsearchFormatter as Formatter;

class ElasticsearchFormatter extends Formatter
{
    /**
     * {@inheritDoc}
     */
    public function format(array $record)
    {
        $record = $this->addDetails($record);

        $record = parent::format($record);

        return $record;
    }

    public function addDetails(array $record)
    {
        $record['extra'] = [];

        $request = request();
        $request_all = $request->all();

        $ignore_keys = config('logging.channels.elasticsearch.formatter_ignore_request_keys', ['password', 'password_confirmation']);
        if (array_is_list($ignore_keys)) {
            foreach ($ignore_keys as $key) {
                unset($request_all[$key]);
            }
        }

        if ($request) {
            $record['extra']['request'] = [
                "ip" => $request->ip(),
                "method" => $request->method(),
                "url" => $request->url(),
                "body" => $request_all,
            ];
        }

        if (Auth::getDefaultDriver() === 'api' && config('auth.guards.api.driver') === 'keycloak') {
            try {
                $token = json_decode(Auth::token());

                if ($token) {
                    $record['extra']['user'] = [
                        "username" => $token->username,
                        "fullName" => $token->fullName,
                        "position" => $token->position,
                        "roles" => $token->resource_access,
                        "roles_json" => json_encode($token->resource_access),
                    ];
                } else {
                    $record['extra']['user'] = [
                        "username" => "anonymous"
                    ];
                }

            } catch (\Throwable $th) {
                $record['extra']['user'] = [
                    "token_exception_message" => $th->getMessage(),
                ];
            }
        }

        $record['extra']['app'] = [
            "name" => config('app.name'),
            "env" => config('app.env'),
            "url" => config('app.url'),
            "tag" => env('CI_COMMIT_TAG', "version is not committed"),
        ];

        return $record;
    }
}
