var app = require('express')();
var http = require('http').createServer(app);
var io = require('socket.io')(http);

app.get('/', function(req, res){
  res.sendFile(__dirname + '/chat.html');
});
let room = ['room1', 'room2'];
let a = 0;

io.on('connection', function(socket){
  console.log('a user connected');

  socket.on('chat message', function(msg){
    console.log('message: ' + msg);
    io.emit('chat message', msg);

  });

  socket.on('leaveRoom', (num, name) => {
      socket.leave(room[a], () => {
        console.log(name + ' leave a ' + room[a]);
        io.to(room[a]).emit('leaveRoom', num, name);
      });
    });


    socket.on('joinRoom', (num, name) => {
      socket.join(room[a], () => {
        console.log(name + ' join a ' + room[a]);
        io.to(room[a]).emit('joinRoom', num, name);
      });
    });


  socket.on('disconnect', function(){
    console.log('user disconnected');
    console.log(name + ' leave a ' + room[a]);
    io.to(room[a]).emit('leaveRoom', num, name);

  });
});


http.listen(3000, function(){
  console.log('listening on *:3000');
});
