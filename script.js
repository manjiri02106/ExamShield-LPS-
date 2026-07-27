document.addEventListener("DOMContentLoaded", () => {
    // Theme Toggle Logic
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        const themeIcon = themeToggleBtn.querySelector('i');
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-theme');
            if (themeIcon) themeIcon.classList.replace('bx-moon', 'bx-sun');
        }

        themeToggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-theme');
            let theme = 'light';
            if (document.body.classList.contains('dark-theme')) {
                theme = 'dark';
                if (themeIcon) themeIcon.classList.replace('bx-moon', 'bx-sun');
            } else {
                if (themeIcon) themeIcon.classList.replace('bx-sun', 'bx-moon');
            }
            localStorage.setItem('theme', theme);
        });
    }

    // Common options for sparkline charts
    const sparklineOptions = {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: { left: -5, right: -5, bottom: 0, top: 5 }
        },
        plugins: {
            legend: { display: false },
            tooltip: { 
                enabled: true,
                mode: 'index',
                intersect: false,
                backgroundColor: 'rgba(15, 21, 35, 0.9)',
                titleFont: { size: 13, family: 'Inter' },
                bodyFont: { size: 12, family: 'Inter' },
                padding: 10,
                cornerRadius: 8,
                displayColors: false
            }
        },
        scales: {
            x: { display: false },
            y: { display: false }
        },
        elements: {
            point: { radius: 0, hitRadius: 10, hoverRadius: 4 }
        },
        interaction: { mode: 'index', intersect: false }
    };

    // Helper to create gradient
    const createGradient = (ctx, colorStart, colorEnd) => {
        const gradient = ctx.createLinearGradient(0, 0, 0, 60);
        gradient.addColorStop(0, colorStart);
        gradient.addColorStop(1, colorEnd);
        return gradient;
    };

    const labels30 = Array.from({length: 30}, (_, i) => i);

    // 1. Total Faculty Chart (Purple)
    const elTotal = document.getElementById('chartTotalFaculty');
    if (elTotal) {
        const dataTotal = [65, 68, 64, 72, 75, 78, 85, 95, 92, 90, 88, 92, 95, 88, 90, 85, 92, 95, 93, 100, 105, 95, 110, 105, 120, 130, 115, 125, 120, 130];
        const ctxTotal = elTotal.getContext('2d');
        new Chart(ctxTotal, {
            type: 'line',
            data: { labels: labels30, datasets: [{ data: dataTotal, borderColor: '#8b5cf6', borderWidth: 2, backgroundColor: createGradient(ctxTotal, 'rgba(139, 92, 246, 0.4)', 'rgba(139, 92, 246, 0)'), fill: true, tension: 0.4 }] },
            options: sparklineOptions
        });
        const ctxTotalPie = document.getElementById('pie_chartTotalFaculty').getContext('2d');
        new Chart(ctxTotalPie, {
            type: 'pie',
            data: { labels: ['Tenured', 'Tenure-Track', 'Adjunct'], datasets: [{ data: [450, 500, 334], backgroundColor: ['#8b5cf6', '#a78bfa', '#c4b5fd'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }

    // 2. Active Faculty Chart (Green)
    const elActive = document.getElementById('chartActiveFaculty');
    if (elActive) {
        const dataActive = [70, 75, 72, 80, 85, 82, 90, 95, 85, 88, 95, 100, 95, 90, 95, 88, 90, 95, 85, 95, 90, 95, 110, 100, 95, 90, 110, 95, 105, 100];
        const ctxActive = elActive.getContext('2d');
        new Chart(ctxActive, {
            type: 'line',
            data: { labels: labels30, datasets: [{ data: dataActive, borderColor: '#10b981', borderWidth: 2, backgroundColor: createGradient(ctxActive, 'rgba(16, 185, 129, 0.4)', 'rgba(16, 185, 129, 0)'), fill: true, tension: 0.4 }] },
            options: sparklineOptions
        });
        const ctxActivePie = document.getElementById('pie_chartActiveFaculty').getContext('2d');
        new Chart(ctxActivePie, {
            type: 'pie',
            data: { labels: ['Full Time', 'Part Time', 'Contract'], datasets: [{ data: [800, 300, 110], backgroundColor: ['#10b981', '#34d399', '#6ee7b7'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }

    // 3. Departments Chart (Blue)
    const elDept = document.getElementById('chartDepartments');
    if (elDept) {
        const dataDept = [18, 19, 18, 19, 20, 19, 21, 20, 19, 20, 22, 23, 22, 24, 25, 24, 23, 25, 24, 25, 27, 24, 25, 30, 28, 25, 27, 32, 25, 28];
        const ctxDept = elDept.getContext('2d');
        new Chart(ctxDept, {
            type: 'line',
            data: { labels: labels30, datasets: [{ data: dataDept, borderColor: '#3b82f6', borderWidth: 2, backgroundColor: createGradient(ctxDept, 'rgba(59, 130, 246, 0.4)', 'rgba(59, 130, 246, 0)'), fill: true, tension: 0.4 }] },
            options: sparklineOptions
        });
        const ctxDeptPie = document.getElementById('pie_chartDepartments').getContext('2d');
        new Chart(ctxDeptPie, {
            type: 'pie',
            data: { labels: ['Sciences', 'Arts', 'Engineering'], datasets: [{ data: [10, 6, 8], backgroundColor: ['#3b82f6', '#60a5fa', '#93c5fd'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }

    // 4. Open Positions Chart (Orange)
    const elOpen = document.getElementById('chartOpenPositions');
    if (elOpen) {
        const dataOpen = [10, 15, 12, 18, 15, 14, 22, 25, 24, 20, 18, 25, 22, 20, 18, 15, 18, 15, 18, 25, 22, 18, 15, 20, 25, 18, 15, 20, 15, 18];
        const ctxOpen = elOpen.getContext('2d');
        new Chart(ctxOpen, {
            type: 'line',
            data: { labels: labels30, datasets: [{ data: dataOpen, borderColor: '#f59e0b', borderWidth: 2, backgroundColor: createGradient(ctxOpen, 'rgba(245, 158, 11, 0.4)', 'rgba(245, 158, 11, 0)'), fill: true, tension: 0.4 }] },
            options: sparklineOptions
        });
        const ctxOpenPie = document.getElementById('pie_chartOpenPositions').getContext('2d');
        new Chart(ctxOpenPie, {
            type: 'pie',
            data: { labels: ['Professors', 'Assistants', 'Admin'], datasets: [{ data: [5, 10, 3], backgroundColor: ['#f59e0b', '#fbbf24', '#fcd34d'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }

    // 5. On Leave Chart (Purple)
    const elLeave = document.getElementById('chartOnLeave');
    if (elLeave) {
        const dataLeave = [40, 45, 42, 50, 48, 55, 60, 55, 50, 48, 55, 65, 60, 55, 60, 65, 55, 50, 55, 60, 55, 50, 55, 65, 75, 65, 70, 80, 65, 75];
        const ctxLeave = elLeave.getContext('2d');
        new Chart(ctxLeave, {
            type: 'line',
            data: { labels: labels30, datasets: [{ data: dataLeave, borderColor: '#8b5cf6', borderWidth: 2, backgroundColor: createGradient(ctxLeave, 'rgba(139, 92, 246, 0.4)', 'rgba(139, 92, 246, 0)'), fill: true, tension: 0.4 }] },
            options: sparklineOptions
        });
        const ctxLeavePie = document.getElementById('pie_chartOnLeave').getContext('2d');
        new Chart(ctxLeavePie, {
            type: 'pie',
            data: { labels: ['Medical', 'Sabbatical', 'Personal'], datasets: [{ data: [12, 15, 5], backgroundColor: ['#8b5cf6', '#a78bfa', '#c4b5fd'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }

    // Faculty Distribution Donut Chart (Wrap in if)
    const elDist = document.getElementById('chartDistribution');
    if (elDist) {
        const ctxDist = elDist.getContext('2d');
        new Chart(ctxDist, {
            type: 'doughnut',
            data: {
                labels: ['Computer Science', 'Engineering', 'Humanities', 'Sciences', 'Management'],
                datasets: [{
                    data: [410, 359, 231, 179, 105],
                    backgroundColor: ['#6366f1', '#3b82f6', '#f59e0b', '#10b981', '#8b5cf6'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, cutout: '75%', plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(15, 21, 35, 0.9)', titleFont: { size: 13, family: 'Inter' }, bodyFont: { size: 13, family: 'Inter' }, padding: 12, cornerRadius: 8, displayColors: true, boxPadding: 6 } } }
        });
    }

    // --- STUDENT DASHBOARD CHARTS ---
    const elTotalStudents = document.getElementById('chartTotalStudents');
    if (elTotalStudents) {
        const dataTotalStud = [40, 50, 45, 60, 55, 70, 75, 80, 85, 90, 85, 95, 100, 105, 100, 95, 110, 115, 120, 115, 125, 130, 125, 135, 140, 135, 145, 150, 145, 160];
        const ctxTotalStud = elTotalStudents.getContext('2d');
        new Chart(ctxTotalStud, {
            type: 'line',
            data: { labels: labels30, datasets: [{ data: dataTotalStud, borderColor: '#8b5cf6', borderWidth: 2, backgroundColor: createGradient(ctxTotalStud, 'rgba(139, 92, 246, 0.4)', 'rgba(139, 92, 246, 0)'), fill: true, tension: 0.4 }] },
            options: sparklineOptions
        });
        const ctxTotalStudPie = document.getElementById('pie_chartTotalStudents').getContext('2d');
        new Chart(ctxTotalStudPie, {
            type: 'pie',
            data: { labels: ['Undergrad', 'Postgrad', 'PhD'], datasets: [{ data: [800, 300, 140], backgroundColor: ['#8b5cf6', '#a78bfa', '#c4b5fd'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }

    const elActiveStudents = document.getElementById('chartActiveStudents');
    if (elActiveStudents) {
        const dataActiveStud = [40, 45, 42, 50, 48, 55, 60, 55, 50, 48, 55, 65, 60, 55, 60, 65, 55, 50, 55, 60, 55, 50, 55, 65, 75, 65, 70, 80, 65, 75];
        const ctxActiveStud = elActiveStudents.getContext('2d');
        new Chart(ctxActiveStud, {
            type: 'line',
            data: { labels: labels30, datasets: [{ data: dataActiveStud, borderColor: '#10b981', borderWidth: 2, backgroundColor: createGradient(ctxActiveStud, 'rgba(16, 185, 129, 0.4)', 'rgba(16, 185, 129, 0)'), fill: true, tension: 0.4 }] },
            options: sparklineOptions
        });
        const ctxActiveStudPie = document.getElementById('pie_chartActiveStudents').getContext('2d');
        new Chart(ctxActiveStudPie, {
            type: 'pie',
            data: { labels: ['Enrolled', 'On Leave'], datasets: [{ data: [1102, 138], backgroundColor: ['#10b981', '#34d399'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }

    const elProbation = document.getElementById('chartOnProbation');
    if (elProbation) {
        const dataProb = [5, 8, 10, 12, 10, 8, 15, 18, 20, 22, 20, 18, 25, 28, 30, 25, 20, 22, 28, 30, 35, 32, 28, 30, 35, 38, 40, 38, 35, 38];
        const ctxProb = elProbation.getContext('2d');
        new Chart(ctxProb, {
            type: 'line',
            data: { labels: labels30, datasets: [{ data: dataProb, borderColor: '#f59e0b', borderWidth: 2, backgroundColor: createGradient(ctxProb, 'rgba(245, 158, 11, 0.4)', 'rgba(245, 158, 11, 0)'), fill: true, tension: 0.4 }] },
            options: sparklineOptions
        });
        const ctxProbPie = document.getElementById('pie_chartOnProbation').getContext('2d');
        new Chart(ctxProbPie, {
            type: 'pie',
            data: { labels: ['Academic', 'Disciplinary'], datasets: [{ data: [25, 13], backgroundColor: ['#f59e0b', '#fbbf24'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }

    // Modal Logic
    const addFacultyModal = document.getElementById('addFacultyModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const triggerBtns = document.querySelectorAll('.add-faculty-trigger');
    const appContainer = document.querySelector('.app-container');

    // Open modal
    triggerBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            addFacultyModal.classList.add('show');
            if (appContainer) appContainer.classList.add('app-blurred');
        });
    });

    // Close modal function
    const closeModal = () => {
        if (addFacultyModal) addFacultyModal.classList.remove('show');
        if (appContainer) appContainer.classList.remove('app-blurred');
    };

    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);

    // Close when clicking outside of modal content
    window.addEventListener('click', (e) => {
        if (addFacultyModal && e.target === addFacultyModal) {
            closeModal();
        }
    });

    // Side Panel Logic
    const studentSidePanel = document.getElementById('studentSidePanel');
    const addStudentTriggers = document.querySelectorAll('.add-student-trigger');
    const closePanelBtn = document.getElementById('closePanelBtn');
    const closePanelOverlay = document.getElementById('closePanelOverlay');
    const cancelPanelBtn = document.getElementById('cancelPanelBtn');

    function openStudentPanel() {
        if(studentSidePanel) studentSidePanel.classList.add('show');
        if(appContainer) appContainer.classList.add('app-blurred');
    }

    function closeStudentPanel() {
        if(studentSidePanel) studentSidePanel.classList.remove('show');
        if(appContainer) appContainer.classList.remove('app-blurred');
    }

    addStudentTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            openStudentPanel();
        });
    });

    if(closePanelBtn) closePanelBtn.addEventListener('click', (e) => { e.preventDefault(); closeStudentPanel(); });
    if(closePanelOverlay) closePanelOverlay.addEventListener('click', closeStudentPanel);
    if(cancelPanelBtn) cancelPanelBtn.addEventListener('click', (e) => { e.preventDefault(); closeStudentPanel(); });
});
