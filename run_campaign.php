<?php
require '/var/www/html/core/vendor/autoload.php';
$app = require '/var/www/html/core/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$cron = new App\Http\Controllers\CronController();
$cron->campaignMessage();
