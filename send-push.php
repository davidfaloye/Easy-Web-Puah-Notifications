<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //require database
    $receiverUserid=stripslashes(htmlspecialchars(trim($_POST['receiverUserid'])));
    $yourtext=stripslashes(htmlspecialchars(trim($_POST['yourtext'])));
    
    
    $data["myMessage"]=$yourtext;
    $receiverToken=$pp->get_token($receiverUserid);//use userid to get his/her registered device token from database
    
    function push_notification_php($receiverToken, $data) {
    
        /* API URL */
        $url = 'https://fcm.googleapis.com/fcm/send';
    
        /* authorization_key */
        $authorization_key = 'AAAAts1YuD4:APA91bG19p7paiyXRfGmar3-oqH_iJg_l6Aq-VvSDj-PxRU88gB0_5_KX4J20BulZ4Oge_oMBAuQ-qGbwpuocDzT7TWYkTMQDSo42-6-r0JkapUK81qoRel-8ey1WDTj5acDhhSjQJOf';
    
        $fields = array(
            'registration_ids' => array($receiverToken),
            'data' => array (
                "message" => $data["myMessage"]
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
    
    

    
    $res=push_notification_php($receiverToken,$data);
    echo $res;
}
?>
