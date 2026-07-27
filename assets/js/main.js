// ===========================================
// ExamShield LPS - Main JavaScript
// ===========================================

document.addEventListener("DOMContentLoaded", function () {

    console.log("ExamShield LPS Loaded Successfully");

    initializeTooltips();
    initializeAlerts();
    initializeSidebar();
    initializeSearch();

});

// ===========================================
// Sidebar Toggle
// ===========================================

function initializeSidebar() {

    const toggleBtn = document.getElementById("menuToggle");
    const sidebar = document.getElementById("sidebar");

    if (toggleBtn && sidebar) {

        toggleBtn.addEventListener("click", function () {

            sidebar.classList.toggle("active");

        });

    }

}

// ===========================================
// Search Box
// ===========================================

function initializeSearch() {

    const search = document.getElementById("searchBox");

    if (!search) return;

    search.addEventListener("keyup", function () {

        let filter = search.value.toUpperCase();

        let table = document.querySelector("table");

        if (!table) return;

        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {

            let td = tr[i].getElementsByTagName("td");

            let found = false;

            for (let j = 0; j < td.length; j++) {

                if (td[j]) {

                    let value = td[j].textContent || td[j].innerText;

                    if (value.toUpperCase().indexOf(filter) > -1) {

                        found = true;
                        break;

                    }

                }

            }

            tr[i].style.display = found ? "" : "none";

        }

    });

}

// ===========================================
// Auto Close Alerts
// ===========================================

function initializeAlerts() {

    const alerts = document.querySelectorAll(".alert");

    alerts.forEach(function (alert) {

        setTimeout(function () {

            alert.style.display = "none";

        }, 4000);

    });

}

// ===========================================
// Tooltips
// ===========================================

function initializeTooltips() {

    const elements = document.querySelectorAll("[title]");

    elements.forEach(function (element) {

        element.style.cursor = "pointer";

    });

}

// ===========================================
// Confirm Delete
// ===========================================

function confirmDelete() {

    return confirm("Are you sure you want to delete this record?");

}

// ===========================================
// Loading Button
// ===========================================

function loadingButton(button) {

    if (!button) return;

    button.disabled = true;
    button.innerHTML = "Please Wait...";

}

// ===========================================
// Success Message
// ===========================================

function showSuccess(message) {

    alert(message);

}

// ===========================================
// Error Message
// ===========================================

function showError(message) {

    alert(message);

}

// ===========================================
// Refresh Page
// ===========================================

function refreshPage() {

    location.reload();

}

// ===========================================
// Print Page
// ===========================================

function printPage() {

    window.print();

}

// ===========================================
// Scroll To Top
// ===========================================

function scrollTopPage() {

    window.scrollTo({

        top: 0,
        behavior: "smooth"

    });

}

// ===========================================
// Logout Confirmation
// ===========================================

function confirmLogout() {

    return confirm("Do you really want to logout?");

}