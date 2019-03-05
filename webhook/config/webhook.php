<?php

return [
    /*
     * The delay time to next delivery when delivery to webhook failed (seconds)
     */
    'delay' => env('WEBHOOK_DELAY', 60),
];