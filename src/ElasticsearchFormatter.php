<?php

namespace Kali\Elastic;

use Illuminate\Support\Facades\Auth;
use Monolog\Formatter\ElasticsearchFormatter as Formatter;

class ElasticsearchFormatter extends Formatter
{
    /**
     * {@inheritDoc}
     */
    public function format(LogRecord $record)
    {
        $record = $this->addDetails($record);
        $record = parent::format($record);

        return $this->getDocument($record);
    }

    public function addDetails(LogRecord $record)
    {

        $record['meta'] = [];

        $request = request();
        $token = Auth::user()?->token;
        
        
        if ($request) {
            $record['meta']['request'] = [
                "ip" => $request->ip(),
                "method" => $request->method(),
                "url" => $request->url(),
                "body" => $request->all(),
                "body_json" => json_encode($request->all()),
            ];
      
            $record['meta']['request_full'] = $request;
        }

        if ($token) {
            $record['meta']['user'] = [
                "username" => $token->username,
                "fullName" => $token->fullName,
                "position" => $token->position,
                "roles" => $token->resource_access,
                "roles_json"=> json_encode($token->resource_access),
            ];
        } else {
            $record['meta']['user'] = [
                "username" => "anonymous"
            ];
        }

        $record['meta']['app'] = [
            "name" => config('app.name'),
            "env" => config('app.env'),
            "url" => config('app.url'),
            "tag" => config('app.tag'),
        ];

        return $record;
    }
}
