var CACHE_NAME = 'v1-n';
self.addEventListener('install', function(event) {
  console.log('[ServiceWorker] Install');
  event.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
      return cache.addAll([
        '{プリキャッシュしたい画面のパス}'
      ]);
    })
  );
});

self.addEventListener('activate', function(event) {  
  console.log('[ServiceWorker] Activate');
  event.waitUntil(
    caches.keys().then(function(cache) {
      cache.map(function(name) {
        if(CACHE_NAME !== name) caches.delete(name);
      })
    })
  );
});

self.addEventListener('fetch', function(event) {
  console.log('[ServiceWorker] Fetch');
  event.respondWith(
    caches.match(event.request).then(function(res) {
      if(res) return res;
      return fetch(event.request);
    })
  );
});

self.addEventListener('push', function (event) {
    console.log('[ServiceWorker] Push');
    const title = 'by pwa.ketoha.com';
    const options = {
        body: event.data.text(),
        tag: title,
        icon: '/img/icon-256.png',
        badge: '/img/icon-256.png'
    };
    event.waitUntil(self.registration.showNotification(title, options));
});
