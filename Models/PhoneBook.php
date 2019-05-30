<?php

include_once '../../Helpers/DBHelper.php';

class PhoneBook{

    public $phoneBookId;
    public $firstname;
    public $lastname;
    public $phoneNumbers;
    public $emails;

    public function __construct(){

    }

    public function fromJSON($data){
        foreach ($data as $key => $value){
            $this->{$key} = $value;        
        }
    }

    public function create(){        
        $pdo = null;

        try{

            $dbContext = new DBHelper();            
            $pdo = $dbContext->getConnection();

            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO PhoneBook(firstname, lastname) VALUES(?,?)"); 
            $stmt->execute([$this->firstname,$this->lastname]);
            $this->phoneBookId = $pdo->lastInsertId();

            
            if(is_array($this->phoneNumbers)){                
                foreach($this->phoneNumbers as $number){
                    $stmt = $pdo->prepare("INSERT INTO PhoneNumber(phoneNumber, phoneBookId) VALUES(?,?)"); 
                    $stmt->execute([$number,$this->phoneBookId]);
                }               
            }
        
            if(is_array($this->emails)){                
                foreach($this->emails as $email){                    
                    $stmt = $pdo->prepare("INSERT INTO Email(email, phoneBookId) VALUES(?,?)"); 
                    $stmt->execute([$email,$this->phoneBookId]);
                }
            }            
            
            $stmt = null;
            $pdo->commit();            

        }catch(exception $ex){

            echo "Connection failed: " . $ex->getMessage();

            if($pdo != null){ $pdo->rollBack();}

        }finally{//close connection
            $pdo = null;
        }

        return $this->phoneBookId;
    }

    public function update(){
        $pdo = null;

        $success = true;

        try{

            //validate the primary id at least
            if($this->phoneBookId == 0){
                $success = false;
                return;
            }

            $dbContext = new DBHelper();            
            $pdo = $dbContext->getConnection();

            $pdo->beginTransaction();

            $stmt = $pdo->prepare("UPDATE PhoneBook SET firstname = ?, lastname = ? WHERE phoneBookId = ?"); 
            $stmt->execute([$this->firstname,$this->lastname,$this->phoneBookId]);           

            
            if(is_array($this->phoneNumbers)){ 

                //clean phone numbers relations
                $stmt = $pdo->prepare("DELETE FROM PhoneNumber WHERE phoneBookId = ?"); 
                $stmt->execute([$this->phoneBookId]);

                //insert the new ones
                foreach($this->phoneNumbers as $number){
                    $stmt = $pdo->prepare("INSERT INTO PhoneNumber(phoneNumber, phoneBookId) VALUES(?,?)"); 
                    $stmt->execute([$number,$this->phoneBookId]);
                    
                }               
            }
        
            if(is_array($this->emails)){   

                 //clean phone numbers relations
                 $stmt = $pdo->prepare("DELETE FROM Email WHERE phoneBookId = ?"); 
                 $stmt->execute([$this->phoneBookId]);

                foreach($this->emails as $email){                    
                    $stmt = $pdo->prepare("INSERT INTO Email(email, phoneBookId) VALUES(?,?)"); 
                    $stmt->execute([$email,$this->phoneBookId]);
                }
            }            
            
            $stmt = null;
            $pdo->commit();            

        }catch(exception $ex){
            $success = false;
            echo "Connection failed: " . $ex->getMessage();

            if($pdo != null){ $pdo->rollBack();}

        }finally{//close connection
            $pdo = null;
        }

        return $success;
    }


    public function delete(){

        $success = true;
        $pdo = null;

        try{
            
            //validate the primary id at least
            if($this->phoneBookId == 0){
                $success = false;
                return;
            }

            $dbContext = new DBHelper();
            $pdo = $dbContext->getConnection();

            $pdo->beginTransaction();           

            $stmt = $pdo->prepare("DELETE FROM PhoneNumber WHERE phoneBookId = ?"); 
            $stmt->execute([$this->phoneBookId]);

            $stmt = $pdo->prepare("DELETE FROM Email WHERE phoneBookId = ?"); 
            $stmt->execute([$this->phoneBookId]);

            $stmt = $pdo->prepare("DELETE FROM PhoneBook WHERE phoneBookId = ?"); 
            $stmt->execute([$this->phoneBookId]);
            
            $stmt = null;
            $pdo->commit();   
                  

        }catch(exception $ex){
            $success = false;
            echo "Connection failed: " . $ex->getMessage();

            if($pdo != null){ $pdo->rollBack();}

        }finally{//close connection
            $pdo = null;
        }

        return $success;

    }


