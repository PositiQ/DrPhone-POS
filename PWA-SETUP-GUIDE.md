# PWA (Progressive Web App) Setup Guide for Dr.Phone POS

This guide explains the PWA functionality that has been added to your Dr.Phone POS system.

## 📱 What is a PWA?

A Progressive Web App (PWA) is a web application that uses modern web capabilities to provide an app-like experience to users. It works offline, can be installed on devices, and provides features like push notifications and background sync.

## ✨ Features Added

### 1. **Offline Functionality**
- App works offline with cached content
- Service worker caches critical assets and API responses
- Users can continue viewing previously loaded data

### 2. **Installation**
- Users can install the app on their home screen (mobile & desktop)
- No need to go through app stores
- Native app-like experience

### 3. **Background Sync**
- Pending sales are saved locally when offline
- Data automatically syncs when connection is restored
- No data loss during disconnections

### 4. **App Shortcuts**
Quick access to:
- Create New Sale
- Check Inventory
- Manage Customers

### 5. **Smart Caching**
- **Static assets**: Cache first strategy (fast loading)
- **API calls**: Network first strategy (fresh data priority)
- Automatic cache invalidation

### 6. **Notifications**
- Ready for push notifications
- Can alert users about important events

## 🚀 Getting Started

### Files Added

1. **manifest.json** - App metadata and configuration
2. **service-worker.js** - Offline functionality and caching
3. **offline.html** - Fallback page when offline
4. **pwa-client.js** - Client-side PWA management

### HTML Integration

The PWA is automatically initialized in your PHP pages through:
```html
<link rel="manifest" href="/manifest.json">
<script src="/pwa-client.js"></script>
```

These have been added to:
- `login.php`
- `components/pages/index.php`
- Other main entry points should also have these added

## 🔧 Configuration

### Update Other PHP Pages

For all other PHP pages, add these to the `<head>` section:

```html
<meta name="theme-color" content="#1a237e">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="PositiQ POS">

<link rel="manifest" href="/manifest.json">
<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,...">
<link rel="apple-touch-icon" href="data:image/svg+xml,...">
```

Add at the start of `<body>`:
```html
<script src="/pwa-client.js"></script>
```

### Update Express Backend

Update your `app/app.js` to serve PWA files:

```javascript
// Add static file serving for root files
app.use(express.static(path.join(__dirname, '..')));

// Serve manifest.json
app.get('/manifest.json', (req, res) => {
  res.sendFile(path.join(__dirname, '..', 'manifest.json'));
});

// Serve service worker
app.get('/service-worker.js', (req, res) => {
  res.type('application/javascript');
  res.sendFile(path.join(__dirname, '..', 'service-worker.js'));
});

// Serve offline page
app.get('/offline.html', (req, res) => {
  res.sendFile(path.join(__dirname, '..', 'offline.html'));
});

// Serve PWA client library
app.get('/pwa-client.js', (req, res) => {
  res.type('application/javascript');
  res.sendFile(path.join(__dirname, '..', 'pwa-client.js'));
});
```

## 📲 Installation Methods

### Mobile (iOS/Android)

1. Open the app in your mobile browser
2. Look for "Add to Home Screen" or similar option
3. The app will appear on your home screen

### Desktop (Chrome/Edge)

1. Open the app in your browser
2. Click the install icon (usually in address bar)
3. App runs in standalone window

### Manual (Any Browser)

1. Add bookmark for offline access
2. Service worker caches content automatically

## 🔄 Offline Features

### What Works Offline

✅ View cached pages and data  
✅ Create sales transactions (saved locally)  
✅ Check product inventory (from cache)  
✅ View customer information  
✅ Access recent history  

### What Requires Connection

❌ Real-time data sync  
❌ Live API calls (initially)  
❌ New customer/product creation (until sync)  

## 💾 Data Management

### Automatic Sync

When connection is restored, the app automatically:
1. Syncs pending sales transactions
2. Updates customer and product data
3. Reconciles inventory
4. Shows success notification

### Manual Cache Control

