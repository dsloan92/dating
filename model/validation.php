<?php

//creating multiple functions to validate different pieces of form data


//validating the Info Form
function validInfoForm()
{
    //creating a isValid boolean
    $isValid = true;
    global $f3;

    if (!validName($f3->get('last'))) {
        $isValid = false;
        $f3->set("errors['last']", "Please enter a valid Last Name");
    }

    if (!validName($f3->get('first'))) {
        $isValid = false;
        $f3->set("errors['first']", "Please enter a valid First Name");
    }

    if (!validAge($f3->get('age'))) {
        $isValid = false;
        $f3->set("errors['age']", "Please enter a valid Age");
    }

    if (!validPhone($f3->get('phone'))) {
        $isValid = false;
        $f3->set("errors['phone']", "Please enter a valid Phone Number");
    }
    return $isValid;

}

//Validating the Profile form
function validateProfileForm()
{
    $isValid = true;
    global $f3;
    if (!validEmail($f3->get('email'))) {
        $isValid = false;
        $f3->set("errors['email']", "Please enter a valid Email");
    }

    return $isValid;
}

//validating Interest Form
function validateInterestForm(){
    $isValid = true;
    global $f3;
    if (!validOutDoor($f3->get('selectedOutDoorOptions'))){
        $isValid = false;
        $f3->set("errors['selectedOutDoorOptions']", "Please choose valid OutDoor Options");
    }

    if (!validInDoor($f3->get('selectedInDoorOptions'))){
        $isValid = false;
        $f3->set("errors['selectedInDoorOptions']", "Please choose valid InDoor Options");
    }

    return $isValid;
}

//validating that a string is alphabetic
function validName($name)
{

    return !empty($name) && ctype_alpha($name);
}

//validating the age input is between 18 and 118
function validAge($age)
{
    return !empty($age) && ctype_digit($age) && $age >= 18 & $age <= 118;
}

//validating phone numbers
function validPhone($phone)
{
    //remove basic phone characters
    $phone = str_replace(" ", "", $phone);
    $phone = preg_replace('/-/', "", $phone);
    $phone = preg_replace('/\(/', "", $phone);
    $phone = preg_replace('/\)/', "", $phone);
    $phone = preg_replace('/_/', "", $phone);
    //echo "<p>$id</p>"; for de-bugging purposes

    return !empty($phone) && ctype_digit($phone) && strlen($phone) === 10;

}

//validate email
function validEmail($email)
{
    return (!empty($email) && preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $email));

}

//validate out door checkbox
function validOutDoor($selectedOutDoorOptions){
    global $outDoorOptions;
    if (isset($selectedOutDoorOptions)) {

        foreach ($selectedOutDoorOptions as $value) {
            if (in_array($value, $outDoorOptions)) {
                return false;
            }
        }
    }
    return true;
}

//validate inDoor checkbox
function validInDoor($selectedInDoorOptions){
    global $inDoorOptions;
    if (isset($selectedInDoorOptions)) {

        foreach ($selectedInDoorOptions as $value) {
            if (in_array($value, $inDoorOptions)) {
                return false;
            }
        }
    }
    return true;
}

