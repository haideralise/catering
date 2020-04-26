<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require "vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;



$capsule = new Capsule;



$capsule->addConnection([

    "driver" => "mysql",

    "host" =>"127.0.0.1",

    "database" => "event-catering",

    "username" => "root",

    "password" => "12345"

]);

//Make this Capsule instance available globally.
$capsule->setAsGlobal();

// Setup the Eloquent ORM.
$capsule->bootEloquent();
$capsule->bootEloquent();