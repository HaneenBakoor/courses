<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
  <script>


    Pusher.logToConsole = true;

    var pusher = new Pusher('f69a64258df4ce191e92', {
      cluster: 'mt1',
 disableStats: true,
  enabledTransports: ['sockjs', 'xhr_streaming', 'xhr_polling']
    });



/////
channel.bind('App\\Events\\MyBroadcastEvent', function(data) { // Note the double backslashes
    alert(JSON.stringify(data));
});




    var channel = pusher.subscribe('my-channel');
    {{--  channel.bind('MyBroadcastEvent', function(data) {
    alert(JSON.stringify(data));
});  --}}

    channel.bind('MyBroadcastEvent', function(data) {
    console.log('Event received:', data);
});





  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>


</body>
