<?php

    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type:application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

    include_once("./DataBase/Database.php");
    include_once("./coder/coding.php");
    include_once("./config/config.php");

    $database=new Database();
    $con=$database->Connection();

    $user=new Users($con);

    $code=new Coder();

    $data=json_decode(file_get_contents("php://input"));

    if($_SERVER["REQUEST_METHOD"]!="POST"):
        echo json_encode(array(["Code" => 0,"Message" => "Page Not Found !"]));
        elseif(
            !isset($data->email) 
            || !isset($data->password)
            || empty(trim($data->email))
            || empty($data->password)
        ):
        echo json_encode(array(["Code" => 0,"Message" => "Fill All The Required Fields !"]));
        else:
            $email=trim($data->email);
            $password=trim($data->password);

            if(!filter_var($email,FILTER_VALIDATE_EMAIL)):
                echo json_encode(array(["Code" => 0,"Message" => "The Email Is Incorrect !"]));
            elseif(strlen($password) < 8):
                echo json_encode(array(["Code" => 0,"Message" => "The Password Must Be At Least 8 Characters !"]));
        
            else:
                try{
                    $stmt=$user->Login($email);

                    if($stmt->rowCount()):
                        $row=$stmt->fetch(PDO::FETCH_ASSOC);

                        $checkPass=password_verify($password,$row['Password']);
        
                        if($checkPass):

                            $val=$code->coding($row['ID'],'encrypt');

                            echo json_encode(array(
                                [
                                    "Code" => 1,
                                    "Message" => "You Have Logined Successfully .",
                                    "user"=>$val
                            ]));
                            
                        else:
                            echo json_encode(array(["Code" => 0,"Message" => "The Password Inccorrect !"]));
                        endif;

                        
                    else:
                        echo json_encode(array(["Code" => 0,"Message" => "Invalid Email Or Password !"]));
                    endif;

                }catch(PDOException $e){
                    echo json_encode(array(["Code" => 0,"Message" => $e->getMessage()]));
                }   
        endif;
    endif;


?>