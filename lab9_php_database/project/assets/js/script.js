/**
 * Modular PHP App - JavaScript Functions
 * Universitas Pelita Bangsa
 */

document.addEventListener('DOMContentLoaded', function() {
    initSidebar();
    initForms();
    initNotifications();
    initDataTables();
    initModals();
});

function initSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const navItems = document.querySelectorAll('.nav-item');
    
    if (sidebar) {
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

        const mobileToggle = document.querySelector('.mobile-toggle');
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }
    }
}

function initForms() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '⏳ Processing...';
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
            });
        }

        const inputs = form.querySelectorAll('input[required], textarea[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.getAttribute('name');
    let isValid = true;
    let errorMessage = '';

    clearFieldError(field);

    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = `${getFieldLabel(fieldName)} is required`;
    }

    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid email address';
        }
    }

    if (fieldName === 'telepon' && value) {
        const phoneRegex = /^[\d\s\-\+\(\)]+$/;
        if (!phoneRegex.test(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid phone number';
        }
    }

    if (!isValid) {
        showFieldError(field, errorMessage);
    }

    return isValid;
}

function getFieldLabel(fieldName) {
    const labels = {
        'nama': 'Full name',
        'email': 'Email',
        'username': 'Username',
        'password': 'Password',
        'alamat': 'Address',
        'telepon': 'Phone number'
    };
    return labels[fieldName] || 'This field';
}

function showFieldError(field, message) {
    field.classList.add('error');
    
    let errorElement = field.parentNode.querySelector('.field-error');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'field-error';
        field.parentNode.appendChild(errorElement);
    }
    errorElement.textContent = message;
}

function clearFieldError(field) {
    field.classList.remove('error');
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
}

function initNotifications() {
    const successMessages = document.querySelectorAll('.alert-success');
    successMessages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 300);
        }, 5000);
    });

    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        if (!alert.querySelector('.close-btn')) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'close-btn';
            closeBtn.innerHTML = '×';
            closeBtn.addEventListener('click', () => alert.remove());
            alert.appendChild(closeBtn);
        }
    });
}

function initDataTables() {
    const tables = document.querySelectorAll('.data-table');
    
    tables.forEach(table => {
        const toolbar = table.closest('.content').querySelector('.toolbar');
        if (toolbar && !toolbar.querySelector('.search-box')) {
            const searchBox = document.createElement('div');
            searchBox.className = 'search-box';
            searchBox.innerHTML = `
                <input type="text" placeholder="Search..." class="search-input">
                <button type="button" class="search-btn">🔍</button>
            `;
            toolbar.appendChild(searchBox);

            const searchInput = searchBox.querySelector('.search-input');
            const searchBtn = searchBox.querySelector('.search-btn');

            searchBtn.addEventListener('click', performSearch);
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') performSearch();
            });

            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase();
                const rows = table.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            }
        }

        const headers = table.querySelectorAll('thead th');
        headers.forEach((header, index) => {
            if (index !== headers.length - 1) { // Skip actions column
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => sortTable(table, index));
            }
        });
    });
}

function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const isNumeric = columnIndex === 0; // Assuming first column is numeric (ID)
    
    const sortedRows = rows.sort((a, b) => {
        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();
        
        if (isNumeric) {
            return parseInt(aValue) - parseInt(bValue);
        } else {
            return aValue.localeCompare(bValue);
        }
    });

    tbody.innerHTML = '';
    sortedRows.forEach(row => tbody.appendChild(row));
}

function initModals() {
    if (!document.getElementById('modal-container')) {
        const modalContainer = document.createElement('div');
        modalContainer.id = 'modal-container';
        modalContainer.className = 'modal-container';
        modalContainer.innerHTML = `
            <div class="modal-backdrop"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <h3></h3>
                    <button class="modal-close">×</button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </div>
        `;
        document.body.appendChild(modalContainer);

        const backdrop = modalContainer.querySelector('.modal-backdrop');
        const closeBtn = modalContainer.querySelector('.modal-close');
        
        [backdrop, closeBtn].forEach(element => {
            element.addEventListener('click', closeModal);
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    }
}

function showModal(title, content, footer = '') {
    const modal = document.getElementById('modal-container');
    const header = modal.querySelector('.modal-header h3');
    const body = modal.querySelector('.modal-body');
    const footerEl = modal.querySelector('.modal-footer');

    header.textContent = title;
    body.innerHTML = content;
    footerEl.innerHTML = footer;

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('modal-container');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

function showLoading() {
    const loading = document.createElement('div');
    loading.id = 'global-loading';
    loading.className = 'global-loading';
    loading.innerHTML = '⏳ Loading...';
    document.body.appendChild(loading);
}

function hideLoading() {
    const loading = document.getElementById('global-loading');
    if (loading) loading.remove();
}

function makeRequest(url, method = 'GET', data = null) {
    showLoading();
    
    return fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: data ? JSON.stringify(data) : null
    })
    .then(response => {
        hideLoading();
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .catch(error => {
        hideLoading();
        console.error('Request failed:', error);
        showModal('Error', 'Request failed: ' + error.message);
    });
}

window.MPA = {
    showModal,
    closeModal,
    showLoading,
    hideLoading,
    makeRequest,
    validateField
};