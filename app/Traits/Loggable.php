<?php
namespace App\Traits;

use App\UserLogs;

trait Loggable
{
    public function store_logs($type, $title, $body, $inqury_id = null)
    {
        $logs = new UserLogs;
        $logs->user_id = auth()->check() ? auth()->user()->id : '1';
        $logs->type = $type;
        $logs->title = $title;
        $logs->body = $body;
        $logs->inqury_id = $inqury_id;
        $logs->save();
    }
}
