<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('parking-session:auto-renewal')->everyMinute()->withoutOverlapping();
