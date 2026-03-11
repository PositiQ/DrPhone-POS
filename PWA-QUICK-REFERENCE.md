# PWA Quick Reference Guide

## 🎯 Essential Features

### Offline Functionality
```javascript
// The app automatically caches data and works offline
// Users can continue working without internet connection
```

### Installation
- **Mobile**: Share/Install option in browser menu
- **Desktop**: Chrome/Edge install button in address bar
- **Result**: App on home screen, standalone window

### Automatic Sync
```javascript
// When connection is restored, the app automatically syncs:
window.PWA.syncPendingData(); // Manual sync
```

## 🔧 Usage Examples

### Working with Offline Sales

```javascript
// Create a sale (works offline too)
const saleData = {
  customer_id: '123',
  product_id: 'PROD001',
  quantity: 5,
  total_amount: 500
};

// Use OfflineSalesManager (loaded from offline-sales-manager.js)
const result = await window.OfflineSalesManager.createSale(saleData);

// Get pending sales
const pending = await window.OfflineSalesManager.getPendingSales();

// Sync when online
await window.OfflineSalesManager.syncAll();
```

### Notifications

```javascript
// Request permission
const permitted = await window.PWA.requestNotificationPermission();

// Send notification
if (permitted) {
  window.PWA.sendNotification('Sale Created', {
    body: 'Sale #12345 for $500',
    tag: 'sale-notification'
  });
}
```

### Storage Management

```javascript
// Check storage usage
const usage = await window.PWA.getStorageUsage();
console.log(`Using ${usage.percentage}% of storage`);

// Request persistent storage
await window.PWA.requestPersistentStorage();

// Clear cache
await window.PWA.clearCache();
```

### Online/Offline Status

```javascript
// Listen to status changes
document.addEventListener('pwa-status-changed', (event) => {
  if (event.detail.isOnline) {
    console.log('Back online!');
  } else {
    console.log('Going offline');
  }
});

// Check current status
console.log(navigator.onLine);
```

## 📋 Pages Ready for PWA

✅ login.php  
✅ components/pages/index.php (Dashboard)  
✅ components/pages/customers/index.php  
✅ components/pages/sales/index.php  
✅ components/pages/inventory/index.php  

## 📝 Pages Still Needing PWA Update

Add to `<head>`:
```html
<meta name="theme-color" content="#1a237e">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="PositiQ POS">

<link rel="manifest" href="/manifest.json">
<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,...">
<link rel="apple-touch-icon" href="data:image/svg+xml,...">
```

Add at start of `<body>`:
```html
<script src="/pwa-client.js"></script>
```

Remaining pages:
- components/pages/products/
- components/pages/returns-repairs/
- components/pages/vault-balance/
- components/pages/expenses/
- components/pages/settings/
- components/pages/shops/
- components/pages/suppliers/
- components/pages/users/
- components/pages/invoices-quotations/

## 🚀 Implementation Checklist

### Phase 1: Verification ✅
- [x] PWA files created
- [x] Service worker configured
- [x] Manifest generated
- [x] Express backend updated
- [x] Main pages updated

### Phase 2: Complete Coverage
- [ ] Update all remaining PHP pages
- [ ] Test offline functionality
- [ ] Test installation on mobile
- [ ] Test installation on desktop
- [ ] Verify cache settings

### Phase 3: Feature Implementation
- [ ] Implement offline sales saving
- [ ] Test sync functionality
- [ ] Enable notifications
- [ ] Test push notifications
- [ ] Monitor storage usage

### Phase 4: Production
- [ ] Enable HTTPS
- [ ] Set up analytics
- [ ] Configure CDN
- [ ] Monitor performance
- [ ] Gather user feedback

## 🧪 Testing Checklist

### Offline Testing
- [ ] Works offline (DevTools: Network → Offline)
- [ ] Cache displays correctly
- [ ] Sales can be saved offline
- [ ] Data syncs when online
- [ ] Offline page shows on error

### Installation Testing
- [ ] Install prompt shows on mobile
- [ ] Install option appears on desktop
- [ ] App launches in standalone mode
- [ ] App appears on home screen

### Performance Testing
- [ ] First load < 2 seconds
- [ ] Cached load < 500ms
- [ ] Cache size < 50MB
- [ ] Service worker responds < 100ms

### Compatibility Testing
- [ ] Works on Chrome/Chromium
- [ ] Works on Firefox
- [ ] Works on Safari
- [ ] Works on Edge
- [ ] Works on mobile browsers

## 🔄 Caching Strategy

### Static Assets (Cache First)
- CSS files
- JavaScript files
- Fonts
- Images
- Manifest

**TTL**: 30 days

### API Responses (Network First)
- Sales data
- Customer data
- Product data
- Transactions

**TTL**: 7 days

### HTML Pages (Network First)
- Dashboard
- Pages
- Content

**TTL**: 1 day

## 📊 Monitoring

### Check Service Worker
1. Open DevTools (F12)
2. Go to Application tab
3. Service Workers section
4. Look for registration status

### Check Cache
1. Application → Cache Storage
2. View cached files
3. Monitor cache size
4. Delete old caches

### Browser Logs
1. Open DevTools Console
2. Look for [PWA] messages
3. Check for errors
4. Monitor network activity

## 🔐 Security Checklist

- [ ] Using HTTPS (required for production)
- [ ] Validated all API responses
- [ ] No sensitive data in cache
- [ ] User authentication required
- [ ] Session tokens included
- [ ] CORS headers configured
- [ ] Content Security Policy set
- [ ] Secure headers implemented

## 📚 File Reference

| File | Purpose | Size |
|------|---------|------|
| manifest.json | App metadata | ~2KB |
| service-worker.js | Offline caching | ~15KB |
| offline.html | Offline fallback | ~8KB |
| pwa-client.js | PWA management | ~25KB |
| offline-sales-manager.js | Offline sales | ~5KB |

## 🆘 Troubleshooting

### Service Worker Not Registering
- Check browser console for errors
- Verify HTTPS (if not localhost)
- Ensure paths are correct
- Clear cache and reload

### App Not Installing
- Check manifest.json validity
- Verify icons are accessible
- Ensure service worker is active
- Try different browser

### Offline Not Working
- Verify service worker is active
- Check cache in DevTools
- Reload page (hard refresh: Ctrl+Shift+R)
- Check network settings

### Sync Not Working
- Verify online status changes
- Check IndexedDB in DevTools
- Monitor network activity
- Check console for errors

## 📞 Support Resources

- [PWA Setup Guide](./PWA-SETUP-GUIDE.md) - Comprehensive setup
- [Meta Tags Template](./PWA-META-TAGS-TEMPLATE.html) - Template for pages
- [Offline Sales Manager](./offline-sales-manager.js) - Offline transactions
- [MDN PWA Docs](https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps)
- [Web.dev PWA Guide](https://web.dev/progressive-web-apps/)

---

**Your app is PWA-ready! Start integrating the features today.** 🚀
