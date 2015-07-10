<?php

namespace App\Listeners;

use Log;
use DateTime;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Events  $event
     * @return void
     */
    public function handle($sql, $params)
    {
        if (env('APP_ENV', 'production') == 'local') {
            foreach ($params as $index => $param) {
                if ($param instanceof DateTime) {
                    $params[$index] = $param->format('Y-m-d H:i:s');
                }
            }
            Log::info($sql.', with['.implode(',', $params).']');
        }
    }
}
