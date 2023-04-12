<?php

namespace Elastic\Custom;

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

        return $this->getDocument($record);
    }

    public function addDetails(array $record) {

        $record['meta'] = [];

        $request = request();
        $token = Auth::user()?->token;

        if($request) {
            $record['meta']['client_ip'] = $request->ip();
            $record['meta']['request'] = $request;
        }

        if($token){
            $record['meta']['user'] = [
                "username" => $token->username,
                "fullName" => $token->fullName,
                "position" => $token->position,
                "roles" => $token->resource_access,
            ];
        }

        return $record;
    }
}