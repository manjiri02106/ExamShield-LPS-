// =====================================
// ExamShield LPS - Analytics Charts
// =====================================

document.addEventListener("DOMContentLoaded", function () {

    loadLineChart();
    loadPieChart();

});

// =====================================
// Student Performance Line Chart
// =====================================

function loadLineChart() {

    const canvas = document.getElementById("lineChart");

    if (!canvas) return;

    new Chart(canvas, {

        type: "line",

        data: {

            labels: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun"
            ],

            datasets: [{

                label: "Average Marks",

                data: [
                    68,
                    72,
                    75,
                    81,
                    78,
                    85
                ],

                borderColor: "#2563eb",

                backgroundColor: "rgba(37,99,235,0.15)",

                fill: true,

                tension: 0.4

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {
                    display: true
                }

            }

        }

    });

}

// =====================================
// Result Distribution Pie Chart
// =====================================

function loadPieChart() {

    const canvas = document.getElementById("pieChart");

    if (!canvas) return;

    new Chart(canvas, {

        type: "pie",

        data: {

            labels: [
                "Pass",
                "Fail"
            ],

            datasets: [{

                data: [
                    85,
                    15
                ],

                backgroundColor: [
                    "#22c55e",
                    "#ef4444"
                ]

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    position: "bottom"

                }

            }

        }

    });

}

// =====================================
// Refresh Charts (Future Dynamic Data)
// =====================================

function refreshCharts() {

    location.reload();

}

// =====================================
// Export Analytics (Placeholder)
// =====================================

function exportAnalytics() {

    alert("Analytics Report Export Started");

}

// =====================================
// Print Dashboard
// =====================================

function printDashboard() {

    window.print();

}