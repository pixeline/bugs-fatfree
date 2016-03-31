<?php
require_once "vendor/autoload.php";

$f3 = Base::instance();
$f3->config('config.ini');
$f3->config('routes.ini');
$f3->set('LOCALES','app/lang/');

// Uncomment to test translation
//$f3->set('LANGUAGE','fr');

new Session();

$f3->run();