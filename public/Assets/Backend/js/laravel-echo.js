import Echo from 'laravel-echo'

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '71182114e39989428ba8',
    cluster: 'us2',
    forceTLS: true
});

var channel = Echo.channel('my-channel');
channel.listen('.my-event', function(data) {
    alert(JSON.stringify(data));
});
