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

Alpine.data('headerInput', () => ({
    headers: [],
    add() {
        this.headers.push({
            name: '',
            value: ''
        });
    },
    onInput(event, index) {
        this.headers[index].name = encodeURIComponent(event.target.value);
    }
}))

window.Alpine = Alpine;
Alpine.start();
