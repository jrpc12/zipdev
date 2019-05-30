<?php

class HttpHelper{

    public function isVerbAllowed($endpoint){

        $isValid = true;
        $verb =  $_SERVER['REQUEST_METHOD'];        

        switch($endpoint){

            case "Create.php":

                if($verb !== "POST"){
                    $isValid = false;
                    $this->rejectMessage();
                }

            break;

            case "Read.php":                
                if($verb !== "GET"){
                    $isValid = false;
                    $this->rejectMessage();
                }

            break;

            case "Update.php":

                if($verb !== "PUT"){
                    $isValid = false;
                    $this->rejectMessage();
                }

            break;

            case "Delete.php":

                if($verb !== "DELETE"){
                    $isValid = false;
                    $this->rejectMessage();
                }

            break;

            case "Filter.php":

            if($verb !== "POST"){
                $isValid = false;
                $this->rejectMessage();
            }

        break;

        }

        return $isValid;

    }

    private function rejectMessage(){
        $data = new StdClass;
        $data->message= "Method not allowed";
        echo json_encode($data);
    }

}

?>