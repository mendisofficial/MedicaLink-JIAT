document.addEventListener('DOMContentLoaded', () => {
    "use strict";

    const dashboardContainer = document.getElementById('main-container');
    const sidebarContainer = document.getElementById('sidebar-container');
    
    const resizeObserver = new ResizeObserver(entries => {

        for (let entry of entries) {
          const height = entry.contentRect.height;
          const viewportHeight = window.innerHeight;
  
          if ((height + sidebarContainer.getBoundingClientRect().height) > viewportHeight) {
            sidebarContainer.classList.remove('bottom');
          } else {
            sidebarContainer.classList.add('bottom');
          }
        }
    });

    resizeObserver.observe(dashboardContainer);
});