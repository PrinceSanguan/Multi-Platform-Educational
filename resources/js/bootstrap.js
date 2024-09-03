import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

// Listen for messages on the appropriate channel
window.Echo.private(`chat.${userId}`)
    .listen('MessageSent', (e) => {
        console.log('Message received:', e.message);
        // Update your chat UI here
    });