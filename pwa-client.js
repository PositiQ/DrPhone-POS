/**
 * PWA Client Library for Dr.Mobile POS
 * Handles service worker registration, updates, and offline features
 */

class POSPWAManager {
  constructor() {
    this.serviceWorkerRegistration = null;
    this.updateCheckInterval = 60 * 60 * 1000; // Check for updates every hour
    this.offlineSalesDB = null;
    this.isOnline = navigator.onLine;
    
    this.init();
  }

  /**
   * Initialize PWA functionality
   */
  async init() {
    console.log('[PWA] Initializing PWA manager');

    // Register service worker
    if ('serviceWorker' in navigator) {
      try {
        this.serviceWorkerRegistration = await navigator.serviceWorker.register('/service-worker.js');
        console.log('[PWA] Service Worker registered successfully');

        this.handleServiceWorkerUpdates();
        this.checkForUpdates();
      } catch (error) {
        console.error('[PWA] Service Worker registration failed:', error);
      }
    }

    // Initialize offline database
    this.initOfflineDB();

    // Set up online/offline listeners
    window.addEventListener('online', () => this.handleOnline());
    window.addEventListener('offline', () => this.handleOffline());

    // Install prompt handling
    window.addEventListener('beforeinstallprompt', (e) => this.handleInstallPrompt(e));
    window.addEventListener('appinstalled', () => this.handleAppInstalled());

    // Share target handling
    if (location.pathname.includes('/share')) {
      this.handleShareTarget();
    }
  }

  /**
   * Handle service worker updates
   */
  handleServiceWorkerUpdates() {
    const registration = this.serviceWorkerRegistration;

    registration.addEventListener('updatefound', () => {
      const newWorker = registration.installing;

      newWorker.addEventListener('statechange', () => {
        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
          console.log('[PWA] New service worker available');
          this.notifyUpdate();
        }
      });
    });

