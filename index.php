<?php
/*  Controller for Dating Website
    Original Author:    Dallas Sloan
    Last Modified by:   Dallas Sloan
    Creation Date:      02/01/2020
    Last Modified Date: 02/01/2020
    Filename:           index.php
*/

//require auto-load file

require_once ("vendor/autoload.php");
require_once("model/validation.php");

//start a session
session_start();
//session_destroy();


//Turn on error reporting -- this is critical!
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Create an instance of the base class
$f3 = Base::instance();

//defining arrays
$f3->set('inDoorOptions', array('tv', 'movies', 'playing cards', 'video games', 'puzzles', 'reading', 'board games', 'cooking'));
$f3->set('outDoorOptions', array('hiking', 'biking', 'swimming', 'collecting', 'walking', 'climbing'));
$outDoorOptions =  array('tv', 'movies', 'playing cards', 'video games', 'puzzles', 'reading', 'board games', 'cooking');
$inDoorOptions= array('hiking', 'biking', 'swimming', 'collecting', 'walking', 'climbing');

//Define a default route
$f3->route('GET /', function(){
    session_destroy();
    $view = new Template();
    echo $view->render('views/home.html');
    //echo "<h1>Hello Dating</h1>";
});

//Define a Personal Information Route
$f3->route('GET|POST /info', function($f3){
    //Checking to see if form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        var_dump($_POST);

        //grabbing data from form
        $first = $_POST['first'];
        $last = $_POST['last'];
        $age = $_POST['age'];
        $phone = $_POST['number'];
        if (isset($_POST['premium'])){
            $premium = $_POST['premium'];
        }
        $gender = $_POST['gender'];

        //adding data to hive
        $f3->set('first', $first);
        $f3->set('last', $last);
        $f3->set('age', $age);
        $f3->set('phone', $phone);

        //check if form is valid
        if (validInfoForm()){
            //Instantiate new member object
            if (isset($_POST['premium'])){
                $member = new PremiumMember($first, $last, $age, $gender, $phone);
            }
            else{
                $member = new Member($first, $last, $age, $gender, $phone);
            }
            /*//write data to session
            $_SESSION['first']=$first;
            $_SESSION['last']=$last;
            $_SESSION['age']=$age;
            $_SESSION['phone']=$phone;
            $_SESSION['gender']=$_POST['gender'];*/
            $_SESSION['member'] = $member;


            //redirect to profile page
            $f3->reroute('/profile');
        }
    }


    $view = new Template();
    echo $view->render('views/personalInfo.html');
    //echo "<h1>Hello Dating</h1>";
});

//Define a Profile Route
$f3->route('POST|GET /profile', function($f3){
    //echo $_SERVER['REQUEST_METHOD'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //pulling object from session
        $member = $_SESSION['member'];
        //var_dump($member);

        //grabbing data from form
        $email = $_POST['email'];

        //adding to hive
        $f3->set('email', $email);
        //print_r($member);
        //var_dump($_POST);

        //checking to ensure form is valid
        if (validateProfileForm()){
            //write additional info to member object
            if (isset($_POST['email'])) {
               $member->setEmail($email);
            }

            if(isset($_POST['state'])){
                $member->setState($_POST['state']);
            }
            if(isset($_POST['seeking'])){
                $member->setSeeking($_POST['seeking']);
            }
            if(isset($_POST['biography'])){
                $member->setBio($_POST['biography']);
            }

           /* //write data to session
            $_SESSION['email'] = $email;
            $_SESSION['state']=$_POST['state'];
            $_SESSION['seeking']=$_POST['seeking'];
            $_SESSION['biography']=$_POST['biography'];*/

           //save object back to session
            $_SESSION['member'] = $member;


            //redirect to interests page if premium member
            if (is_a($member, 'PremiumMember')) {
                $f3->reroute('/interests');
            }
            else{
                $f3->reroute('/summary');
            }
        }
    }


        /*$_SESSION['first']=$_POST['first'];
        $_SESSION['last']=$_POST['last'];
        $_SESSION['age']=$_POST['age'];
        $_SESSION['gender']=$_POST['gender'];
        $_SESSION['number']=$_POST['number'];*/


    $view = new Template();

    echo $view->render('views/profile.html');
    //echo "<h1>Hello Dating</h1>";
});

//Define a Interests Route
$f3->route('POST|GET /interests', function($f3){
    //pulling member object from session
    $member = $_SESSION['member'];
    $selectedInDoorOptions = array();
    $selectedOutDoorOptions = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //grabbing data from form
        if(!empty($_POST['inDoor'])){
            $selectedInDoorOptions = $_POST['inDoor'];
        }
        if(!empty($_POST['outDoor'])){
            $selectedOutDoorOptions = $_POST['outDoor'];
        }

        //add data to hive
        $f3->set('selectedInDoorOptions', $selectedInDoorOptions);
        $f3->set('selectedOutDoorOptions', $selectedOutDoorOptions);

        //validate the form
        if (validateInterestForm()){
            //setting information to object
            if (isset($selectedInDoorOptions)){
                $member->setInDoorInterests($selectedInDoorOptions);
            }
            if (isset($selectedOutDoorOptions)){
                $member->setOutDoorInterests($selectedOutDoorOptions);
            }
            /*//write data to session
            $_SESSION['inDoor']=$selectedInDoorOptions;
            $_SESSION['outDoor']=$selectedOutDoorOptions;*/

            //place object back into session
            $_SESSION['member'] = $member;

            $f3->reroute('/summary');
        }
    }
        /*$_SESSION['email']=$_POST['email'];
        $_SESSION['state']=$_POST['state'];
        $_SESSION['seeking']=$_POST['seeking'];
        $_SESSION['biography']=$_POST['biography'];*/

    $view = new Template();
    echo $view->render('views/interests.html');
    //echo "<h1>Hello Dating</h1>";
});

//Define a Summary Route
$f3->route('POST|GET /summary', function($f3){
/*    $_SESSION['inDoor']=$_POST['inDoor'];
    $_SESSION['outDoor']=$_POST['outDoor'];*/
    $member = $_SESSION['member'];
    $f3->set('member', $member);

    $view = new Template();
    echo $view->render('views/summary.html');
    //echo "<h1>Hello Dating</h1>";
});





//Run F3
$f3->run();

