<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../Helpers/HttpHelper.php';
$httpHelper = new HttpHelper();

if ($httpHelper->isVerbAllowed(basename(__FILE__))) {    

    include_once '../../Models/PhoneNumber.php';
    include_once '../../Models/PhoneBook.php';
    include_once '../../Models/Email.php';

    $bookId = (isset($_GET['id'])? $_GET['id'] : 0);    
        
    if(is_numeric($bookId)){ 

        $book = new PhoneBook();        
        $book->phoneBookId = (int) $bookId;
        $item = $book->read();

        echo json_encode($item);
    }else{
        //creating the response
        $response = new StdClass;       
        $response->status = "failed";
        $response->message = "the {id} parameter is not in correct format";
        echo json_encode($response);
    }

}

?>