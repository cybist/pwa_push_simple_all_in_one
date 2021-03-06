function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding)
    .replace(/\-/g, '+')
    .replace(/_/g, '/');

  const rawData = window.atob(base64);
  const outputArray = new Uint8Array(rawData.length);

  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}

navigator.serviceWorker.register('service-worker.js');
navigator.serviceWorker.ready
.then(function(registration) {
  return registration.pushManager.getSubscription()
  .then(async function(subscription) {
    if (subscription) {
      return subscription;
    }

    const response = await fetch('./vapidPublicKey');
    const vapidPublicKey = await response.text();
    const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);

    return registration.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: convertedVapidKey
    });
  });
}).then(function(subscription) {
  const key = subscription.getKey('p256dh');
  const token = subscription.getKey('auth');
  subscription['userPublicKey'] = btoa(String.fromCharCode.apply(null, new Uint8Array(key)));
  subscription['userAuthToken'] = btoa(String.fromCharCode.apply(null, new Uint8Array(token)));
  fetch('/register.php', {
    headers: {'Content-type': 'application/json'},
    method: "post",
    body: JSON.stringify(subscription)
  });
});
