<!DOCTYPE html>
<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher("71182114e39989428ba8", {
            cluster: "us2"
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            document.getElementById("data").html(JSON.stringify(data));
        });
    </script>
</head>
<body>
<h1>Pusher Test</h1>
<p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
    <span id="data"></span>
</p>
</body>
