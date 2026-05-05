/**
 * FixIt Smart Complaint Management System
 * JavaScript Validation & Utility Functions
 */

// ============================================
// Form Validation
// ============================================

class FormValidator {
    /**
     * Validate email format
     */
    static validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    /**
     * Validate password strength
     */
    static validatePassword(password) {
        return password.length >= 8;
    }

    /**
     * Validate required field
     */
    static validateRequired(value) {
        return value.trim().length > 0;
    }

    /**
     * Validate phone number
     */
    static validatePhone(phone) {
        const re = /^[0-9]{10}$/;
        return re.test(phone.replace(/\D/g, ''));
    }

    /**
     * Display error message
     */
    static showError(input, message) {
        input.classList.add('error-input');
        const errorElement = input.parentElement.querySelector('.error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    }

    /**
     * Clear error message
     */
    static clearError(input) {
        input.classList.remove('error-input');
        const errorElement = input.parentElement.querySelector('.error');
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    }

    /**
     * Validate registration form
     */
    static validateRegistration(formData) {
        const errors = {};

        if (!this.validateRequired(formData.name)) {
            errors.name = 'Name is required';
        }

        if (!this.validateEmail(formData.email)) {
            errors.email = 'Please enter a valid email';
        }

        if (!this.validatePassword(formData.password)) {
            errors.password = 'Password must be at least 8 characters';
        }

        if (formData.password !== formData.confirmPassword) {
            errors.confirmPassword = 'Passwords do not match';
        }

        return errors;
    }

    /**
     * Validate login form
     */
    static validateLogin(formData) {
        const errors = {};

        if (!this.validateEmail(formData.email)) {
            errors.email = 'Please enter a valid email';
        }

        if (!this.validateRequired(formData.password)) {
            errors.password = 'Password is required';
        }

        return errors;
    }

    /**
     * Validate complaint form
     */
    static validateComplaint(formData) {
        const errors = {};

        if (!this.validateRequired(formData.category)) {
            errors.category = 'Please select a category';
        }

        if (!this.validateRequired(formData.title)) {
            errors.title = 'Title is required';
        }

        if (formData.title.length < 10) {
            errors.title = 'Title must be at least 10 characters';
        }

        if (!this.validateRequired(formData.description)) {
            errors.description = 'Description is required';
        }

        if (formData.description.length < 20) {
            errors.description = 'Description must be at least 20 characters';
        }

        if (!this.validateRequired(formData.priority)) {
            errors.priority = 'Please select priority level';
        }

        return errors;
    }

    /**
     * Validate contact form
     */
    static validateContact(formData) {
        const errors = {};

        if (!this.validateRequired(formData.name)) {
            errors.name = 'Name is required';
        }

        if (!this.validateEmail(formData.email)) {
            errors.email = 'Please enter a valid email';
        }

        if (!this.validateRequired(formData.message)) {
            errors.message = 'Message is required';
        }

        if (formData.message.length < 10) {
            errors.message = 'Message must be at least 10 characters';
        }

        return errors;
    }
}

// ============================================
// Utility Functions
// ============================================

/**
 * Show notification
 */
function showNotification(message, type = 'success', duration = 3000) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        animation: slideInLeft 0.3s ease-out;
        font-weight: 500;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideInDown 0.3s ease-out reverse';
        setTimeout(() => notification.remove(), 300);
    }, duration);
}

/**
 * Format date
 */
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

/**
 * Format date only
 */
function formatDateOnly(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

/**
 * Format relative time
 */
function formatRelativeTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);

    const intervals = {
        year: 31536000,
        month: 2592000,
        week: 604800,
        day: 86400,
        hour: 3600,
        minute: 60
    };

    for (const [key, value] of Object.entries(intervals)) {
        const interval = Math.floor(seconds / value);
        if (interval >= 1) {
            return interval === 1 ? `1 ${key} ago` : `${interval} ${key}s ago`;
        }
    }

    return 'Just now';
}

/**
 * Truncate text
 */
function truncateText(text, maxLength) {
    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}

/**
 * Get status badge HTML
 */
