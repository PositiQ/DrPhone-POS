<?php
$activePage = 'sales';
$basePath = '../';
$pageTitle = 'Sales';
$pageSubtitle = 'View sales insights and add new sales.';
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth($activePage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a237e">
    <meta name="description" content="View sales insights and add new sales">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PositiQ POS">
    <title>PositiQ POS System · Sales</title>
    <!-- PWA Manifest and Icons -->
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192' rx='40'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../styles/dashboard.css">
</head>
<body>
    <!-- PWA Client Library -->
    <script src="/pwa-client.js"></script>
    <div class="dashboard-container">
        <?php include __DIR__ . '/../../UI/sidebar.php'; ?>

        <div class="main-content">
            <?php include __DIR__ . '/../../UI/top-navigation.php'; ?>

            <div class="content-area">
                <div class="toolbar">
                    <div class="filter-group">
                        <button class="pill active" type="button" data-range="today">Today</button>
                        <button class="pill" type="button" data-range="week">This Week</button>
                        <button class="pill" type="button" data-range="month">This Month</button>
                        <button class="pill" type="button" data-range="custom">Custom</button>
                        <select aria-label="View type" id="viewType">
                            <option>View by Day</option>
                            <option>View by Date Range</option>
                            <option>View by Month</option>
                            <option>View by Year</option>
                        </select>
                        <input type="date" id="startDate" aria-label="Start date">
                        <input type="date" id="endDate" aria-label="End date">
                        <select aria-label="Month" id="monthSelect">
                            <option>February</option>
                            <option>January</option>
                            <option>March</option>
                            <option>April</option>
                        </select>
                        <select aria-label="Year" id="yearSelect">
                            <option>2026</option>
                            <option>2025</option>
                            <option>2024</option>
                        </select>
                        <select id="statusFilter" aria-label="Status filter">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <select id="paymentFilter" aria-label="Payment filter">
                            <option value="">All Payments</option>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="mobile">Mobile</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="toolbar-actions">
                        <a class="button-primary" href="create.php">
                            <i class="fas fa-plus" style="margin-right: 6px;"></i>
                            Create New Sale
                        </a>
                        <button class="button-secondary" type="button">Export</button>
                    </div>
                </div>

                <div class="insight-grid">
                    <div class="metric-card">
                        <h4>Daily Sales Amount</h4>
                        <div class="metric-value" id="dailySalesAmount">LKR 0.00</div>
                        <div class="metric-sub" id="dailySalesSub">0 transactions today</div>
                    </div>
                    <div class="metric-card">
                        <h4>Actual Sales (Cash + Card)</h4>
                        <div class="metric-value" id="actualSalesAmount">LKR 0.00</div>
                        <div class="metric-sub" id="actualSalesSub">0% of daily total</div>
                    </div>
                    <div class="metric-card">
                        <h4>Credit Sales Amount</h4>
                        <div class="metric-value" id="creditSalesAmount">LKR 0.00</div>
                        <div class="metric-sub">Pending collection</div>
                    </div>
                    <div class="metric-card">
                        <h4>Daily Balance After Credit</h4>
                        <div class="metric-value" id="dailyBalanceAmount">LKR 0.00</div>
                        <div class="metric-sub">Actual cash received</div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Weekly & Monthly Insights</h3>
                    </div>
                    <div class="insight-grid">
                        <div class="metric-card">
                            <h4>This Week</h4>
                            <div class="metric-value" id="weekSalesAmount">LKR 0.00</div>
                            <div class="metric-sub" id="weekSalesSub">Average LKR 0.00 per day</div>
                        </div>
                        <div class="metric-card">
                            <h4>This Month</h4>
                            <div class="metric-value" id="monthSalesAmount">LKR 0.00</div>
                            <div class="metric-sub" id="monthSalesSub">Live monthly total</div>
                        </div>
                        <div class="metric-card">
                            <h4>Credit Collected (Month)</h4>
                            <div class="metric-value" id="creditCollectedAmount">LKR 0.00</div>
                            <div class="metric-sub">Collections to date</div>
                        </div>
                        <div class="metric-card">
                            <h4>Outstanding Credit</h4>
                            <div class="metric-value" id="outstandingCreditAmount">LKR 0.00</div>
                            <div class="metric-sub">Requires follow-up</div>
                        </div>
                    </div>
                </div>

                <div class="recent-orders">
                    <div class="section-header">
                        <h3>Sales by Day</h3>
                        <span class="view-all">View All →</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Sales Amount (LKR)</th>
                                <th>Transactions</th>
                                <th>Actual Sales</th>
                                <th>Credit Sales</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody id="salesByDayBody">
                            <tr>
                                <td colspan="6" style="text-align: center; color: #7a86ad;">Loading sales...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="search-overlay" id="searchOverlay" role="dialog" aria-modal="true" aria-label="Global search">
        <div class="search-dialog" role="document">
            <div class="search-dialog-header">
                <i class="fas fa-search"></i>
                <button class="search-close" type="button" id="searchClose" aria-label="Close search">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <input type="text" id="globalSearchModal" placeholder="Type to search..." autocomplete="off">
            <p class="search-hint">Press Esc to close</p>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');

            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        const searchOverlay = document.getElementById('searchOverlay');
        const searchModalInput = document.getElementById('globalSearchModal');
        const searchTrigger = document.getElementById('searchTrigger');
        const searchClose = document.getElementById('searchClose');

        const API_BASE_URL = 'http://localhost:3000/api';
        const SALES_API = `${API_BASE_URL}/sales`;
        const SALES_SUMMARY_API = `${SALES_API}/summary`;

        const rangeButtons = document.querySelectorAll('.pill[data-range]');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        const statusFilter = document.getElementById('statusFilter');
        const paymentFilter = document.getElementById('paymentFilter');
        const monthSelect = document.getElementById('monthSelect');
        const yearSelect = document.getElementById('yearSelect');
        const salesByDayBody = document.getElementById('salesByDayBody');

        const dailySalesAmount = document.getElementById('dailySalesAmount');
        const dailySalesSub = document.getElementById('dailySalesSub');
        const actualSalesAmount = document.getElementById('actualSalesAmount');
        const actualSalesSub = document.getElementById('actualSalesSub');
        const creditSalesAmount = document.getElementById('creditSalesAmount');
        const dailyBalanceAmount = document.getElementById('dailyBalanceAmount');
        const weekSalesAmount = document.getElementById('weekSalesAmount');
        const weekSalesSub = document.getElementById('weekSalesSub');
        const monthSalesAmount = document.getElementById('monthSalesAmount');
        const monthSalesSub = document.getElementById('monthSalesSub');
        const creditCollectedAmount = document.getElementById('creditCollectedAmount');
        const outstandingCreditAmount = document.getElementById('outstandingCreditAmount');

        let activeRange = 'today';

        function openSearchModal() {
            if (!searchOverlay || !searchModalInput) {
                return;
            }

            searchOverlay.classList.add('active');
            searchModalInput.focus();
            searchModalInput.select();
        }

        function closeSearchModal() {
            if (!searchOverlay) {
                return;
            }

            searchOverlay.classList.remove('active');
        }

        if (searchTrigger) {
            searchTrigger.addEventListener('click', openSearchModal);
            searchTrigger.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    openSearchModal();
                }
            });
        }

        if (searchClose) {
            searchClose.addEventListener('click', closeSearchModal);
        }

        if (searchOverlay) {
            searchOverlay.addEventListener('click', function(event) {
                if (event.target === searchOverlay) {
                    closeSearchModal();
                }
            });
        }

        document.addEventListener('keydown', function(event) {
            if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                event.preventDefault();
                openSearchModal();
            }

            if (event.key === 'Escape' && searchOverlay && searchOverlay.classList.contains('active')) {
                closeSearchModal();
            }
        });

        function formatLkr(amount) {
            const value = Number(amount || 0);
            return `LKR ${value.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            })}`;
        }

        function toDateOnly(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function parseSaleDate(saleDate) {
            return new Date(saleDate);
        }

        function classifySaleAmount(sale) {
            const total = Number(sale.total_amount || 0);
            const normalizedStatus = String(sale.status || '').toLowerCase();
            const normalizedMethod = String(sale.payment_method || '').toLowerCase();

            if (['completed', 'sold'].includes(normalizedStatus)) {
                return { total, actual: total, credit: 0 };
            }

            if (['pending', 'pending_payment'].includes(normalizedStatus)) {
                return { total, actual: 0, credit: total };
            }

            // Backward compatibility for legacy rows without normalized status values.
            if (['cash', 'card'].includes(normalizedMethod)) {
                return { total, actual: total, credit: 0 };
            }

            return { total, actual: 0, credit: total };
        }

        function setActiveRange(range) {
            activeRange = range;
            rangeButtons.forEach(button => {
                button.classList.toggle('active', button.getAttribute('data-range') === range);
            });
        }

        function getDateRange() {
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

            if (activeRange === 'today') {
                const date = toDateOnly(today);
                return { start: date, end: date };
            }

            if (activeRange === 'week') {
                const start = new Date(today);
                start.setDate(today.getDate() - 6);
                return { start: toDateOnly(start), end: toDateOnly(today) };
            }

            if (activeRange === 'month') {
                const start = new Date(now.getFullYear(), now.getMonth(), 1);
                const end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                return { start: toDateOnly(start), end: toDateOnly(end) };
            }

            if (startDateInput.value || endDateInput.value) {
                return {
                    start: startDateInput.value || undefined,
                    end: endDateInput.value || undefined,
                };
            }

            return {};
        }

        function renderSalesByDay(sales) {
            if (!sales || sales.length === 0) {
                salesByDayBody.innerHTML = '<tr><td colspan="6" style="text-align: center; color: #7a86ad;">No sales found for selected filters.</td></tr>';
                return;
            }

            const groupedByDay = new Map();

            sales.forEach(sale => {
                const dateKey = toDateOnly(parseSaleDate(sale.sales_date));
                const classified = classifySaleAmount(sale);

                if (!groupedByDay.has(dateKey)) {
                    groupedByDay.set(dateKey, {
                        date: dateKey,
                        total: 0,
                        actual: 0,
                        credit: 0,
                        transactions: 0,
                    });
                }

                const day = groupedByDay.get(dateKey);
                day.total += classified.total;
                day.actual += classified.actual;
                day.credit += classified.credit;
                day.transactions += 1;
            });

            const rows = Array.from(groupedByDay.values()).sort((a, b) => b.date.localeCompare(a.date)).slice(0, 20);

            salesByDayBody.innerHTML = rows.map(day => {
                return `
                    <tr>
                        <td>${day.date}</td>
                        <td>${formatLkr(day.total)}</td>
                        <td>${day.transactions}</td>
                        <td>${formatLkr(day.actual)}</td>
                        <td>${formatLkr(day.credit)}</td>
                        <td>${formatLkr(day.actual)}</td>
                    </tr>
                `;
            }).join('');
        }

        function updateMetricCards(sales, summary) {
            const todayKey = toDateOnly(new Date());
            const now = new Date();

            const todaySales = sales.filter(sale => toDateOnly(parseSaleDate(sale.sales_date)) === todayKey);
            const todayClassified = todaySales.map(classifySaleAmount);
            const todayTotal = todayClassified.reduce((sum, sale) => sum + sale.total, 0);
            const todayActual = todayClassified.reduce((sum, sale) => sum + sale.actual, 0);
            const todayCredit = todayClassified.reduce((sum, sale) => sum + sale.credit, 0);

            dailySalesAmount.textContent = formatLkr(todayTotal);
            dailySalesSub.textContent = `${todaySales.length} transactions today`;
            actualSalesAmount.textContent = formatLkr(todayActual);
            actualSalesSub.textContent = `${todayTotal > 0 ? ((todayActual / todayTotal) * 100).toFixed(1) : '0.0'}% of daily total`;
            creditSalesAmount.textContent = formatLkr(todayCredit);
            dailyBalanceAmount.textContent = formatLkr(todayActual);

            const weekStart = new Date(now.getFullYear(), now.getMonth(), now.getDate() - 6);
            const weekSales = sales.filter(sale => parseSaleDate(sale.sales_date) >= weekStart);
            const weekTotal = weekSales.reduce((sum, sale) => sum + Number(sale.total_amount || 0), 0);
            const weekAverage = weekTotal / 7;
            weekSalesAmount.textContent = formatLkr(weekTotal);
            weekSalesSub.textContent = `Average ${formatLkr(weekAverage)} per day`;

            const monthSales = sales.filter(sale => {
                const date = parseSaleDate(sale.sales_date);
                return date.getMonth() === now.getMonth() && date.getFullYear() === now.getFullYear();
            });

            const monthClassified = monthSales.map(classifySaleAmount);
            const monthTotal = monthClassified.reduce((sum, sale) => sum + sale.total, 0);
            const monthActual = monthClassified.reduce((sum, sale) => sum + sale.actual, 0);
            const monthCredit = monthClassified.reduce((sum, sale) => sum + sale.credit, 0);

            monthSalesAmount.textContent = formatLkr(monthTotal);
            monthSalesSub.textContent = `Selected range revenue: ${formatLkr(summary.totalRevenue || 0)}`;
            creditCollectedAmount.textContent = formatLkr(monthActual);
            outstandingCreditAmount.textContent = formatLkr(monthCredit);
        }

        function buildQueryParams() {
            const params = new URLSearchParams();
            params.set('page', '1');
            params.set('limit', '200');

            const dateRange = getDateRange();
            if (dateRange.start) {
                params.set('start_date', dateRange.start);
            }
            if (dateRange.end) {
                params.set('end_date', dateRange.end);
            }
            if (statusFilter.value) {
                params.set('status', statusFilter.value);
            }
            if (paymentFilter.value) {
                params.set('payment_method', paymentFilter.value);
            }

            return params;
        }

        async function loadSalesDashboard() {
            try {
                const params = buildQueryParams();
                const [salesResponse, summaryResponse] = await Promise.all([
                    fetch(`${SALES_API}?${params.toString()}`),
                    fetch(`${SALES_SUMMARY_API}?${params.toString()}`),
                ]);

                const salesResult = await salesResponse.json();
                const summaryResult = await summaryResponse.json();

                if (!salesResponse.ok) {
                    throw new Error(salesResult.error || salesResult.message || 'Failed to load sales list');
                }

                if (!summaryResponse.ok) {
                    throw new Error(summaryResult.error || summaryResult.message || 'Failed to load sales summary');
                }

                const salesRecords = salesResult.sales || [];
                const summary = summaryResult.summary || {};

                renderSalesByDay(salesRecords);
                updateMetricCards(salesRecords, summary);
            } catch (error) {
                salesByDayBody.innerHTML = `<tr><td colspan="6" style="text-align: center; color: #d32f2f;">${error.message}</td></tr>`;
            }
        }

        rangeButtons.forEach(button => {
            button.addEventListener('click', function() {
                setActiveRange(button.getAttribute('data-range'));
                loadSalesDashboard();
            });
        });

        [startDateInput, endDateInput, statusFilter, paymentFilter].forEach(element => {
            element.addEventListener('change', function() {
                setActiveRange('custom');
                loadSalesDashboard();
            });
        });

        if (monthSelect && yearSelect) {
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const now = new Date();
            monthSelect.innerHTML = monthNames.map(name => `<option value="${name}">${name}</option>`).join('');
            yearSelect.innerHTML = [now.getFullYear(), now.getFullYear() - 1, now.getFullYear() - 2]
                .map(year => `<option value="${year}">${year}</option>`)
                .join('');
            monthSelect.value = monthNames[now.getMonth()];
            yearSelect.value = String(now.getFullYear());

            const setCustomRangeFromMonth = function() {
                const selectedMonth = monthNames.indexOf(monthSelect.value);
                const selectedYear = Number(yearSelect.value);
                if (selectedMonth < 0 || Number.isNaN(selectedYear)) {
                    return;
                }

                const start = new Date(selectedYear, selectedMonth, 1);
                const end = new Date(selectedYear, selectedMonth + 1, 0);
                startDateInput.value = toDateOnly(start);
                endDateInput.value = toDateOnly(end);
                setActiveRange('custom');
                loadSalesDashboard();
            };

            monthSelect.addEventListener('change', setCustomRangeFromMonth);
            yearSelect.addEventListener('change', setCustomRangeFromMonth);
        }

        const today = toDateOnly(new Date());
        startDateInput.value = today;
        endDateInput.value = today;
        loadSalesDashboard();
    </script>
</body>
</html>
