/**
 * PWA Offline Sales Manager
 * Handles sales transactions when offline and syncs when online
 */

class OfflineSalesManager {
  constructor() {
    this.db = null;
    this.init();
  }

  async init() {
    if (!window.PWA) {
      console.warn('[OfflineSalesManager] PWA manager not initialized');
      return;
    }
    this.db = window.PWA.offlineSalesDB;
    console.log('[OfflineSalesManager] Initialized');
  }

  /**
   * Create a new sale (works offline)
   */
  async createSale(saleData) {
    try {
      if (navigator.onLine) {
        // Online - submit to API directly
        return await this.submitSaleToAPI(saleData);
      } else {
        // Offline - save locally
        return await this.saveSaleOffline(saleData);
      }
    } catch (error) {
      console.error('[OfflineSalesManager] Sale creation failed:', error);
      // Fallback to offline storage
      return await this.saveSaleOffline(saleData);
    }
  }

  /**
   * Submit sale to API
   */
  async submitSaleToAPI(saleData) {
    const response = await fetch('/api/sales', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(saleData)
    });

    if (!response.ok) {
      throw new Error(`API error: ${response.status}`);
    }

    return await response.json();
  }

  /**
   * Save sale for offline storage
   */
  async saveSaleOffline(saleData) {
    const offlineSale = {
      id: `offline_${Date.now()}`,
      ...saleData,
      timestamp: new Date(),
      synced: false,
      offline: true
    };

    await window.PWA.savePendingSale(offlineSale);
    
    window.PWA.showToast('Sale saved offline. Will sync when online.', 'warning');
    
    return offlineSale;
  }

  /**
   * Get all pending (unsynced) sales
   */
  async getPendingSales() {
    try {
      return await window.PWA.getPendingSales(this.db);
    } catch (error) {
      console.error('[OfflineSalesManager] Failed to get pending sales:', error);
      return [];
    }
  }

  /**
   * Sync all pending sales
   */
  async syncAll() {
    const pending = await this.getPendingSales();
    
    if (pending.length === 0) {
      console.log('[OfflineSalesManager] No sales to sync');
      return { synced: 0, failed: 0 };
    }

    let synced = 0;
    let failed = 0;

    for (const sale of pending) {
      try {
        const response = await this.submitSaleToAPI(sale);
        await window.PWA.removePendingSale(this.db, sale.id);
        synced++;
      } catch (error) {
        console.error('[OfflineSalesManager] Failed to sync sale:', error);
        failed++;
      }
    }

    const message = `Synced ${synced} sales${failed > 0 ? `, ${failed} failed` : ''}`;
    window.PWA.showToast(message, failed > 0 ? 'warning' : 'success');

    return { synced, failed };
  }
}

// Initialize when PWA is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    window.OfflineSalesManager = new OfflineSalesManager();
  });
} else {
  window.OfflineSalesManager = new OfflineSalesManager();
}
