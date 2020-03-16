const app = require('express')();
const fs = require('fs')
const server = require('http').Server(app);
const io = require('socket.io')(server);
const bodyParser = require('body-parser');
const routes = require('./controllers/chat.js');
const moment = require("moment")

app.use(handler)
app.use(bodyParser.json({ limit: '100mb' }));
app.use(bodyParser.urlencoded({ limit: '100mb', extended: true }));

server.listen(4000, function () {
  console.log('running on port no : 4000');
});

app.all('/*', function (req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Credentials", "true");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept, Key, Authorization");
  res.header("Access-Control-Allow-Methods", "POST, GET, OPTIONS, PUT, DELETE, PATCH");
  next()
});

//////////////////// CHAT MODELS start ///////////////////////
io.on('connection', function (socket) {
  console.log('socket connected');
  
  socket.on('room_join', function (msg) {
    console.log('room_join', msg);
    socket.join(msg.room_id, () => {
      io.to(msg.room_id).emit('room_join', { status: true, room_id: msg.room_id, sender_id: msg.sender_id });
    });
  });
  socket.on('room_leave', (msg) => {
    console.log('room_leave', msg.room_id);
    socket.leave(msg.room_id, () => {
      io.to(msg.room_id).emit('room_leave', { status: true, room_id: msg.room_id, sender_id: msg.sender_id });
    });
  })
  // socket.on('typeIn', (msg) => {
  //   console.log('typeIn', msg.room_id);
  //   io.to(msg.room_id).emit('typeIn', { status: true, room_id: msg.room_id, sender_id: msg.sender_id });
  // })
  // socket.on('typeOut', (msg) => {
  //   console.log('typeOut', msg.room_id);
  //   io.to(msg.room_id).emit('typeOut', { status: true, room_id: msg.room_id, sender_id: msg.sender_id });
  // })
  socket.on('message', function (msg) {
    console.log(msg)
    if (msg.room_id != null && msg.room_id != '' && msg.message != null && msg.message != '' && msg.sender_id != null && msg.sender_id != '') {

      var message = msg;
      message.created_on = moment().format("YYYY-MM-DD HH:mm:ss");
      message.read_status = '0';
      console.log("before emit")
      io.to(msg.room_id).emit('message', message);
      console.log("after emit")

      routes.save_chat(message);
      console.log("after chat saved")
      // callback(message);
    } else {
      console.log('wrong data')
    }
  });

  socket.on('message_read', function (msg, callback) {
    console.log("Message Read",msg)
    if (msg.room_id != "" && msg.room_id != null) {
      msg.check_status = '1';
      io.to(msg.room_id).emit('message_read', msg);
      console.log("message Checked Emmit",msg)
      routes.chat_read(msg);
    }
  })

});
function handler(req, res) {
  fs.readFile(__dirname + '/index.html',
    function (err, data) {
      if (err) {
        res.writeHead(500);
        return res.end('Error loading index.html');
      }
      res.writeHead(200);
      res.end(data);
    });
}