    public function read(){

        $pdo = null;

        $item = null;

        try{

            $dbContext = new DBHelper();            
            $pdo = $dbContext->getConnection();

            $pdo->beginTransaction();

            $stmt = $pdo->prepare("SELECT * FROM PhoneBook WHERE phoneBookId = ?"); 
            $stmt->execute([$this->phoneBookId]); 
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'PhoneBook');

            $item = $stmt->fetchAll(); 

            if(sizeof($item)>0){

                $stmt = $pdo->prepare("SELECT phoneNumber FROM PhoneNumber WHERE phoneBookId = ?"); 
                $stmt->execute([$this->phoneBookId]); 
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'PhoneNumber');
                $phoneNumbers = $stmt->fetchAll(); 
                //get just the phone numbers
                $phoneNumbers = array_column($phoneNumbers, 'phoneNumber');
                
                $stmt = $pdo->prepare("SELECT email FROM Email WHERE phoneBookId = ?"); 
                $stmt->execute([$this->phoneBookId]);    
                $emails = $stmt->fetchAll();             
                $emails = array_column($emails, 'email');

                $item[0]->phoneNumbers = $phoneNumbers;
                $item[0]->emails = $emails;
            }

            $stmt = null;
            $pdo->commit();            

        }catch(exception $ex){
            $success = false;
            echo "Connection failed: " . $ex->getMessage();

            if($pdo != null){ $pdo->rollBack();}

        }finally{//close connection
            $pdo = null;
        }

        return $item;

    }


    public function filter(){

        $pdo = null;

        $listPhoneBooks = null;

        try{

            $dbContext = new DBHelper();            
            $pdo = $dbContext->getConnection();

            $pdo->beginTransaction();

            $query = "
                SELECT DISTINCT pb.*
                FROM PhoneBook pb
                LEFT JOIN PhoneNumber pn ON pn.phoneBookId = pb.phoneBookId
                LEFT JOIN Email em ON em.phoneBookId = pb.phoneBookId
                WHERE 1<>1 ";
            

            //add firstname filter
            if( isset($this->firtname) && trim($this->firtname) !== ""){
                $query = $query . " OR pb.firstname LIKE '%".$this->firtname."%'";
            }

            //add lastname filter
            if( isset($this->lastname) && trim($this->lastname) !== ""){
                $query = $query . " OR pb.lastname LIKE '%".$this->lastname."%'";
            }

            if(is_array($this->phoneNumbers)){

                foreach($this->phoneNumbers as $item ){
                    $query = $query . " OR pn.phoneNumber LIKE '%".$item."%'";
                }                
            }

            if(is_array($this->emails)){

                foreach($this->emails as $item ){
                    $query = $query . " OR em.email LIKE '%".$item."%'";
                }                
            }

            echo $query;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            
            $stmt->setFetchMode(PDO::FETCH_GROUP|PDO::FETCH_CLASS, 'PhoneBook');
            
            $listPhoneBooks = $stmt->fetchAll(); 

            if(sizeof($listPhoneBooks)>0){

                foreach($listPhoneBooks as $index => $item ){

                    $stmt = $pdo->prepare("SELECT phoneNumber FROM PhoneNumber WHERE phoneBookId = ?"); 
                    $stmt->execute([$item->phoneBookId]); 
                    $stmt->setFetchMode(PDO::FETCH_CLASS, 'PhoneNumber');
                    $phoneNumbers = $stmt->fetchAll(); 
                    
                    $phoneNumbers = array_column($phoneNumbers, 'phoneNumber');
                    
                    $stmt = $pdo->prepare("SELECT email FROM Email WHERE phoneBookId = ?"); 
                    $stmt->execute([$item->phoneBookId]);    
                    $emails = $stmt->fetchAll();             
                    $emails = array_column($emails, 'email');
    
                    $item->phoneNumbers = $phoneNumbers;
                    $item->emails = $emails;
                }              
            }

            $stmt = null;
            $pdo->commit();            

        }catch(exception $ex){
            $success = false;
            echo "Connection failed: " . $ex->getMessage();

            if($pdo != null){ $pdo->rollBack();}

        }finally{//close connection
            $pdo = null;
        }

        return $listPhoneBooks;

    }

}

?>