<style>
:root {
    --primary-color: #667eea;
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    
    --border-radius: 12px;
    --border-radius-lg: 20px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
    --shadow-md: 0 4px 12px rgba(0,0,0,0.15);
    --shadow-lg: 0 8px 25px rgba(0,0,0,0.2);
    --shadow-xl: 0 20px 40px rgba(0,0,0,0.25);
}

/* Global Styles */
* {
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f8fafc;
    overflow-x: hidden;
}

.antialiased {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Loading Spinner */
.loading-spinner {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(5px);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10000;
    transition: opacity 0.3s ease;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Header Styles */
.header-topbar {
    background: var(--dark-gradient);
    height: 30px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Navigation Styles */
.modern-navbar {
    background: var(--primary-gradient);
    backdrop-filter: blur(15px);
    border-bottom: 3px solid rgba(255, 255, 255, 0.2);
    box-shadow: var(--shadow-md);
    position: sticky;
    top: 0;
    z-index: 1000;
    animation: slideDown 0.6s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.logo-container {
    transition: transform 0.3s ease;
}

.logo-container:hover {
    transform: scale(1.05);
}

.logo-container img {
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
}

/* Navigation Links */
.nav-link {
    color: white !important;
    font-weight: 500;
    padding: 12px 20px !important;
    border-radius: var(--border-radius);
    margin: 0 5px;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    text-decoration: none;
}

.nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.nav-link:hover::before {
    left: 100%;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    transform: translateY(-2px);
    color: white !important;
    box-shadow: var(--shadow-md);
}

.nav-link.active {
    background: rgba(255, 255, 255, 0.3) !important;
    color: white !important;
    box-shadow: var(--shadow-lg);
}

.nav-link i {
    margin-right: 8px;
    width: 20px;
    text-align: center;
}

/* Dropdown Menu */
.dropdown-menu {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 15px;
    box-shadow: var(--shadow-xl);
    padding: 10px 0;
    margin-top: 10px;
    opacity: 0;
    transform: translateY(10px);
    transition: var(--transition);
}

.dropdown-menu.show {
    opacity: 1;
    transform: translateY(0);
}

.dropdown-item {
    color: #333 !important;
    padding: 12px 20px;
    margin: 2px 10px;
    border-radius: 8px;
    transition: var(--transition);
    font-weight: 500;
    text-decoration: none;
}

.dropdown-item:hover {
    background: var(--primary-gradient) !important;
    color: white !important;
    transform: translateX(5px);
}

.user-menu {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    padding: 8px 15px;
}

.user-menu:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Mobile Drawer */
.mobile-drawer {
    position: fixed;
    top: 0;
    left: -100%;
    width: 300px;
    height: 100vh;
    background: var(--primary-gradient);
    z-index: 9999;
    transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow-y: auto;
    overflow-x: hidden;
    box-shadow: 5px 0 20px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
}

.mobile-drawer.show {
    left: 0;
}

.mobile-drawer-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.6);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
    backdrop-filter: blur(2px);
}

.mobile-drawer-overlay.show {
    opacity: 1;
    visibility: visible;
}

.drawer-header {
    padding: 25px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    flex-shrink: 0;
    background: rgba(0, 0, 0, 0.1);
}

.drawer-header img {
    max-width: 160px;
    filter: brightness(0) invert(1);
}

.drawer-close {
    position: absolute;
    top: 20px;
    right: 20px;
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: var(--transition);
    z-index: 10000;
}

.drawer-close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.drawer-nav {
    flex: 1;
    overflow-y: auto;
    padding: 10px 0;
}

.drawer-nav .navbar-nav {
    padding: 0;
    margin: 0;
    list-style: none;
}

.drawer-nav .nav-item {
    margin: 0;
}

.drawer-nav .nav-link {
    color: white !important;
    padding: 18px 25px !important;
    margin: 0 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0 !important;
    display: flex;
    align-items: center;
    font-weight: 500;
    transition: var(--transition);
    text-decoration: none;
    font-size: 1rem;
}

.drawer-nav .nav-link:hover {
    background: rgba(255, 255, 255, 0.15) !important;
    transform: translateX(10px);
    box-shadow: none;
}

.drawer-nav .nav-link i {
    margin-right: 15px;
    width: 22px;
    text-align: center;
    flex-shrink: 0;
    font-size: 1.1rem;
}

.drawer-submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(0, 0, 0, 0.15);
    list-style: none;
    padding: 0;
    margin: 0;
}

.drawer-submenu.show {
    max-height: 500px;
}

.drawer-submenu .nav-link {
    padding: 15px 25px 15px 60px !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    font-size: 0.95rem;
    font-weight: 400;
}

.drawer-submenu .nav-link:hover {
    transform: translateX(8px);
    background: rgba(255, 255, 255, 0.2) !important;
}

.drawer-toggle {
    color: white;
    font-size: 0.9rem;
    margin-left: auto;
    transition: transform 0.3s ease;
    flex-shrink: 0;
}

.drawer-toggle.rotated {
    transform: rotate(180deg);
}

/* Main Content */
.main-content {
    min-height: calc(100vh - 200px);
    padding-top: 20px;
}

.page-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e3f2fd 100%);
    padding: 40px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
}

