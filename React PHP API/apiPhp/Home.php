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
    
    if($_SERVER["REQUEST_METHOD"] != "POST"):
        echo json_encode(array([
            "Code"=>0,
            "Message"=>"Page Not Found"])
        );
    elseif(
        !isset($data->user)
        || empty($data->user)
    ):
        echo json_encode(array([
            "Code"=>0,
            "Message"=>"Fill All The Required Fields !"])
        );

    else:
        $C=$data->user;
        $user_id=(int)$code->coding($C,"decrypt");

        $stmt=$user->GetById($user_id);

        if($stmt->rowCount()):
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(array(
                [
                    "Code"=>1,
                    "Message"=>"Welcom .",
                    "User"=>$row["UserName"]
                ]
            ));

        else:
            echo json_encode(array(
                [
                "Code"=>0,
                "Message"=>"Unauthorized !"
                ]
            ));
        endif;

    endif;


?>