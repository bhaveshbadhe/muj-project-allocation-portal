document.addEventListener('DOMContentLoaded', function() {
    // Get all required elements
    const sidebar = document.getElementById('sidebar');
    const main = document.querySelector('.main');
    const toggleBtn = document.querySelector('.toggle-btn');
    const mobileMenuBtn = document.querySelector('.mobile-menu-icon');
    
    // State management
    let isExpanded = false;
    let isMobile = window.innerWidth <= 768;
    
    // Function to expand sidebar
    function expandSidebar() {
        sidebar.classList.add('expand');
        main.classList.add('pushed');
        isExpanded = true;
        
        // Add overlay on mobile
        if (isMobile) {
            addOverlay();
        }
    }
    
    // Function to collapse sidebar
    function collapseSidebar() {
        sidebar.classList.remove('expand');
        main.classList.remove('pushed');
        isExpanded = false;
        
        // Remove overlay on mobile
        if (isMobile) {
            removeOverlay();
        }
    }
    
    // Add overlay for mobile
    function addOverlay() {
        if (!document.querySelector('.sidebar-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            `;
            document.body.appendChild(overlay);
            
            overlay.addEventListener('click', function() {
                collapseSidebar();
            });
        }
    }
    
    // Remove overlay
    function removeOverlay() {
        const overlay = document.querySelector('.sidebar-overlay');
        if (overlay) {
            overlay.remove();
        }
    }
    
    // Toggle sidebar state
    function toggleSidebar() {
        if (isExpanded) {
            collapseSidebar();
        } else {
            expandSidebar();
        }
    }
    
    // Mobile menu button handler
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });
    }
    
    // Desktop toggle button handler
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });
    }
    
    // Handle hover on desktop
    if (!isMobile) {
        sidebar.addEventListener('mouseenter', function() {
            if (!isExpanded) {
                expandSidebar();
            }
        });
        
        sidebar.addEventListener('mouseleave', function() {
            if (!isExpanded) {
                collapseSidebar();
            }
        });
    }
    
    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        
        resizeTimeout = setTimeout(function() {
            isMobile = window.innerWidth <= 768;
            
            if (isMobile) {
                main.style.marginLeft = '0';
                if (isExpanded) {
                    addOverlay();
                }
            } else {
                removeOverlay();
                main.style.marginLeft = isExpanded ? '260px' : '78px';
            }
        }, 250);
    });
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (isMobile && 
            isExpanded && 
            !sidebar.contains(e.target) && 
            !mobileMenuBtn.contains(e.target)) {
            collapseSidebar();
        }
    });
});