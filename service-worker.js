// Service Worker for Dr.Phone POS - Progressive Web App
const CACHE_NAME = 'pos-app-v1';
const API_CACHE_NAME = 'pos-api-cache-v1';
const OFFLINE_URL = '/offline.html';

// Files to cache during installation
const STATIC_FILES = [
  '/',
  '/index.php',
  '/offline.html',
  '/manifest.json',
  '/styles/dashboard.css',
  '/styles/login.css',
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
  'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap'
];

// Installation event
self.addEventListener('install', (event) => {
  console.log('[Service Worker] Installing...');
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('[Service Worker] Caching static files');
        return cache.addAll(STATIC_FILES);
      })
      .catch((error) => {
        console.error('[Service Worker] Cache installation failed:', error);
      })
  );
  // Force the service worker to activate immediately
  self.skipWaiting();
});

// Activation event
self.addEventListener('activate', (event) => {
  console.log('[Service Worker] Activating...');
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames
          .filter((name) => {
            return name !== CACHE_NAME && name !== API_CACHE_NAME;
          })
          .map((name) => {
            console.log('[Service Worker] Deleting old cache:', name);
            return caches.delete(name);
          })
      );
    })
  );
  self.clients.claim();
});

// Fetch event - Network first for API, Cache first for assets
self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Skip cross-origin requests and certain patterns
  if (!url.origin.includes(location.origin)) {
    return;
  }

  // API requests - Network first, fall back to cache
  if (url.pathname.includes('/api/')) {
    event.respondWith(networkFirstStrategy(request));
    return;
  }

  // HTML files - Network first
  if (request.destination === 'document') {
    event.respondWith(networkFirstStrategy(request));
    return;
  }

  // Static assets - Cache first
  event.respondWith(cacheFirstStrategy(request));
});

// Network first strategy for API and HTML
async function networkFirstStrategy(request) {
  try {
    const response = await fetch(request);
    
    // Cache successful API responses
    if (request.url.includes('/api/') && response.status === 200) {
      const cache = await caches.open(API_CACHE_NAME);
      cache.put(request, response.clone());
    }
    
    return response;
  } catch (error) {
    console.log('[Service Worker] Network request failed, checking cache:', request.url);
    
    // Try to get from cache
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
      return cachedResponse;
    }

    // Return offline page for document requests
    if (request.destination === 'document') {
      return caches.match(OFFLINE_URL);
    }

    // Return a generic offline response
    return new Response('Offline - Service unavailable', {
      status: 503,
      statusText: 'Service Unavailable',
      headers: new Headers({
        'Content-Type': 'text/plain'
      })
    });
  }
}

// Cache first strategy for static assets
async function cacheFirstStrategy(request) {
  try {
    const cachedResponse = await caches.match(request);
    
    if (cachedResponse) {
      return cachedResponse;
    }

    const response = await fetch(request);

    // Cache successful responses
    if (response.status === 200) {
      const cache = await caches.open(CACHE_NAME);
      cache.put(request, response.clone());
    }

    return response;
  } catch (error) {
    console.log('[Service Worker] Cache first strategy failed:', request.url);
    
    // Fallback responses based on content type
    if (request.destination === 'image') {
      return new Response(
        '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><text x="50" y="50" text-anchor="middle" dy=".3em" fill="#999">Image unavailable</text></svg>',
        { headers: { 'Content-Type': 'image/svg+xml' } }
      );
    }

    return new Response('Resource unavailable offline', {
      status: 404,
      statusText: 'Not Found',
      headers: new Headers({
        'Content-Type': 'text/plain'
      })
    });
  }
}

// Handle messages from clients
self.addEventListener('message', (event) => {
  console.log('[Service Worker] Message received:', event.data);

  if (event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }

  if (event.data.type === 'CLEAR_CACHE') {
    caches.delete(CACHE_NAME).then(() => {
      console.log('[Service Worker] Cache cleared');
    });
  }

  if (event.data.type === 'CACHE_URLS') {
    caches.open(CACHE_NAME).then((cache) => {
      cache.addAll(event.data.urls).then(() => {
        console.log('[Service Worker] URLs cached successfully');
      });
    });
  }
});

// Background sync for offline actions
self.addEventListener('sync', (event) => {
  console.log('[Service Worker] Background sync triggered:', event.tag);
  
  if (event.tag === 'sync-sales') {
    event.waitUntil(syncOfflineSales());
  }
});

async function syncOfflineSales() {
  try {
    // Get pending sales from IndexedDB
    const db = await openIndexedDB();
    const pendingSales = await getPendingSalesFromDB(db);

    if (pendingSales.length > 0) {
      // Try to sync each pending sale
      for (const sale of pendingSales) {
        try {
          const response = await fetch('/api/sales', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(sale)
          });

          if (response.ok) {
            // Remove synced sale from IndexedDB
            await removePendingSaleFromDB(db, sale.id);
          }
        } catch (error) {
          console.error('[Service Worker] Failed to sync sale:', error);
        }
      }
    }
  } catch (error) {
    console.error('[Service Worker] Background sync failed:', error);
  }
}

function openIndexedDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open('POSAppDB', 1);
    
    request.onerror = () => reject(request.error);
    request.onsuccess = () => resolve(request.result);
    
    request.onupgradeneeded = (event) => {
      const db = event.target.result;
      if (!db.objectStoreNames.contains('pendingSales')) {
        db.createObjectStore('pendingSales', { keyPath: 'id' });
      }
    };
  });
}

function getPendingSalesFromDB(db) {
  return new Promise((resolve, reject) => {
    const transaction = db.transaction(['pendingSales'], 'readonly');
    const store = transaction.objectStore('pendingSales');
    const request = store.getAll();
    
    request.onerror = () => reject(request.error);
    request.onsuccess = () => resolve(request.result);
  });
}

function removePendingSaleFromDB(db, id) {
  return new Promise((resolve, reject) => {
    const transaction = db.transaction(['pendingSales'], 'readwrite');
    const store = transaction.objectStore('pendingSales');
    const request = store.delete(id);
    
    request.onerror = () => reject(request.error);
    request.onsuccess = () => resolve();
  });
}
