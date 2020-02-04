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
session_start();

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
    //echo "<h1>Hello Dating</h1>";
});

//Define a Profile Route
$f3->route('POST /profile', function(){
    $_SESSION['first']=$_POST['first'];
    $_SESSION['last']=$_POST['last'];
    $_SESSION['age']=$_POST['age'];
    $_SESSION['gender']=$_POST['gender'];
    $_SESSION['number']=$_POST['number'];

    $view = new Template();

    echo $view->render('views/profile.html');
    //echo "<h1>Hello Dating</h1>";
});

//Define a Interests Route
$f3->route('POST /interests', function(){
    $_SESSION['email']=$_POST['email'];
    $_SESSION['state']=$_POST['state'];
    $_SESSION['seeking']=$_POST['seeking'];
    $_SESSION['biography']=$_POST['biography'];

    $view = new Template();
    echo $view->render('views/interests.html');
    //echo "<h1>Hello Dating</h1>";
});

//Define a Summary Route
$f3->route('POST /summary', function(){
    $_SESSION['inDoor']=$_POST['inDoor'];
    $_SESSION['outDoor']=$_POST['outDoor'];

    $view = new Template();
    echo $view->render('views/summary.html');
    //echo "<h1>Hello Dating</h1>";
});





//Run F3
$f3->run();

