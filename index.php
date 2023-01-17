<!doctype html>
<html>
    <head>
        <title>Push Notification</title>
    </head>
<body<
<div>
    <!--your content--> 
</div>



<script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>

<script>
    //config details gotten from firbase account
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

})
.catch(function (err) {
console.log("Unable to get permission to notifyx.", err);
});

messaging.onMessage(function(payload) {
console.log("Message received. ", payload);
alert(payload['data']['pinpoint.notification.title']+"---"+payload['data']['pinpoint.notification.body']);
});
</script>
    
    
</body>
</html>
