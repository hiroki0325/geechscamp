var io = require('socket.io').listen(process.env.PORT, process.env.IP);
console.log((new Date()) + " Server is listening");

io.sockets.on('connection', function(socket) {
  // 入室
  socket.on('enter', function(roomname) {
      socket.name = roomname;
      // socket.set('roomname', roomname);
      socket.join(roomname);
  });

  socket.on('message', function(message) {
    emitMessage('message', message);
  });

  socket.on('disconnect', function() {
    emitMessage('user disconnected');
  });

  // 会議室名が指定されていたら、室内だけに通知
  function emitMessage(type, message) {
    var roomname;
    roomname = socket.name;
    // socket.get('roomname', function(err, _room) {  roomname = _room;  });

    if (roomname) {  socket.broadcast.to(roomname).emit(type, message);   }
    else {   socket.broadcast.emit(type, message);   }
  }
});
