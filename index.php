<?php
/*  Controller for Dating Website
    Original Author:    Dallas Sloan
    Last Modified by:   Dallas Sloan
    Creation Date:      02/01/2020
    Last Modified Date: 02/01/2020
    Filename:           index.php
*/


//require auto-load file
require ("vendor/autoload.php");

//Turn on error reporting -- this is critical!
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Create an instance of the base class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function(){
    $view = new Template();
    echo $view->render('views/home.html');
    //echo "<h1>Hello Dating</h1>";
});

//Define a Personal Information Route
$f3->route('POST /info', function(){
    $view = new Template();
    echo $view->render('views/personalInfo.html');
    echo "<h1>Hello Dating</h1>";
});


//Run F3
$f3->run();

