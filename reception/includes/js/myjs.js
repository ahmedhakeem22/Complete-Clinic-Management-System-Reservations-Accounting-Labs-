// sidebar.js

document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggleSidebar");
    const sidebar = document.getElementById("sidebar");
    const content = document.getElementById("content");
    const footer = document.querySelector("footer.footer");
  
    toggleBtn.addEventListener("click", function () {
      sidebar.classList.toggle("active");
  
      if (sidebar.classList.contains("active")) {
        // Sidebar is hidden
        content.style.marginLeft = "0";
        if (footer) {
          footer.style.left = "0";
          footer.style.width = "100%";
        }
      } else {
        // Sidebar is visible
        content.style.marginLeft = "240px";
        if (footer) {
          footer.style.left = "240px";
          footer.style.width = "calc(100% - 240px)";
        }
      }
    });
  });
  