.breadcrumbs {
    background: #f8fafc;
    padding: 15px 0;
    border-bottom: 1px solid #e2e8f0;
}

.page-content {
    flex: 1;
}

/* Flash Messages */
.alert {
    border: none;
    border-radius: var(--border-radius);
    padding: 15px 20px;
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
}

.alert-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    color: #856404;
}

.alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    color: #0c5460;
}

/* Footer */
.footer {
    background: var(--dark-gradient);
    color: white;
    padding: 40px 0 20px;
    margin-top: auto;
}

.title-footer {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 8px;
    color: #e2e8f0;
}

.content-footer {
    font-size: 0.95rem;
    margin-bottom: 15px;
    color: #cbd5e0;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .nav-link {
        padding: 10px 15px !important;
        font-size: 0.9rem;
    }
}

@media (max-width: 992px) {
    .navbar-collapse {
        display: none !important;
    }
    
    .navbar-toggler {
        display: block !important;
        border: none;
        padding: 8px 12px;
    }
    
    .modern-navbar {
        padding: 10px 0;
    }
    
    .mobile-drawer {
        width: 280px;
    }
}

@media (max-width: 768px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .logo-container img {
        max-width: 140px !important;
    }
    
    .mobile-drawer {
        width: 260px;
    }
    
    .main-content {
        padding-top: 15px;
    }
    
    .page-header {
        padding: 30px 0;
    }
}

@media (max-width: 576px) {
    .container {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    .logo-container img {
        max-width: 120px !important;
    }
    
    .mobile-drawer {
        width: 240px;
    }
    
    .navbar-toggler {
        padding: 6px 10px;
        font-size: 0.9rem;
    }
    
    .main-content {
        padding-top: 10px;
    }
    
    .page-header {
        padding: 20px 0;
    }
}

@media (max-width: 480px) {
    .container-fluid {
        padding-left: 8px;
        padding-right: 8px;
    }
    
    .logo-container img {
        max-width: 100px !important;
    }
    
    .mobile-drawer {
        width: 220px;
    }
}

@media (max-width: 380px) {
    .container {
        padding-left: 5px;
        padding-right: 5px;
    }
    
    .logo-container img {
        max-width: 90px !important;
    }
    
    .mobile-drawer {
        width: 200px;
    }
}

/* Utility Classes */
.d-none {
    display: none !important;
}

.d-block {
    display: block !important;
}

.text-center {
    text-align: center !important;
}

.fw-bold {
    font-weight: 700 !important;
}

.fw-semibold {
    font-weight: 600 !important;
}

/* Prevent body scroll when drawer is open */
body.drawer-open {
    overflow: hidden !important;
    position: fixed;
    width: 100%;
}

/* Custom Scrollbar */
.drawer-nav::-webkit-scrollbar {
    width: 6px;
}

.drawer-nav::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.drawer-nav::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

.drawer-nav::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* Modern Tables */
.modern-table-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
    border: 1px solid rgba(255, 255, 255, 0.18);
    margin-bottom: 2rem;
}

.modern-table {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
    background: white;
    width: 100%;
}

.modern-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.modern-table thead th {
    border: none;
    padding: 1.25rem 1rem;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    position: relative;
    text-align: left;
}

.modern-table tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.modern-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
}

.modern-table tbody td {
    border: none;
    padding: 1rem;
    vertical-align: middle;
    font-weight: 500;
}

.modern-table tbody tr:last-child {
    border-bottom: none;
}

/* Modern Action Buttons */
.modern-btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    border: none;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0 0.25rem;
    cursor: pointer;
    opacity: 1 !important;
    visibility: visible !important;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    text-decoration: none;
    opacity: 1 !important;
}

