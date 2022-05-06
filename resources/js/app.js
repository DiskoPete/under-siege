import Echo from 'laravel-echo';
import Alpine from "alpinejs";

// TODO - Dont expose pusher - solved in websnap?
window.Pusher = require('pusher-js');

function getSocketHost() {
    let host = window.location.host;
    host = host.replace(/www\./, '');

    return 'socket.' + host;
}

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: getSocketHost(),
    wsPort: 443,
    wssPort: 443,
    forceTLS: false,
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});

window.Alpine = Alpine;
Alpine.start();
