<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('rows', function () {
    return true;
});
