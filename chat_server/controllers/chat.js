var apn = require("apn"),
    options, connection, notification;

var FCM = require('fcm-node');
var serverKey = 'AAAAi--X1sc:APA91bHxW7xGWwYSKsFqsOjI6KZRQT0WbCRAWST0-KNZYN6U0vzFhtEkm8ApfOhzy0uWK-Ag9cM1VXygabqMiczh2rKFF0h-Lq-DncumuOWqNGP01o9ldiqTUCfaBcRMFdNyXKU_SC9n';
var fcm = new FCM(serverKey);

var mysql = require('mysql');
var db = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "etapp@2019",
  database:"etappdb"
});

db.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});

exports.save_chat = function(msgdata) {
    let sql  = `INSERT INTO chat (sender_id, reciver_id,room_id,message) VALUES (${msgdata.sender_id},${msgdata.reciver_id},'${msgdata.room_id}','${msgdata.message}')`;  
    
    db.query(sql,(err,result)=>{
      if(err){
        console.log("Chat save in Chat Table Error ===========>",err);
      }else{
        let sql  = `Update chat_room set last_message ='${msgdata.message}' WHERE room_id = '${msgdata.room_id}'`;  
        console.log(sql);
        console.log("iddddddddddddd=>>>>>>>>>>>>",msgdata.reciver_id);
        let sql1 = `SELECT * FROM users WHERE id = ${msgdata.reciver_id}`;
        db.query(sql1, (error1, result1)=>{

          let userToken = result1[0];
          console.log('User token ',userToken);

          if(userToken.device_token != null) {
              
              let sql2 = `SELECT * FROM chat WHERE sender_id = ${msgdata.sender_id} AND reciver_id = ${msgdata.reciver_id} AND read_status = 0`;
              db.query(sql2, (error2, result2)=>{
                let dataCount = result2.length;

                if(userToken.device_type == "android") {
                    sendNotification(userToken.device_token, `${msgdata.userName} send a message`, "New message received",msgdata.sender_id,msgdata.userName,msgdata.userImage,msgdata.position,msgdata.room_id, (error11, result11) => {
                        
                        if (error11) {
                            console.log("Error 10 is=========>", error11);
                        }
                        else {
                            console.log("Send notification is=============>", result11);
                        }
                    })
                } else {
                    sendiosNotification1(userToken.device_token, `${msgdata.userName} send a message`, `${msgdata.userName} send a message`,msgdata.sender_id,dataCount,msgdata.userName,msgdata.userImage,msgdata.position,msgdata.room_id, (error11, result11) => {
                        
                        if (error11) {
                            console.log("Error 10 is=========>", error11);
                        }
                        else {
                            console.log("Send notification is=============>", result11);
                        }
                    })
                }
              });
          }
        });

        db.query(sql,(err1,result)=>{
          if(err1) console.log(" Chat Save in Chat room Error",err1)
          else console.log("Chat saved to database ",msgdata)
        })
    
      } 
    })    
}

exports.chat_read=(msg)=>{
  let sql = `UPDATE chat set read_status='1' WHERE  room_id = '${msg.room_id}'`;
  db.query(sql,(err,result)=>{
    if(err) console.log("Went wrong in Change status")
  })
}


function sendiosNotification1(deviceToken,title, msg,rid,dataCount,userName,userImage,position,roomid, callback) {
    console.log('IOS notify');
    var options = {
        "cert": "/var/www/html/CertificatesPushDistribution.pem",
        "key": "/var/www/html/CertificatesPushDistribution.pem",
        production:true
    };
    var apnProvider = new apn.Provider(options);
    var note = new apn.Notification();
    note.expiry = Math.floor(Date.now() / 1000) + 3600;
    note.badge = dataCount;
    note.sound ="default";
    note.alert= msg;
    note.payload = {title:title,msg: msg,sender_id:rid,room_id:roomid,userName:userName,userImage:userImage,position:position,type:'chat' };
    note.topic = "com.EventTrackler.App";
    apnProvider.send(note, deviceToken).then( (result) => {
       console.log("Ios notication send successfully is=============>",result);
      })
      .catch((e)=>{
          console.log("err in sending ios notification is==================>",e);
      })
};


function sendNotification(deviceToken, title, body,rid,userName,userImage,position,roomid,callback){
    console.log("Token is=======>",deviceToken);
    console.log("Position ",position);
    var message = {
        to: deviceToken,
        data: {
            title: title,
            body: body,
            sender_id:rid,
            room_id:roomid,
            userName:userName,
            userImage:userImage,
            position:position,
            type: 'chat'
        }
    };
    console.log("Message is=========>",message);
    fcm.send(message, function(err, response) {
        if (err) {
          console.log("Error in sending android notification===========>",err);
        } else {
            console.log('Android notification send successfully',response);
        }
    })

}

// exports.find_chat = function(req, res) {
//     if(req.body.room_id){
//         GroupChat.find({room_id:req.body.room_id}).then(data=>{
//             res.send({status:true, message:'Chat found', data:data })
//         },error=>{
//             res.send({status:false, message:'something went wrong'})
//         })
//     }else{
//         res.send({status:false, message:'Please send room_id'})
//     }
    
// }