<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../Helpers/HttpHelper.php';
$httpHelper = new HttpHelper();

if ($httpHelper->isVerbAllowed(basename(__FILE__))) {      

    include_once '../../Models/Email.php';
    include_once '../../Models/PhoneNumber.php';
    include_once '../../Models/PhoneBook.php';


    $data = json_decode(file_get_contents('php://input'), true);

    $book = new PhoneBook();
    $book->fromJSON($data);
    $book->create();

    //creating the response
    $response = new StdClass;
    if( $book->phoneBookId > 0 ) {
        $response->status = "success";
        $response->message = "Book was created.";
    }
    else{
        $response->status = "failed";
        $response->message = "Unable to create Book.";    
    }

    echo json_encode($response);

}

?>