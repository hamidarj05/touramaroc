document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.querySelector('.toggle-btn');
    const mainContent = document.querySelector('.main');
    const sidebarLinks = document.querySelectorAll('.sidebar-link');

    function toggleSidebar() {
        sidebar.classList.toggle('collapsed');
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    }

    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleSidebar);
    }

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            sidebarLinks.forEach(l => l.parentElement.classList.remove('active'));
            this.parentElement.classList.add('active');
            const pageTitle = this.querySelector('span').textContent;
            document.getElementById('page-title').textContent = pageTitle;
            if (window.innerWidth < 992) {
                sidebar.classList.remove('show');
            }
        });
    });

    const notificationDropdown = document.getElementById('notificationsDropdown');
    if (notificationDropdown) {
        notificationDropdown.addEventListener('show.bs.dropdown', function () { 
            const badge = this.querySelector('.badge');
            if (badge) {
                badge.style.display = 'none'; 
            }
        });
    }

    const crudForm = document.getElementById('crudForm');
    const saveButton = document.getElementById('saveButton');
    const crudModal = new bootstrap.Modal(document.getElementById('crudModal'));

    if (saveButton && crudForm) {
        saveButton.addEventListener('click', function() {
            if (crudForm.checkValidity()) {
                const itemId = document.getElementById('itemId').value;
                const itemName = document.getElementById('itemName').value;
                const itemDescription = document.getElementById('itemDescription').value;
                console.log('Enregistrement des données:', { id: itemId, name: itemName, description: itemDescription });
                showAlert('Opération réussie!', 'success');
                crudModal.hide();
                crudForm.reset();
            } else {
                crudForm.reportValidity();
            }
        });
    }

    function showAlert(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
        alertDiv.role = 'alert';
        alertDiv.style.zIndex = '1100';
        alertDiv.style.minWidth = '300px';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.body.appendChild(alertDiv);
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertDiv);
            bsAlert.close();
        }, 5000);
    }

    const quickActionButtons = document.querySelectorAll('.quick-action');
    quickActionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            switch(action) {
                case 'new-circuit':
                    document.getElementById('modalTitle').textContent = 'Nouveau circuit';
                    document.getElementById('itemId').value = '';
                    crudModal.show();
                    break;
                case 'send-newsletter':
                    showAlert('Fonctionnalité d\'envoi de newsletter bientôt disponible!', 'info');
                    break;
                case 'generate-report':
                    showAlert('Génération du rapport en cours...', 'info');
                    setTimeout(() => {
                        showAlert('Rapport généré avec succès!', 'success');
                    }, 2000);
                    break;
                case 'settings':
                    showAlert('Ouvrir les paramètres du site', 'info');
                    break;
            }
        });
    });

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const userDropdown = document.getElementById('userDropdown');
    if (userDropdown) {
        userDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdownMenu = this.nextElementSibling;
            dropdownMenu.classList.toggle('show');
        });
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target)) {
                const dropdownMenu = userDropdown.nextElementSibling;
                if (dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                }
            }
        });
    }

    function loadDashboardData() {
        console.log('Chargement des données du tableau de bord...');
        updateCounter('user-count', 1245);
        updateCounter('reservation-count', 342);
        updateCounter('circuit-count', 56);
        updateCounter('revenue-count', 12450, true);
    }

    function updateCounter(elementId, target, isCurrency = false) {
        const element = document.getElementById(elementId);
        if (!element) return;
        const duration = 2000;
        const start = 0;
        const startTime = performance.now();
        function updateNumber(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const current = Math.floor(progress * (target - start) + start);
            let displayValue;
            if (isCurrency) {
                displayValue = '$' + current.toLocaleString();
            } else {
                displayValue = current.toLocaleString();
            }
            element.textContent = displayValue;
            if (progress < 1) {
                requestAnimationFrame(updateNumber);
            } else {
                element.textContent = isCurrency ? '$' + target.toLocaleString() : target.toLocaleString();
            }
        }
        requestAnimationFrame(updateNumber);
    }

    loadDashboardData();

    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth < 992) {
                if (!sidebar.classList.contains('collapsed')) {
                    sidebar.classList.add('collapsed');
                }
            }
        }, 250);
    });

    if (window.innerWidth < 992) {
        sidebar.classList.add('collapsed');
    }
}); 
