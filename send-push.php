<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once $_SERVER['DOCUMENT_ROOT'] .'/accessdata/connection.php'; 
    $receiverUserid=stripslashes(htmlspecialchars(trim($_POST['receiverUserid'])));
    $yourtext=stripslashes(htmlspecialchars(trim($_POST['yourtext'])));
    
    $pp=new Connection();
    $data["myUserID"]=$pp->ppuserid;
    $data["myFirstname"]=$pp->ppfirstname;
    $data["myMessage"]=$yourtext;
    $receiverToken=$pp->get_token($receiverUserid);
    
    function push_notification_php($receiverToken, $data) {
    
        /* API URL */
        $url = 'https://fcm.googleapis.com/fcm/send';
    
        /* authorization_key */
        $authorization_key = 'AAAAts1YuD4:APA91bG19p7paiyXRfGmar3-oqH_iJg_l6Aq-VvSDj-PxRU88gB0_5_KX4J20BulZ4Oge_oMBAuQ-qGbwpuocDzT7TWYkTMQDSo42-6-r0JkapUK81qoRel-8ey1WDTj5acDhhSjQJOf';
    
        $fields = array(
            'registration_ids' => array($receiverToken),
            'data' => array (
                "message" => $data["myMessage"],
                "senderFirstname"=>$data["myFirstname"],
                "senderUserid"=>$data["myUserID"]
            )
        );
        $fields = json_encode($fields);
    
        $headers = array (
                'Authorization: key=' . $authorization_key,
                'Content-Type: application/json'
        );
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    
        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);
    }
    
    
    // $id="eNck2Ezam1c:APA91bH0oo4Jy9ZIb_F2E-D4X3c2h-E8IM0QQ1qwx9x0oQ6GT5e1Zz1bwbbZXqvzdnpYkDCGT3G_QfYnnq_IZfZWOYpwCgyvOnjcANx1DTcFTt6J4p6rR0EbkPbwkye2fy-8s80x0YM3";
    // $message="heyyy boy!";
    
    $res=push_notification_php($receiverToken,$data);
    echo $res;
}
?>