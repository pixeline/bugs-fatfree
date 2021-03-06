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


// Store session in Database
$db=new \DB\SQL( $f3->get('db') ,$f3->get('dbusername'),$f3->get('dbpassword'));
// just create an object
new \DB\SQL\Session($db);
//new Session();

$f3->config('routes.ini');

$f3->run();