    // Listen for messages from service worker
    navigator.serviceWorker.addEventListener('message', (event) => {
      if (event.data.type === 'UPDATE_AVAILABLE') {
        this.notifyUpdate();
      }
    });
  }

  /**
   * Check for service worker updates
   */
  checkForUpdates() {
    if (!this.serviceWorkerRegistration) return;

    setInterval(() => {
      this.serviceWorkerRegistration.update().catch((error) => {
        console.error('[PWA] Failed to check for updates:', error);
      });
    }, this.updateCheckInterval);
  }

  /**
   * Notify user about available update
   */
  notifyUpdate() {
    const updateBanner = document.createElement('div');
    updateBanner.className = 'pwa-update-banner';
    updateBanner.innerHTML = `
      <div class="pwa-update-content">
        <span>A new version of PositiQ POS is available</span>
        <div class="pwa-update-actions">
          <button class="btn-update" onclick="window.location.reload()">Update Now</button>
          <button class="btn-dismiss" onclick="this.parentElement.parentElement.remove()">Dismiss</button>
        </div>
      </div>
    `;

    // Add styles
    if (!document.getElementById('pwa-update-styles')) {
      const styles = document.createElement('style');
      styles.id = 'pwa-update-styles';
      styles.textContent = `
        .pwa-update-banner {
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);
          color: white;
          padding: 16px;
          z-index: 9999;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
          animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
          from {
            transform: translateY(-100%);
          }
          to {
            transform: translateY(0);
          }
        }

        .pwa-update-content {
          display: flex;
          justify-content: space-between;
          align-items: center;
          max-width: 1200px;
          margin: 0 auto;
          gap: 20px;
        }

        .pwa-update-actions {
          display: flex;
          gap: 8px;
        }

        .btn-update, .btn-dismiss {
          padding: 8px 16px;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          font-weight: 600;
          transition: all 0.2s ease;
          font-size: 12px;
        }

        .btn-update {
          background: #4caf50;
          color: white;
        }

        .btn-update:hover {
          background: #388e3c;
        }

        .btn-dismiss {
          background: rgba(255, 255, 255, 0.2);
          color: white;
        }

        .btn-dismiss:hover {
          background: rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
          .pwa-update-content {
            flex-direction: column;
            align-items: flex-start;
          }

          .pwa-update-actions {
            width: 100%;
          }

          .btn-update, .btn-dismiss {
            flex: 1;
          }
        }
      `;
      document.head.appendChild(styles);
    }

    document.body.insertBefore(updateBanner, document.body.firstChild);
  }

  /**
   * Initialize offline database
   */
  async initOfflineDB() {
    return new Promise((resolve, reject) => {
      const request = indexedDB.open('POSAppDB', 1);

      request.onerror = () => {
        console.error('[PWA] IndexedDB opening failed');
        reject(request.error);
      };

      request.onsuccess = () => {
        this.offlineSalesDB = request.result;
        console.log('[PWA] IndexedDB initialized');
        resolve(this.offlineSalesDB);
      };

      request.onupgradeneeded = (event) => {
        const db = event.target.result;

        // Create object stores
        if (!db.objectStoreNames.contains('pendingSales')) {
          const salesStore = db.createObjectStore('pendingSales', { keyPath: 'id' });
          salesStore.createIndex('timestamp', 'timestamp', { unique: false });
          console.log('[PWA] Created pendingSales store');
        }

        if (!db.objectStoreNames.contains('offlineCache')) {
          const cacheStore = db.createObjectStore('offlineCache', { keyPath: 'url' });
          cacheStore.createIndex('timestamp', 'timestamp', { unique: false });
          console.log('[PWA] Created offlineCache store');
        }

        if (!db.objectStoreNames.contains('syncQueue')) {
          const syncStore = db.createObjectStore('syncQueue', { keyPath: 'id' });
          syncStore.createIndex('status', 'status', { unique: false });
          console.log('[PWA] Created syncQueue store');
        }
      };
    });
  }

  /**
   * Handle online status change
   */
  handleOnline() {
    console.log('[PWA] Back online');
    this.isOnline = true;
    this.notifyOnlineStatus(true);
    this.syncPendingData();
  }

  /**
   * Handle offline status change
   */
  handleOffline() {
    console.log('[PWA] Going offline');
    this.isOnline = false;
    this.notifyOnlineStatus(false);
  }

  /**
   * Notify about online/offline status
   */
  notifyOnlineStatus(isOnline) {
    const event = new CustomEvent('pwa-status-changed', {
      detail: { isOnline }
    });
    document.dispatchEvent(event);

    // Show toast notification
    this.showToast(
      isOnline ? '✓ Back online' : '⚠ You\'re offline',
      isOnline ? 'success' : 'warning'
    );
  }

  /**
   * Save sale for offline storage
   */
  async savePendingSale(saleData) {
    try {
      const db = this.offlineSalesDB;
      return new Promise((resolve, reject) => {
        const transaction = db.transaction(['pendingSales'], 'readwrite');
        const store = transaction.objectStore('pendingSales');
        const request = store.add({
          id: Date.now() + Math.random(),
          ...saleData,
          timestamp: new Date(),
          synced: false
        });

        request.onerror = () => reject(request.error);
        request.onsuccess = () => {
          console.log('[PWA] Sale saved to offline storage');
          resolve(request.result);
        };
      });
    } catch (error) {
      console.error('[PWA] Failed to save pending sale:', error);
      throw error;
    }
  }

  /**
   * Sync pending data when back online
   */
  async syncPendingData() {
    if (!this.isOnline) return;

    try {
      const db = this.offlineSalesDB;
      const pendingSales = await this.getPendingSales(db);

      if (pendingSales.length === 0) {
        console.log('[PWA] No pending data to sync');
        return;
      }

      console.log(`[PWA] Syncing ${pendingSales.length} pending sales`);

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
            await this.removePendingSale(db, sale.id);
            console.log('[PWA] Sale synced successfully');
          } else {
            console.warn('[PWA] Failed to sync sale:', response.status);
          }
        } catch (error) {
          console.error('[PWA] Error syncing sale:', error);
        }
      }

      this.showToast('✓ Data synced successfully', 'success');
    } catch (error) {
      console.error('[PWA] Sync failed:', error);
      this.showToast('⚠ Failed to sync offline data', 'error');
    }
  }

  /**
   * Get pending sales from database
   */
  getPendingSales(db) {
    return new Promise((resolve, reject) => {
      const transaction = db.transaction(['pendingSales'], 'readonly');
      const store = transaction.objectStore('pendingSales');
      const request = store.getAll();

      request.onerror = () => reject(request.error);
      request.onsuccess = () => resolve(request.result);
    });
  }

  /**
   * Remove synced sale from database
   */
  removePendingSale(db, id) {
    return new Promise((resolve, reject) => {
      const transaction = db.transaction(['pendingSales'], 'readwrite');
      const store = transaction.objectStore('pendingSales');
      const request = store.delete(id);

      request.onerror = () => reject(request.error);
      request.onsuccess = () => resolve();
    });
  }

  /**
   * Handle install prompt
   */
  handleInstallPrompt(e) {
    console.log('[PWA] Install prompt triggered');
    e.preventDefault();
    // Store the event for later use
    window.deferredPrompt = e;

    // Show install button
    this.showInstallButton();
  }

  /**
   * Show install button if app is installable
   */
  showInstallButton() {
    if (!document.getElementById('pwa-install-btn')) {
      const installBtn = document.createElement('button');
      installBtn.id = 'pwa-install-btn';
      installBtn.className = 'pwa-install-btn';
      installBtn.innerHTML = '⬇ Install App';
      installBtn.addEventListener('click', () => this.installApp());

      if (!document.getElementById('pwa-install-styles')) {
        const styles = document.createElement('style');
        styles.id = 'pwa-install-styles';
        styles.textContent = `
          .pwa-install-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
            z-index: 1000;
            transition: all 0.3s ease;
            font-size: 14px;
          }

          .pwa-install-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(76, 175, 80, 0.4);
          }

          @media (max-width: 768px) {
            .pwa-install-btn {
              bottom: 10px;
              right: 10px;
              padding: 10px 16px;
              font-size: 12px;
            }
          }
        `;
        document.head.appendChild(styles);
      }

      document.body.appendChild(installBtn);
    }
  }

  /**
   * Handle app installation
   */
  async installApp() {
    const promptEvent = window.deferredPrompt;
    if (!promptEvent) return;

    promptEvent.prompt();
    const { outcome } = await promptEvent.userChoice;
    console.log(`[PWA] User response to install prompt: ${outcome}`);

    window.deferredPrompt = null;
  }

  /**
   * Handle app installed event
   */
  handleAppInstalled() {
    console.log('[PWA] App installed successfully');
    window.deferredPrompt = null;
    const installBtn = document.getElementById('pwa-install-btn');
    if (installBtn) {
      installBtn.remove();
    }
    this.showToast('✓ App installed successfully', 'success');
  }

  /**
   * Handle share target
   */
  handleShareTarget() {
    console.log('[PWA] Share target received');
    // Handle shared data from other apps
  }

  /**
   * Show toast notification
   */
  showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `pwa-toast pwa-toast-${type}`;
    toast.textContent = message;

    if (!document.getElementById('pwa-toast-styles')) {
      const styles = document.createElement('style');
      styles.id = 'pwa-toast-styles';
      styles.textContent = `
        .pwa-toast {
          position: fixed;
          bottom: 20px;
          left: 20px;
          background: #333;
          color: white;
          padding: 12px 20px;
          border-radius: 4px;
          font-size: 13px;
          animation: slideUp 0.3s ease-out;
          z-index: 9000;
          max-width: 300px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .pwa-toast-success {
          background: #4caf50;
        }

        .pwa-toast-warning {
          background: #ff9800;
        }

        .pwa-toast-error {
          background: #f44336;
        }

        @keyframes slideUp {
          from {
            transform: translateY(100%);
            opacity: 0;
          }
          to {
            transform: translateY(0);
            opacity: 1;
          }
        }

        @media (max-width: 768px) {
          .pwa-toast {
            bottom: 10px;
            left: 10px;
            right: 10px;
            max-width: none;
          }
        }
      `;
      document.head.appendChild(styles);
    }

    document.body.appendChild(toast);

    setTimeout(() => {
      toast.remove();
    }, 3000);
  }

  /**
   * Request notification permission
   */
  async requestNotificationPermission() {
    if ('Notification' in window && Notification.permission === 'default') {
      const permission = await Notification.requestPermission();
      console.log(`[PWA] Notification permission: ${permission}`);
      return permission === 'granted';
    }
    return Notification.permission === 'granted';
  }

  /**
   * Send notification
   */
  sendNotification(title, options = {}) {
    if ('Notification' in window && Notification.permission === 'granted') {
      if (this.serviceWorkerRegistration) {
        this.serviceWorkerRegistration.showNotification(title, {
          icon: '/manifest.json',
          badge: 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96"><rect fill="%231a237e" width="96" height="96"/><text x="50%" y="50%" font-size="50" font-weight="bold" fill="%23ffd700" text-anchor="middle" dominant-baseline="central">P</text></svg>',
          ...options
        });
      }
    }
  }

  /**
   * Clear cache
   */
  async clearCache() {
    if ('caches' in window) {
      const cacheNames = await caches.keys();
      await Promise.all(
        cacheNames.map(name => caches.delete(name))
      );
      console.log('[PWA] Cache cleared');
      this.showToast('✓ Cache cleared', 'success');
    }
  }

  /**
   * Get storage usage
   */
  async getStorageUsage() {
    if ('storage' in navigator && 'estimate' in navigator.storage) {
      const estimate = await navigator.storage.estimate();
      return {
        usage: estimate.usage,
        quota: estimate.quota,
        percentage: (estimate.usage / estimate.quota) * 100
      };
    }
    return null;
  }

  /**
   * Request persistent storage
   */
  async requestPersistentStorage() {
    if ('storage' in navigator && 'persist' in navigator.storage) {
      const persistent = await navigator.storage.persist();
      console.log(`[PWA] Persistent storage: ${persistent}`);
      return persistent;
    }
    return false;
  }
}

// Auto-initialize PWA manager when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    window.PWA = new POSPWAManager();
  });
} else {
  window.PWA = new POSPWAManager();
}
