<?php
require_once "vendor/autoload.php";
require_once "app/functions.php";

$f3 = Base::instance();

define('SERVER', 'dev'); // 'dev' or 'production'

$f3->config('config.' . SERVER .'.ini');
$f3->set('LOCALES','app/lang/');
// Get user language from browser
// $f3->get('LANGUAGE'); // 'de-DE,de,en-US,en'

// Uncomment to test translation
//$f3->set('LANGUAGE','fr');


new Session();

$f3->config('routes.ini');

$f3->run();