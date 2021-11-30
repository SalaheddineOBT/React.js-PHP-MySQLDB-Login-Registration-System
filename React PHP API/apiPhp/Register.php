<?php

    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type:application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
    
    include_once("./DataBase/Database.php");
    include_once("./config/config.php");

    $database=new Database();
    $con=$database->Connection();

    $user=new Users($con);

    $data=json_decode(file_get_contents("php://input"));

    if($_SERVER["REQUEST_METHOD"] != "POST"):
        echo json_encode(array([
            "Code"=>0,
            "Message"=>"Page Not Found"])
        );
        
    elseif(
        !isset($data->username) 
        || !isset($data->email) 
        || !isset($data->password)
        || empty(trim($data->username))
        || empty(trim($data->email))
        || empty(trim($data->password))
    ):
        echo json_encode(array(["Code"=>0,"Message"=>"The Fields Are Required !"]));
    
    else:
        $username=$data->username;
        $email=$data->email;
        $password=$data->password;

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)):
            echo json_encode(array(["Code"=>0,"Message"=>"The Email Format Is Incorrect !!"]));
        
            elseif(strlen($password) < 8):
                echo json_encode(array(["Code"=>0,"Message"=>"The Password Must Be At Least 8 Characters !!"]));
            
            elseif(strlen($username) < 4):
                echo json_encode(array(["Code"=>0,"Message"=>"The User Name Must Be At Least 4 Characters !!"]));

            else:
                try{

                    $sqlEmail="SELECT * FROM users WHERE Email='".$email."'";
                    $stmtEmail=$con->prepare($sqlEmail);
                    $stmtEmail->execute();

                    if($stmtEmail->rowCount()):
                        echo json_encode(array(["Code"=>0,"Message"=>"Email Already Existe !"]));
                    else:
                        $user->username=$username;
                        $user->email=$email;
                        $user->password=$password;

                        if($user->Register()):
                            echo json_encode(array(["Code"=>1,"Message"=>"Successfull Register"]));
                        else:
                            echo json_encode(array(["Code"=>0,"Message"=>"Failed Register"]));
                        endif;
                    endif;
                }catch(PDOException $e){
                    echo json_encode(array(["Code"=>0,"Message"=>$e->getMessage()]));
                }
        endif;
    endif;

?>