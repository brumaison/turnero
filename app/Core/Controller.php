<?php
namespace App\Core;

use Carbon\Carbon;

class Controller {
    public function __construct() {
        Carbon::setLocale($_ENV['APP_LOCALE'] ?? 'es');
        date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'America/Argentina/Buenos_Aires');
    }
}