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
        $token = Auth::user()?->token;


        if ($request) {
            $record['extra']['request'] = [
                "ip" => $request->ip(),
                "method" => $request->method(),
                "url" => $request->url(),
                "body" => $request->all(),
                "body_json" => json_encode($request->all()),
            ];

            $record['extra']['request_full'] = $request;
        }

        if ($token) {
            $record['extra']['user'] = [
                "username" => $token->username,
                "fullName" => $token->fullName,
                "position" => $token->position,
                "roles" => $token->resource_access,
                "roles_json"=> json_encode($token->resource_access),
            ];
        } else {
            $record['extra']['user'] = [
                "username" => "anonymous"
            ];
        }

        $record['extra']['app'] = [
            "name" => config('app.name'),
            "env" => config('app.env'),
            "url" => config('app.url'),
            "tag" => env('CI_COMMIT_TAG',"version is not committed"),
        ];

        return $record;
    }
}
