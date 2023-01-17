<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //require database and userid
    $token=stripslashes(htmlspecialchars(trim($_POST["token"])));//receive unique device token

    $res=set_token($userid,$token);//store token for a particular
    
    $arr["res"]=$res;
    echo json_encode($arr);//send feedback
}

?>
