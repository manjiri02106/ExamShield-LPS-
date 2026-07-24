/**
 * ==========================================
 * Student Result Management & Reports - JavaScript
 * ==========================================
 */

document.addEventListener('DOMContentLoaded', function () {
    // ------------------------------------------
    // 1. Mobile Sidebar Toggle
    // ------------------------------------------
    const sidebarToggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    if (sidebarToggleBtn && sidebar) {
        sidebarToggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (e) {
            if (window.innerWidth < 992 &&
                sidebar.classList.contains('show') &&
                !sidebar.contains(e.target) &&
                !sidebarToggleBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    }

    // ------------------------------------------
    // 2. Live Percentage & Status Calculation
    // ------------------------------------------
    const marksInput = document.getElementById('marks');
    const totalMarksInput = document.getElementById('total_marks');
    const percentageInput = document.getElementById('percentage');
    const statusInput = document.getElementById('status');

    function updateCalculations() {
        if (marksInput && totalMarksInput && percentageInput && statusInput) {
            const marks = parseFloat(marksInput.value) || 0;
            const total = parseFloat(totalMarksInput.value) || 100;

            if (total > 0) {
                const pct = ((marks / total) * 100).toFixed(2);
                percentageInput.value = pct;

                if (parseFloat(pct) >= 40) {
                    statusInput.value = 'Pass';
                    statusInput.className = 'form-control form-control-custom bg-success-subtle text-success fw-bold';
                } else {
                    statusInput.value = 'Fail';
                    statusInput.className = 'form-control form-control-custom bg-danger-subtle text-danger fw-bold';
                }
            } else {
                percentageInput.value = '0.00';
                statusInput.value = 'Fail';
            }
        }
    }

    if (marksInput && totalMarksInput) {
        marksInput.addEventListener('input', updateCalculations);
        totalMarksInput.addEventListener('input', updateCalculations);
    }

    // ------------------------------------------
    // 3. Edit Result Modal Filler
    // ------------------------------------------
    const editButtons = document.querySelectorAll('.btn-edit-result');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const studentId = this.getAttribute('data-student');
            const examId = this.getAttribute('data-exam');
            const marks = this.getAttribute('data-marks');
            const totalMarks = this.getAttribute('data-total');

            document.getElementById('result_id').value = id;
            document.getElementById('student_id').value = studentId;
            document.getElementById('exam_id').value = examId;
            document.getElementById('marks').value = marks;
            document.getElementById('total_marks').value = totalMarks;

            updateCalculations();

            const modalTitle = document.getElementById('resultModalLabel');
            if (modalTitle) modalTitle.innerHTML = '<i class="fas fa-edit me-2"></i>Edit Student Result';
            
            const submitBtn = document.getElementById('saveResultSubmit');
            if (submitBtn) submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Result';
        });
    });

    // Reset modal on hide
    const resultModal = document.getElementById('resultModal');
    if (resultModal) {
        resultModal.addEventListener('hidden.bs.modal', function () {
            document.getElementById('resultForm').reset();
            document.getElementById('result_id').value = '';
            
            const modalTitle = document.getElementById('resultModalLabel');
            if (modalTitle) modalTitle.innerHTML = '<i class="fas fa-plus-circle me-2"></i>Add Student Result';
            
            const submitBtn = document.getElementById('saveResultSubmit');
            if (submitBtn) submitBtn.innerHTML = '<i class="fas fa-plus-circle me-2"></i>Save Result';

            updateCalculations();
        });
    }

    // ------------------------------------------
    // 4. Initialize Dashboard Chart.js Visualizations
    // ------------------------------------------
    if (document.getElementById('performanceLineChart')) {
        loadDashboardCharts();
    }
});

/**
 * Fetch dynamic JSON chart data and render 4 Chart.js graphs
 */
function loadDashboardCharts() {
    fetch('chart_data.php')
        .then(response => response.json())
        .then(data => {
            renderPerformanceLineChart(data.performance_overview);
            renderResultSummaryDoughnutChart(data.result_summary);
            renderDepartmentBarChart(data.department_performance);
            renderTopStudentsHorizontalBarChart(data.top_students);
        })
        .catch(err => {
            console.error('Error loading chart data:', err);
        });
}

// 1. Performance Overview - Line Chart (Monthly Jan - Dec)
function renderPerformanceLineChart(perfData) {
    const ctx = document.getElementById('performanceLineChart').getContext('2d');
    
    // Gradient fill under line
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.3)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: perfData.labels,
            datasets: [{
                label: 'Monthly Average Score (%)',
                data: perfData.data,
                borderColor: '#2563eb',
                borderWidth: 3,
                backgroundColor: gradient,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return 'Avg Score: ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: '#f1f5f9' },
                    ticks: { callback: value => value + '%' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

// 2. Result Summary - Doughnut Chart (Pass vs Fail)
function renderResultSummaryDoughnutChart(summaryData) {
    const ctx = document.getElementById('resultSummaryDoughnutChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: summaryData.labels,
            datasets: [{
                data: summaryData.data,
                backgroundColor: ['#10b981', '#ef4444'],
                hoverBackgroundColor: ['#059669', '#dc2626'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 20, font: { family: 'Poppins', size: 12 } }
                }
            },
            cutout: '70%'
        }
    });
}

// 3. Department Wise Performance - Bar Chart
function renderDepartmentBarChart(deptData) {
    const ctx = document.getElementById('departmentBarChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: deptData.labels,
            datasets: [{
                label: 'Average Score (%)',
                data: deptData.data,
                backgroundColor: '#3b82f6',
                borderRadius: 6,
                hoverBackgroundColor: '#1d4ed8'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: '#f1f5f9' },
                    ticks: { callback: value => value + '%' }
                },
                x: { grid: { display: false } }
            }
        }
    });
}

// 4. Top Performing Students - Horizontal Bar Chart (Top 10)
function renderTopStudentsHorizontalBarChart(topData) {
    const ctx = document.getElementById('topStudentsBarChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: topData.labels,
            datasets: [{
                label: 'Percentage (%)',
                data: topData.data,
                backgroundColor: '#10b981',
                borderRadius: 6,
                hoverBackgroundColor: '#059669'
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: '#f1f5f9' },
                    ticks: { callback: value => value + '%' }
                },
                y: { grid: { display: false } }
            }
        }
    });
}
