<?php

namespace Kali\Elastic;

use Illuminate\Support\Facades\Auth;
use Monolog\Formatter\ElasticsearchFormatter as Formatter;
use Monolog\LogRecord;

class ElasticsearchFormatter extends Formatter
{
    /**
     * {@inheritDoc}
     */
    public function format(LogRecord $record)
    {
        $record->offsetSet('extra', $this->addDetails());

        $record = parent::format($record);

        return $record;
    }

    public function addDetails()
    {
        $record = [];

        $request = request();
        $request_all = $request->all();
        $token = Auth::user()?->token;

        $ignore_keys = config('logging.channels.elasticsearch.formatter_ignore_request_keys', ['password', 'password_confirmation']);
        if (array_is_list($ignore_keys)) {
            foreach ($ignore_keys as $key) {
                unset($request_all[$key]);
            }
        }

        if ($request) {
            $record['request'] = [
                "ip" => $request->ip(),
                "method" => $request->method(),
                "url" => $request->url(),
                "body" => $request_all,
            ];
        }

        if ($token) {
            $record['user'] = [
                "username" => $token->username,
                "fullName" => $token->fullName,
                "position" => $token->position,
                "roles" => $token->resource_access,
                "roles_json" => json_encode($token->resource_access),
            ];
        } else {
            $record['user'] = [
                "username" => "anonymous"
            ];
        }

        $record['app'] = [
            "name" => config('app.name'),
            "env" => config('app.env'),
            "url" => config('app.url'),
            "tag" => env('CI_COMMIT_TAG', "version is not committed"),
        ];

        return $record;
    }
}
