<?php
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    
    include_once '../../config/database.php';
    include_once '../../models/users.php';
    include_once '../sendmail.php';

    $database=new Database();
    $db=$database->connect();
    
    $user=new Users($db);

    $data=json_decode(file_get_contents("php://input"));

    $user->email=htmlspecialchars(strip_tags($data->email));

    $result=$user->read_one();
    
    if($result){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-=~!@#$%^&*0123456789";
        $newpassword = substr( str_shuffle( $chars ), 0, 16 );
        $hashpassword=password_hash($newpassword, PASSWORD_DEFAULT);
        $resetting=$user->update($hashpassword);
        
       
        if($resetting){
         
            if(sendemail($newpassword,$user->email)){
                echo json_encode(array("message"=>"A email has sent to your mail id."));
            }
            else{
                echo json_encode(array("message"=>"The password has changed but the mail server has problems"));
            }
        }
        else{
       
            echo json_encode(array("message"=>"pls try again later."));
        }


    }else{
        echo json_encode(array("message"=>"user not found"));
    }

?>