```javascript
// Clear all cache
PWA.clearCache();

// Check storage usage
const usage = await PWA.getStorageUsage();
console.log(`Using ${usage.percentage}% of storage`);

// Request persistent storage
await PWA.requestPersistentStorage();
```

## 🔔 Notifications

### Enable Notifications

```javascript
// Request user permission
const permitted = await PWA.requestNotificationPermission();

// Send notification
if (permitted) {
  PWA.sendNotification('Sale Created', {
    body: 'New sale #12345 has been created',
    tag: 'sale-notification'
  });
}
```

## 🐛 Testing

### Test Offline Mode

1. **Chrome DevTools Method**:
   - Open DevTools (F12)
   - Go to Application → Service Workers
   - Check "Offline" checkbox

2. **Network Throttling**:
   - DevTools → Network tab
   - Select "Offline" from speed dropdown

3. **Browser Dev Tools**:
   - Application → Cache Storage
   - View what's cached

### Debug Service Worker

1. Go to `chrome://serviceworker-internals/` (Chrome)
2. Find your app's service worker
3. Check status and logs

## 🌐 Browser Support

| Feature | Chrome | Firefox | Safari | Edge |
|---------|--------|---------|--------|------|
| Service Workers | ✅ | ✅ | ✅ | ✅ |
| App Installation | ✅ | ✅ | ✅ | ✅ |
| Offline Support | ✅ | ✅ | ✅ | ✅ |
| Background Sync | ✅ | ✅ | ⏳ | ✅ |
| Push Notifications | ✅ | ✅ | ⏳ | ✅ |

## 📊 Caching Strategy

### Static Assets (Cache First)
- CSS files
- JavaScript files
- Fonts
- Images

**Behavior**: Serves from cache first, updates in background

### API Calls (Network First)
- Sales data
- Customer data
- Product data
- Transactions

**Behavior**: Tries network first, falls back to cache if offline

## 🔐 Security

The PWA includes:
- HTTPS-only recommendations
- Secure data caching
- IndexedDB for sensitive data
- CORS handling

**Recommendations**:
1. Always use HTTPS in production
2. Validate all API responses
3. Implement user authentication
4. Use secure headers

## 📝 Advanced Configuration

### Customize Caching

Edit `service-worker.js`:

```javascript
const STATIC_FILES = [
  '/',
  '/index.php',
  // Add your files here
];
```

### Custom Sync Tags

```javascript
// In your code:
self.addEventListener('sync', (event) => {
  if (event.tag === 'sync-custom-action') {
    // Handle custom sync
  }
});
```

### Update Check Interval

Change in `pwa-client.js`:
```javascript
this.updateCheckInterval = 60 * 60 * 1000; // Change this value
```

## 🐛 Troubleshooting

### Service Worker Not Registering

1. Check browser console for errors
2. Verify HTTPS (required in production)
3. Check manifest.json is valid JSON
4. Clear cache and reload

### App Not Installing

1. Ensure service worker is registered
2. Check manifest.json validity
3. Verify icon URLs are accessible
4. Try different browser

### Offline Page Not Showing

1. Verify offline.html exists
2. Check service worker cache
3. Clear browser cache
4. Check network settings

### Cache Not Updating

1. Service workers cache aggressively
2. Use DevTools → Network → Disable cache
3. Hard refresh (Ctrl+Shift+R)
4. Unregister and re-register service worker

## 📚 Additional Resources

- [MDN: Progressive Web Apps](https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps)
- [Web.dev: PWA Documentation](https://web.dev/progressive-web-apps/)
- [Google Workbox](https://developers.google.com/web/tools/workbox)
- [Service Worker API](https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API)

## 🚀 Next Steps

1. ✅ Update all PHP pages with PWA headers
2. ✅ Configure Express backend to serve PWA files
3. ✅ Test offline functionality
4. ✅ Enable HTTPS for production
5. ✅ Set up push notifications (optional)
6. ✅ Implement background sync for sales
7. ✅ Monitor cache usage

## 💬 Support

For issues or questions:
1. Check console logs (F12)
2. Review troubleshooting section
3. Check browser compatibility
4. Review service worker in DevTools

---

**Your app is now PWA-ready! Users can install and use it offline.** 🎉
