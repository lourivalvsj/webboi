<script>
// Namespace para o aplicativo
const WebBoi = {
    drawer: {
        isOpen: false,
        element: null,
        overlay: null,
        
        init() {
            this.element = document.getElementById('mobileDrawer');
            this.overlay = document.querySelector('.mobile-drawer-overlay');
            
            // Event listeners
            this.bindEvents();
        },
        
        bindEvents() {
            // Fechar drawer ao redimensionar para desktop
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992 && this.isOpen) {
                    this.close();
                }
            });
            
            // Fechar drawer ao pressionar ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isOpen) {
                    this.close();
                }
            });
        },
        
        open() {
            if (!this.element || !this.overlay) return;
            
            // Armazenar posição atual do scroll
            const scrollY = window.scrollY;
            document.body.classList.add('drawer-open');
            document.body.style.top = `-${scrollY}px`;
            
            // Mostrar drawer
            this.element.classList.add('show');
            this.overlay.classList.add('show');
            this.isOpen = true;
            
            // Focus no primeiro link para acessibilidade
            setTimeout(() => {
                const firstLink = this.element.querySelector('.nav-link');
                if (firstLink) firstLink.focus();
            }, 300);
        },
        
        close() {
            if (!this.element || !this.overlay) return;
            
            // Restaurar posição do scroll
            const scrollY = document.body.style.top;
            document.body.classList.remove('drawer-open');
            document.body.style.top = '';
            
            if (scrollY) {
                window.scrollTo(0, parseInt(scrollY || '0') * -1);
            }
            
            // Esconder drawer
            this.element.classList.remove('show');
            this.overlay.classList.remove('show');
            this.isOpen = false;
            
            // Fechar todos os submenus
            this.closeAllSubmenus();
        },
        
        toggle() {
            this.isOpen ? this.close() : this.open();
        },
        
        closeAllSubmenus() {
            document.querySelectorAll('.drawer-submenu').forEach(submenu => {
                submenu.classList.remove('show');
                
                // Atualizar aria-expanded
                const parentLink = submenu.previousElementSibling;
                if (parentLink) {
                    parentLink.setAttribute('aria-expanded', 'false');
                }
            });
            
            document.querySelectorAll('.drawer-toggle').forEach(toggle => {
                toggle.classList.remove('rotated');
            });
        }
    },
    
    submenu: {
        toggle(submenuId, element) {
            const submenu = document.getElementById(submenuId);
            const toggle = element.querySelector('.drawer-toggle');
            const isExpanded = submenu.classList.contains('show');
            
            // Fechar outros submenus
            document.querySelectorAll('.drawer-submenu').forEach(otherSubmenu => {
                if (otherSubmenu.id !== submenuId) {
                    otherSubmenu.classList.remove('show');
                    
                    // Atualizar aria-expanded dos outros
                    const otherParent = otherSubmenu.previousElementSibling;
                    if (otherParent) {
                        otherParent.setAttribute('aria-expanded', 'false');
                    }
                }
            });
            
            document.querySelectorAll('.drawer-toggle').forEach(otherToggle => {
                if (otherToggle !== toggle) {
                    otherToggle.classList.remove('rotated');
                }
            });
            
            // Toggle atual
            submenu.classList.toggle('show');
            toggle.classList.toggle('rotated');
            
            // Atualizar aria-expanded
            element.setAttribute('aria-expanded', !isExpanded);
        }
    },
    
    utils: {
        // Máscaras para formulários
        maskCpfCnpj(field) {
            const v = field.value.replace(/\D/g, '');
            if (v.length <= 11) {
                field.value = v.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, function(_, a, b, c, d) {
                    return `${a}.${b}.${c}${d ? '-' + d : ''}`;
                });
            } else {
                field.value = v.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, function(_, a, b, c, d, e) {
                    return `${a}.${b}.${c}/${d}${e ? '-' + e : ''}`;
                });
            }
        },
        
        maskPhone(field) {
            const v = field.value.replace(/\D/g, '');
            if (v.length <= 10) {
                field.value = v.replace(/(\d{2})(\d{4})(\d{0,4})/, function(_, a, b, c) {
                    return `(${a}) ${b}${c ? '-' + c : ''}`;
                });
            } else {
                field.value = v.replace(/(\d{2})(\d{5})(\d{0,4})/, function(_, a, b, c) {
                    return `(${a}) ${b}${c ? '-' + c : ''}`;
                });
            }
        },
        
        // Função para mostrar notificações
        showNotification(message, type = 'info') {
            const alertClass = {
                success: 'alert-success',
                error: 'alert-danger',
                warning: 'alert-warning',
                info: 'alert-info'
            }[type] || 'alert-info';
            
            const icon = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            }[type] || 'fa-info-circle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            // Inserir no início da main-content
            const mainContent = document.getElementById('main-content');
            if (mainContent) {
                mainContent.insertAdjacentHTML('afterbegin', alertHtml);
                
                // Auto-remove após 5 segundos
                setTimeout(() => {
                    const alert = mainContent.querySelector('.alert');
                    if (alert) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            }
        }
    },
    
    // Inicialização do aplicativo
    init() {
        // Aguardar DOM carregar
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.drawer.init();
            });
        } else {
            this.drawer.init();
        }
        
        // Inicializar Bootstrap dropdowns
        const dropdownElements = document.querySelectorAll('.dropdown-toggle');
        dropdownElements.forEach(dropdownToggleEl => {
            new bootstrap.Dropdown(dropdownToggleEl);
        });
    }
};

// Funções globais para compatibilidade
function openDrawer() {
    WebBoi.drawer.open();
}

function closeDrawer() {
    WebBoi.drawer.close();
}

function toggleDrawer() {
    WebBoi.drawer.toggle();
}

function toggleSubmenu(submenuId, element) {
    WebBoi.submenu.toggle(submenuId, element);
}

function mascaraCpfCnpj(field) {
    WebBoi.utils.maskCpfCnpj(field);
}

function mascaraTelefone(field) {
    WebBoi.utils.maskPhone(field);
}

// Inicializar aplicativo
WebBoi.init();

// Melhorias de performance e acessibilidade
document.addEventListener('DOMContentLoaded', function() {
    // Lazy loading para imagens
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Auto-dismiss alerts após 5 segundos
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(alert => {
            if (bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        });
    }, 5000);
});
</script>
