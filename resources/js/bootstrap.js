import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: process.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
    wsHost: window.location.hostname,
    wsPort: 6001,       // WebSocket server port
    wssPort: 443,       // SSL port
    forceTLS: true,

});
