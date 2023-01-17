<?php
//set order status to released
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once $_SERVER['DOCUMENT_ROOT'] .'/accessdata/connection.php'; 
    $token=stripslashes(htmlspecialchars(trim($_POST["token"])));
    
    $pp=new Connection();
    $res=$pp->set_token($pp->ppuserid,$token);
    
    $arr["res"]=$res;
    echo json_encode($arr);
}

?>