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

    $bookId = (isset($_GET['id'])? $_GET['id'] : 0);  
    
    if(is_numeric($bookId)){    
        $data = json_decode(file_get_contents('php://input'), true);

        $book = new PhoneBook();
        $book->fromJSON($data);
        $book->phoneBookId = (int) $bookId;
        $tranStatus = $book->update();

        //creating the response
        $response = new StdClass;
        if( $tranStatus ) {
            $response->status = "success";
            $response->message = "Book was updated.";
        }
        else{
            $response->status = "failed";
            $response->message = "Something went wrong, please try again.";    
        }
        echo json_encode($response);

    }else{
        //creating the response
        $response = new StdClass;       
        $response->status = "failed";
        $response->message = "the {id} parameter is not in correct format";
        echo json_encode($response);
   }

    

}

?>