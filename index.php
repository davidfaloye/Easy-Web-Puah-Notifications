<?php
$title="Orders";
require_once $_SERVER['DOCUMENT_ROOT'] .'/hats/heads.php';
$pendingorders=$pp->get_unreleasedOrders($user_id);

?>

<div class='container'>
    <div class='columns is-centered mb-5 pb-5'>
        <div class='column is-6 has-text-left'>
            
            <p class='has-text-black has-text-weight-bold is-size-4' style="font-size:1.9rem !important;">Welcome <?= $firstname ?>,</p>
            <p class='has-text-black has-text-weight-bold is-size-4' style="padding-bottom:30px;"><?= date("D, M jS") ?></p>
  
        <?php
        if(empty($pendingorders)){
            ?>
            <figure class='image is-3by1'>
                <img src="../imgs/cash-deliveryx.png" height="200px" />
            </figure><br>
            <hr>
            <img src="../imgs/no-orders-yet.png" class="noordersimg" />
            <p class='has-text-black is-size-4' style="text-align:center; margin-bottom:20px;">Ooops! You have no pay-on-delivery orders yet!</p>
            <p style="text-align:center;">
            <a target="_blank" href="https://pooppay.com.ng"><button class="button" style="background-color:#26d706; color:#ffffff; font-size:20px !important; margin-bottom:50px; padding-top:23px;
    padding-bottom:23px;"><i class="material-symbols-rounded has-text-weight-bold pr-2">add_shopping_cart</i><span>Start Shopping</span></button></a>
            </p>
            <hr>
            <?php
        }else{
            ?>
            <div class='my-5'>
            <?php
            foreach($pendingorders as $val){
                $oid=$val['order_id'];
                $status=$val['status'];;
                $date=date_create($val['date_stamp']);
                date_add($date,date_interval_create_from_date_string("1 day"));
                $adayAfter=date_format($date,"Y-m-d H:i:s");
                $today=date("Y-m-d H:i:s");
                $withdraw_ph=$today>$adayAfter?"<strong>Order sent</strong>":"<button type='button' class='button withdraw is-success' id='$oid'>Withdraw</button>";
                $disabled=$status==$pp->COMPLETED?"":"disabled";
        ?>
            
                <div class='pb-3' align='center'>
                    <div class='column is-12 box'>
                        <div class='is-flex is-justify-content-space-between'>
                            <span class='is-size-6 has-text-weight-bold'><?= date("D, M Y",strtotime($val['order_date'])) ?></span><span class='is-size-6 has-text-weight-bold'>#<?= $oid ?></span>
                        </div>
                        <br>
                        <div align='left'>
                        <p class='is-size-3 has-text-weight-bold'>N<?= number_format($val['amount']) ?></p>
                        <p class='is-size-6 has-text-weight-bold'><?= $val['product_title'] ?></p>
                        <br>
                        
                        <p class='has-text-center is-size-7 is-flex is-align-items-start'><i class="material-symbols-rounded">info</i> You have 24hrs to withdraw your money and cancel the order. 
                        Pooppay may not be responsible for refunds after the 'Release' button has been clicked.</p>
                        </div>
                        <hr/>
                        <div class='is-flex is-justify-content-space-between is-align-items-center'>
                            <div><?= $withdraw_ph ?></div>
                            <div><button type='button' class='button is-success release' id="<?= $oid ?>" <?= $disabled ?>>Release</button></div>
                        </div>
                    </div>
                </div>
            
        <?php
            }
        ?>
        </div>
        <?php
        }
        ?>
        
        <br>
        
        <?php
        if(!empty($allmyorders)){
            $transactionCount=0;
        ?>
            <p class='is-size-4 is-underlined has-text-left pl-4'>Transactions</p><br>
            <div class='box'>
            <?php
            foreach($allmyorders as $val){
                $transactionCount++;
            ?>
                <div class='box is-flex is-justify-content-space-between is-align-items-center is-size-6 has-text-weight-bold'>
                    <span>N<?= number_format($val['amount']) ?></span>
                    <div>
                    <span class='mr-3'><?= $val['order_date'] ?></span>
                    <span style='border-radius:20px; background-color:#87ceeb;' class='px-3 py-2'><?= $val['status'] ?></span>
                    </div>
                </div>
            <?php
            if($transactionCount==4){
                echo "<br><div class='has-text-centered'><a class='is-underlined is-size-5 see_all'>See all</a></div>";
                break;
            }else{
                continue;
            }
            }
        }
        ?>
        </div>
        </div>
        
        
    </div>
</div>


<script>
    $(function(){
        
        
        $(".withdraw").click(function(){
            swal({
                title:"Confirm withdrawal",text:"",icon:"info",buttons:true,dangerMode:true
            }).then(res=>{
                if(res==true){
                    let orderid=$(this).attr("id");
                    $.post("handle-withdrawal.php",{orderid:orderid},function(data,status){
                        if(status=='success'){
                            data=JSON.parse(data);
                            let obj=(data['res']=="perfect")?{msg:"Withdrawal successful.",submsg:"",style:"success"}:{msg:data['res'],submsg:"",style:"info"}
                            swal(obj['msg'],obj['submsg'],obj['style']).then(value=>{
                                location.reload()
                            })
                        }
                    });
                }
            });
            
        });
        
        $(".release").click(function(){
            let orderid=$(this).attr("id");
            $.post("handle-release.php",{orderid:orderid},function(data,status){
                if(status=='success'){
                    data=JSON.parse(data);
                    let obj=(data['res']=="perfect")?{msg:"Funds release successful.",submsg:"",style:"success"}:{msg:data['res'],submsg:"",style:"info"}
                    swal(obj['msg'],obj['submsg'],obj['style']).then(value=>{
                        location.reload()
                    })
                }
            });
            
        });
    });
</script>
<script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>

<script>
var existingToken="<?= $token ?>";
var config = {
apiKey: "AIzaSyAdkeZ7j1qzFXFsV3fnuTYzSFeo9YmdWnU",
authDomain: "notifier-4f0de.firebaseapp.com",
databaseURL: "https://notifier-4f0de-default-rtdb.firebaseio.com",
projectId: "notifier-4f0de",
storageBucket: "notifier-4f0de.appspot.com",
messagingSenderId: "785129191486",
appId: "1:785129191486:web:691b0708e122cc5377396f",
measurementId: "G-8TQ5B38XK0"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();

messaging
.requestPermission()
.then(function () {
console.log("Notification permission granted.");

return messaging.getToken()
})
.then(function(token) {
console.log(token)
if(token===existingToken){
    console.log("recognized device!")
}
else{
    try{
        $.post("handle-token.php",{token:token},function(data,status){
            if(status=='success'){
                data=JSON.parse(data)
                console.log(data['res'])
            }
        })
    }
    catch(err){
        console.log(err.message)
    }
}
})
.catch(function (err) {
console.log("Unable to get permission to notifyx.", err);
});

messaging.onMessage(function(payload) {
console.log("Message received. ", payload);
swal(payload['data']['pinpoint.notification.title'],payload['data']['pinpoint.notification.body'],"info");
});
</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/hats/tails.php';
?>