function getStatusBadge(status) {
    const badges = {
        'Pending': '<span class="badge badge-pending">● Pending</span>',
        'In Progress': '<span class="badge badge-in-progress">● In Progress</span>',
        'Resolved': '<span class="badge badge-resolved">✓ Resolved</span>'
    };
    return badges[status] || badges['Pending'];
}

/**
 * Get priority badge HTML
 */
function getPriorityBadge(priority) {
    return `<span class="priority priority-${priority.toLowerCase()}">
        <span class="priority-indicator"></span>
        ${priority}
    </span>`;
}

/**
 * Clear form
 */
function clearForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
        form.querySelectorAll('.error').forEach(el => {
            el.style.display = 'none';
        });
        form.querySelectorAll('input, textarea').forEach(el => {
            el.classList.remove('error-input');
        });
    }
}

/**
 * Disable form while submitting
 */
function disableForm(formId, disabled = true) {
    const form = document.getElementById(formId);
    if (form) {
        form.querySelectorAll('input, textarea, select, button').forEach(el => {
            el.disabled = disabled;
        });
    }
}

/**
 * Get form data as object
 */
function getFormData(formId) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });
    return data;
}

/**
 * Search/filter complaints
 */
function filterComplaints() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const complaintItems = document.querySelectorAll('.complaint-item');

    complaintItems.forEach(item => {
        const title = item.querySelector('.complaint-title').textContent.toLowerCase();
        const description = item.querySelector('.complaint-description').textContent.toLowerCase();
        const status = item.dataset.status;
        const category = item.dataset.category;

        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const selectedStatus = statusFilter ? statusFilter.value : '';
        const selectedCategory = categoryFilter ? categoryFilter.value : '';

        const matchesSearch = !searchTerm || title.includes(searchTerm) || description.includes(searchTerm);
        const matchesStatus = !selectedStatus || status === selectedStatus;
        const matchesCategory = !selectedCategory || category === selectedCategory;

        if (matchesSearch && matchesStatus && matchesCategory) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

/**
 * Setup real-time search
 */
function setupSearch() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');

    if (searchInput) {
        searchInput.addEventListener('input', filterComplaints);
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', filterComplaints);
    }
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterComplaints);
    }
}

/**
 * Export table to CSV
 */
function exportTableToCSV(filename = 'export.csv') {
    const table = document.querySelector('table');
    if (!table) return;

    let csv = [];
    const rows = table.querySelectorAll('tr');

    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const csvRow = [];
        cols.forEach(col => {
            csvRow.push(col.textContent);
        });
        csv.push(csvRow.join(','));
    });

    downloadCSV(csv.join('\n'), filename);
}

/**
 * Download CSV file
 */
function downloadCSV(csv, filename) {
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    link.click();
    window.URL.revokeObjectURL(url);
}

/**
 * Confirm action
 */
function confirmAction(message) {
    return confirm(message);
}

/**
 * Toggle sidebar on mobile
 */
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.classList.toggle('active');
    }
}

/**
 * Close mobile menu on link click
 */
function closeMobileMenu() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar && window.innerWidth < 768) {
        sidebar.classList.remove('active');
    }
}

/**
 * Format number
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

/**
 * Initialize tooltips
 */
function initializeTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(el => {
        el.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.dataset.tooltip;
            tooltip.style.cssText = `
                position: absolute;
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 0.5rem 0.75rem;
                border-radius: 0.375rem;
                font-size: 0.85rem;
                white-space: nowrap;
                z-index: 10000;
            `;
            document.body.appendChild(tooltip);

            const rect = this.getBoundingClientRect();
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';
            tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';

            this.addEventListener('mouseleave', () => tooltip.remove());
        });
    });
}

/**
 * Debounce function for search
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Initialize on DOM ready
 */
document.addEventListener('DOMContentLoaded', function() {
    setupSearch();
    initializeTooltips();
});

// Handle form submission with AJAX (optional enhancement)
function submitFormAjax(formId, endpoint) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.textContent;

        button.disabled = true;
        button.innerHTML = '<span class="loading"></span>';

        fetch(endpoint, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                clearForm(formId);
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                }, 1500);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.textContent = originalText;
        });
    });
}

// CSS for error input styling
const style = document.createElement('style');
style.textContent = `
    .error-input {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
    }
`;
document.head.appendChild(style);