button[type="submit"].modern-btn,
button[type="submit"].modern-btn-primary,
.modern-btn-primary[type="submit"] {
    opacity: 1 !important;
    visibility: visible !important;
    background: linear-gradient(45deg, var(--primary-color), #667eea) !important;
    color: white !important;
    border: none !important;
}

.modern-btn-primary {
    background: linear-gradient(45deg, var(--primary-color), #667eea);
    color: white;
}

.modern-btn-secondary {
    background: linear-gradient(45deg, #6c757d, #5a6268);
    color: white;
}

.modern-btn-warning {
    background: linear-gradient(45deg, #ffc107, #ffaa00);
    color: #212529;
}

.modern-btn-danger {
    background: linear-gradient(45deg, #dc3545, #c82333);
    color: white;
}

.modern-btn-success {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
}

.modern-btn-info {
    background: linear-gradient(45deg, #17a2b8, #138496);
    color: white;
}

/* Page Header */
.page-header-modern {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.page-header-modern h2 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
    margin: 0;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h4 {
    margin-bottom: 0.5rem;
    color: #495057;
}

/* Status Badges */
.status-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.active {
    background: rgba(40, 167, 69, 0.15);
    color: #28a745;
}

.status-badge.inactive {
    background: rgba(220, 53, 69, 0.15);
    color: #dc3545;
}

.status-badge.pending {
    background: rgba(255, 193, 7, 0.15);
    color: #ffc107;
}

/* Search and Filters */
.modern-search-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(31, 38, 135, 0.15);
}

.modern-search-input {
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
}

.modern-search-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: white;
}

/* Responsive Tables */
@media (max-width: 768px) {
    .modern-table-container {
        padding: 1rem;
        border-radius: 15px;
        margin-bottom: 1rem;
    }
    
    .modern-table thead {
        display: none;
    }
    
    .modern-table,
    .modern-table tbody,
    .modern-table tr,
    .modern-table td {
        display: block;
    }
    
    .modern-table tr {
        background: white;
        border-radius: 10px;
        margin-bottom: 1rem;
        padding: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .modern-table td {
        border: none;
        padding: 0.5rem 0;
        position: relative;
        padding-left: 50%;
        text-align: right;
    }
    
    .modern-table td::before {
        content: attr(data-label) ":";
        position: absolute;
        left: 0;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        font-weight: 600;
        color: #667eea;
        text-align: left;
    }
    
    .modern-btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        margin: 0.1rem;
    }
}

/* Animation Classes */
.fade-in-up {
    animation: fadeInUp 0.6s ease forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Modern Form Styles */
.modern-form-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.modern-form-group {
    margin-bottom: 1.5rem;
}

.modern-form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.95rem;
}

.modern-form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.9);
}

.modern-form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: #ffffff;
}

.modern-form-control:hover {
    border-color: #cbd5e1;
}

.modern-form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.form-error {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

/* Form responsive */
@media (max-width: 768px) {
    .modern-form-container {
        padding: 1.5rem;
    }
    
    .modern-form-actions {
        flex-direction: column;
    }
    
    .modern-form-actions .modern-btn {
        width: 100%;
        justify-content: center;
    }
}

.modern-btn-secondary {
    background: linear-gradient(45deg, #6c757d, #5a6268);
    color: white;
}

/* Pagination styles */
.modern-pagination {
    margin-top: 2rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(31, 38, 135, 0.15);
}

.modern-pagination .pagination {
    margin: 0;
    justify-content: center;
}

.modern-pagination .page-link {
    border: none;
    padding: 0.75rem 1rem;
    margin: 0 0.125rem;
    border-radius: 8px;
    color: var(--primary-color);
    background: rgba(102, 126, 234, 0.1);
    transition: all 0.3s ease;
}

.modern-pagination .page-link:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.modern-pagination .page-item.active .page-link {
    background: var(--primary-color);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* Bootstrap Override for Modern Buttons */
form button.modern-btn,
form button.modern-btn-primary,
form input.modern-btn,
form input.modern-btn-primary,
.form-actions button.modern-btn,
.form-actions button.modern-btn-primary,
.modern-form-actions button.modern-btn,
.modern-form-actions button.modern-btn-primary {
    opacity: 1 !important;
    visibility: visible !important;
    background: linear-gradient(45deg, var(--primary-color), #667eea) !important;
    background-color: var(--primary-color) !important;
    color: white !important;
    border: none !important;
    border-color: transparent !important;
    outline: none !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    padding: 0.5rem 1rem !important;
    border-radius: 8px !important;
    font-weight: 500 !important;
    font-size: 0.875rem !important;
    line-height: 1.5 !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
}

form button.modern-btn:hover,
form button.modern-btn-primary:hover,
.form-actions button.modern-btn:hover,
.form-actions button.modern-btn-primary:hover,
.modern-form-actions button.modern-btn:hover,
.modern-form-actions button.modern-btn-primary:hover {
    opacity: 1 !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    background: linear-gradient(45deg, var(--primary-color), #667eea) !important;
    color: white !important;
    text-decoration: none !important;
}

/* Ensure button text is visible */
form button.modern-btn i,
form button.modern-btn-primary i,
.form-actions button.modern-btn i,
.form-actions button.modern-btn-primary i,
.modern-form-actions button.modern-btn i,
.modern-form-actions button.modern-btn-primary i {
    color: white !important;
    opacity: 1 !important;
}
</style>
