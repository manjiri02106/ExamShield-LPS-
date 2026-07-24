// ======================================
// ExamShield LPS - Attendance Module JS
// ======================================

document.addEventListener("DOMContentLoaded", function () {

    console.log("Attendance Module Loaded");

    // Search Attendance
    const searchInput = document.getElementById("searchAttendance");

    if (searchInput) {
        searchInput.addEventListener("keyup", function () {

            let filter = searchInput.value.toUpperCase();
            let table = document.getElementById("attendanceTable");

            if (!table) return;

            let tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {

                let td = tr[i].getElementsByTagName("td");

                let found = false;

                for (let j = 0; j < td.length; j++) {

                    if (td[j]) {

                        let txtValue = td[j].textContent || td[j].innerText;

                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }

                    }

                }

                tr[i].style.display = found ? "" : "none";

            }

        });
    }

    // Department Filter
    const departmentFilter = document.getElementById("departmentFilter");

    if (departmentFilter) {

        departmentFilter.addEventListener("change", function () {

            filterAttendance();

        });

    }

    // Status Filter
    const statusFilter = document.getElementById("statusFilter");

    if (statusFilter) {

        statusFilter.addEventListener("change", function () {

            filterAttendance();

        });

    }

});

// ================================
// Filter Function
// ================================

function filterAttendance() {

    const department = document.getElementById("departmentFilter").value;
    const status = document.getElementById("statusFilter").value;

    const table = document.getElementById("attendanceTable");

    if (!table) return;

    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {

        let dept = rows[i].getAttribute("data-department");
        let stat = rows[i].getAttribute("data-status");

        let show = true;

        if (department !== "All" && dept !== department) {
            show = false;
        }

        if (status !== "All" && stat !== status) {
            show = false;
        }

        rows[i].style.display = show ? "" : "none";

    }

}

// ================================
// Export Attendance
// ================================

function exportAttendance() {

    alert("Attendance Report Export Started");

    // Later connect with PHP PDF/Excel Export

}

// ================================
// Print Attendance
// ================================

function printAttendance() {

    window.print();

}

// ================================
// Refresh Table
// ================================

function refreshAttendance() {

    location.reload();

}

// ================================
// Mark Attendance
// ================================

function markAttendance(studentId, status) {

    console.log("Student ID :", studentId);
    console.log("Status :", status);

    alert("Attendance Updated Successfully");

    // Later connect with AJAX + PHP

}