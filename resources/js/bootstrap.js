import Echo from "laravel-echo";
import Pusher from "pusher-js";


window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,   // from .env
    wsHost: window.location.hostname,           // guestly.space
    wsPort: 443,
    wssPort: 443,
    forceTLS: true,
    enabledTransports: ["ws", "wss"],
    disableStats: true,
});
