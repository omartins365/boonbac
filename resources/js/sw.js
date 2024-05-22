import { precacheAndRoute, cleanupOutdatedCaches } from 'workbox-precaching';
import { warmStrategyCache } from 'workbox-recipes';
import { registerRoute, setCatchHandler } from 'workbox-routing';
import { CacheFirst, NetworkFirst, NetworkOnly, StaleWhileRevalidate } from 'workbox-strategies';
import { CacheableResponsePlugin } from 'workbox-cacheable-response';
import { ExpirationPlugin } from 'workbox-expiration';

precacheAndRoute(self.__WB_MANIFEST || []);


self.addEventListener('install', () => {
    void self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
});

// const OFFLINE = '/offline';
// Fallback assets to cache
const FALLBACK_HTML_URL = '/offline?v=1';
const FALLBACK_IMAGE_URL = '/images/assets/ad-comingsoon.jpg';
const FALLBACK_STRATEGY = new CacheFirst();

// Warm the runtime cache with a list of asset URLs
warmStrategyCache({
    urls: [FALLBACK_HTML_URL, FALLBACK_IMAGE_URL],
    strategy: FALLBACK_STRATEGY,
});


cleanupOutdatedCaches();

registerRoute(/\.(?:png|jpg|jpeg|svg)$/, new CacheFirst({
    "cacheName": "images-cache",
    plugins: [new ExpirationPlugin({
        maxAgeSeconds: 2592000
    }), new CacheableResponsePlugin({
        statuses: [0, 200]
    })]
}), 'GET');

registerRoute(/\/(dashboard|dash|register|login)\/?.*/, new NetworkOnly(), 'GET');

registerRoute(({
    request,
    url
}) => request.destination === 'script', new StaleWhileRevalidate({
    "cacheName": "script-cache",
    plugins: [new CacheableResponsePlugin({
        statuses: [0, 200]
    })]
}), 'GET');

registerRoute(({
    request,
    url
}) => request.destination === 'style' || request.destination === 'stylesheet', new StaleWhileRevalidate({
    "cacheName": "style-cache",
    plugins: [new CacheableResponsePlugin({
        statuses: [0, 200]
    })]
}), 'GET');

registerRoute(({
    request,
    url
}) => request.destination === 'document' || request.mode === 'navigate', new NetworkFirst({
    "cacheName": "page-cache",
    plugins: [new ExpirationPlugin({
        maxAgeSeconds: 1296000
    }), new CacheableResponsePlugin({
        statuses: [0, 200]
    })]
}), 'GET');


// This "catch" handler is triggered when any of the other routes fail to
// generate a response.
setCatchHandler(async ({ event, request }) => {
    // The warmStrategyCache recipe is used to add the fallback assets ahead of
    // time to the runtime cache, and are served in the event of an error below.
    // Use `event`, `request`, and `url` to figure out how to respond, or
    // use request.destination to match requests for specific resource types.
    switch (request.destination) {
        case 'document':
            return FALLBACK_STRATEGY.handle({ event, request: FALLBACK_HTML_URL });

        case 'image':
            return FALLBACK_STRATEGY.handle({ event, request: FALLBACK_IMAGE_URL });

        default:
            // If we don't have a fallback, return an error response.
            return Response.error();
    }
});
