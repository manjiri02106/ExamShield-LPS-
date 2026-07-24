<?php
require_once(__DIR__ . '/config/database.php');

$totalStudents = 0;
$passStudents = 0;
$failStudents = 0;
$passPercentage = 0;

if (isset($conn) && $conn) {
    $resSt = mysqli_query($conn, "SELECT COUNT(*) as count FROM students");
    if ($resSt) $totalStudents = mysqli_fetch_assoc($resSt)['count'];

    $resPass = mysqli_query($conn, "SELECT COUNT(*) as count FROM results WHERE status = 'Pass'");
    if ($resPass) $passStudents = mysqli_fetch_assoc($resPass)['count'];

    $resFail = mysqli_query($conn, "SELECT COUNT(*) as count FROM results WHERE status = 'Fail'");
    if ($resFail) $failStudents = mysqli_fetch_assoc($resFail)['count'];

    $totalResults = $passStudents + $failStudents;
    if ($totalResults > 0) {
        $passPercentage = round(($passStudents / $totalResults) * 100, 1);
    }
}

// --- DUMMY DATA FOR DASHBOARD ---

$kpiCards = [
    [
        'title' => 'Pass Percentage',
        'value' => $passPercentage . '%',
        'trend' => '',
        'trendClass' => '',
        'subtitle' => 'Overall Success Rate',
        'subtitleClass' => 'badge-success-light',
        'icon' => 'bx-line-chart',
        'iconColor' => 'icon-green',
        'chartId' => 'chartPassPercentage'
    ],
    [
        'title' => 'Total Faculty',
        'value' => '1,284',
        'trend' => '<i class="bx bx-up-arrow-alt"></i> 12.5%',
        'trendClass' => 'positive',
        'subtitle' => 'vs last month',
        'subtitleClass' => '',
        'icon' => 'bx-group',
        'iconColor' => 'icon-purple',
        'chartId' => 'chartTotalFaculty'
    ],
    [
        'title' => 'Active Faculty',
        'value' => '1,210',
        'trend' => '',
        'trendClass' => '',
        'subtitle' => '94.2% of total',
        'subtitleClass' => '',
        'icon' => 'bx-pulse',
        'iconColor' => 'icon-green',
        'chartId' => 'chartActiveFaculty'
    ],
    [
        'title' => 'Departments',
        'value' => '24',
        'trend' => '',
        'trendClass' => '',
        'subtitle' => 'Across all disciplines',
        'subtitleClass' => '',
        'icon' => 'bxs-bank',
        'iconColor' => 'icon-blue',
        'chartId' => 'chartDepartments'
    ],
    [
        'title' => 'Open Positions',
        'value' => '18',
        'trend' => '',
        'trendClass' => '',
        'subtitle' => 'Hiring Now',
        'subtitleClass' => 'badge-warning',
        'icon' => 'bx-user-plus',
        'iconColor' => 'icon-orange',
        'chartId' => 'chartOpenPositions'
    ],
    [
        'title' => 'On Leave',
        'value' => '32',
        'trend' => '',
        'trendClass' => '',
        'subtitle' => '2.5% of total',
        'subtitleClass' => '',
        'icon' => 'bx-calendar-event',
        'iconColor' => 'icon-purple-light',
        'chartId' => 'chartOnLeave'
    ]
];

$recentAdditions = [
    [
        'name' => 'Dr. Emily Watson',
        'role' => 'Associate Professor',
        'dept' => 'Computer Science',
        'time' => '2 hours ago',
        'avatar' => 'https://i.pravatar.cc/150?img=32'
    ],
    [
        'name' => 'Prof. James Miller',
        'role' => 'Assistant Professor',
        'dept' => 'Mechanical Engg.',
        'time' => '5 hours ago',
        'avatar' => 'https://i.pravatar.cc/150?img=12'
    ],
    [
        'name' => 'Dr. Lisa Anderson',
        'role' => 'Professor',
        'dept' => 'Biotechnology',
        'time' => '1 day ago',
        'avatar' => 'https://i.pravatar.cc/150?img=5'
    ],
    [
        'name' => 'Dr. Michael Brown',
        'role' => 'Lecturer',
        'dept' => 'Physics',
        'time' => '2 days ago',
        'avatar' => 'https://i.pravatar.cc/150?img=53'
    ]
];

$facultyStatus = [
    ['label' => 'Active', 'icon' => 'bx-user-check', 'colorClass' => 'icon-green', 'bgClass' => 'bg-green', 'count' => '1,210', 'percent' => 94.2],
    ['label' => 'On Leave', 'icon' => 'bx-user-x', 'colorClass' => 'icon-orange', 'bgClass' => 'bg-orange', 'count' => '32', 'percent' => 2.5],
    ['label' => 'On Duty', 'icon' => 'bx-briefcase', 'colorClass' => 'icon-blue', 'bgClass' => 'bg-blue', 'count' => '28', 'percent' => 2.2],
    ['label' => 'Retired', 'icon' => 'bxs-graduation', 'colorClass' => 'icon-purple', 'bgClass' => 'bg-purple', 'count' => '14', 'percent' => 1.1]
];

$quickActions = [
    ['label' => 'Result Generation', 'icon' => 'bx-file-invoice icon-success', 'class' => '', 'url' => 'modules/results/generate_result.php'],
    ['label' => 'Automatic Evaluation', 'icon' => 'bx-robot icon-primary', 'class' => '', 'url' => 'modules/results/automatic_evaluation.php'],
    ['label' => 'Add Faculty', 'icon' => 'bx-user-plus icon-purple', 'class' => 'add-faculty-trigger'],
    ['label' => 'Bulk Upload', 'icon' => 'bx-cloud-upload icon-green'],
    ['label' => 'Import from CSV', 'icon' => 'bx-file icon-blue'],
    ['label' => 'Generate Report', 'icon' => 'bx-pie-chart-alt-2 icon-orange'],
    ['label' => 'Email Faculty', 'icon' => 'bx-envelope icon-purple'],
    ['label' => 'Performance Review', 'icon' => 'bx-line-chart icon-red'],
    ['label' => 'Leave Calendar', 'icon' => 'bx-calendar icon-teal'],
    ['label' => 'Manage Departments', 'icon' => 'bx-building icon-blue']
];

$facultyDirectory = [
    [
        'name' => 'Dr. Alistair Vance',
        'email' => 'alistair.vance@edu.edu',
        'avatar' => 'https://i.pravatar.cc/150?img=68',
        'empId' => 'FID-92031',
        'dept' => 'Physics',
        'designation' => 'Senior Lecturer',
        'expertise' => 'Quantum Physics',
        'expertiseClass' => 'badge-purple-light',
        'status' => 'Active',
        'statusDot' => 'dot-green',
        'joiningDate' => '15 Jan 2020'
    ],
    [
        'name' => 'Prof. Elena Rodriguez',
        'email' => 'elena.rodriguez@edu.edu',
        'avatar' => 'https://i.pravatar.cc/150?img=47',
        'empId' => 'FID-88422',
        'dept' => 'Biotechnology',
        'designation' => 'Department Head',
        'expertise' => 'Genetic Engineering',
        'expertiseClass' => 'badge-green-light',
        'status' => 'Active',
        'statusDot' => 'dot-green',
        'joiningDate' => '10 Mar 2019'
    ],
    [
        'name' => 'Dr. Marcus Thorne',
        'email' => 'marcus.thorne@edu.edu',
        'avatar' => 'https://i.pravatar.cc/150?img=59',
        'empId' => 'FID-77012',
        'dept' => 'History',
        'designation' => 'Emeritus Professor',
        'expertise' => 'Ancient Civilizations',
        'expertiseClass' => 'badge-orange-light',
        'status' => 'On Leave',
        'statusDot' => 'dot-orange',
        'joiningDate' => '22 Aug 2015'
    ],
    [
        'name' => 'Ms. Sarah Jenkins',
        'email' => 'sarah.jenkins@edu.edu',
        'avatar' => 'https://i.pravatar.cc/150?img=41',
        'empId' => 'FID-94511',
        'dept' => 'Computer Science',
        'designation' => 'Assistant Professor',
        'expertise' => 'Machine Learning',
        'expertiseClass' => 'badge-blue-light',
        'status' => 'Active',
        'statusDot' => 'dot-green',
        'joiningDate' => '05 Feb 2021'
    ]
];

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management - EduAdmin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css?v=' . time() . '">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="bx bxs-graduation"></i>
                    <div>
                        <h2>EduAdmin</h2>
                        <p>Higher Education Portal</p>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <a href="#" class="menu-item menu-item-dashboard">
                    <i class="bx bx-home-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="menu-section">ACADEMIC MANAGEMENT</div>
                <a href="index.php" class="menu-item active">
                    <i class="bx bx-group"></i>
                    <span>Faculty Management</span>
                </a>
                <a href="students.php" class="menu-item">
                    <i class="bx bx-user"></i>
                    <span>Student Management</span>
                </a>
                <a href="student_profile.php" class="menu-item">
                    <i class="bx bx-user-pin"></i>
                    <span>Student Profile</span>
                </a>
                <a href="enrollment.php" class="menu-item">
                    <i class="bx bx-id-card"></i>
                    <span>Enrollment</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-building"></i>
                    <span>Department Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-book-open"></i>
                    <span>Subject Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-calendar-event"></i>
                    <span>Timetable Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-calendar-x"></i>
                    <span>Leave Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-line-chart"></i>
                    <span>Performance Review</span>
                </a>

                <div class="menu-section">OPERATIONS</div>
                <a href="bulk_upload.php" class="menu-item">
                    <i class="bx bx-upload"></i>
                    <span>Bulk Upload</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-file"></i>
                    <span>Exam Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-chalkboard"></i>
                    <span>Notice Board</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-calendar-star"></i>
                    <span>Event Management</span>
                </a>
                <a href="#" class="menu-item has-submenu">
                    <i class="bx bx-message-rounded-dots"></i>
                    <span>Communication</span>
                    <i class="bx bx-chevron-right submenu-icon"></i>
                </a>

                <div class="menu-section">ANALYTICS & REPORTS</div>
                <a href="#" class="menu-item has-submenu">
                    <i class="bx bx-bar-chart-alt-2"></i>
                    <span>Reports & Analytics</span>
                    <i class="bx bx-chevron-right submenu-icon"></i>
                </a>
                <a href="#" class="menu-item has-submenu">
                    <i class="bx bx-pie-chart-alt-2"></i>
                    <span>Data Insights</span>
                    <i class="bx bx-chevron-right submenu-icon"></i>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-history"></i>
                    <span>Audit Logs</span>
                </a>

                <div class="menu-section">SYSTEM</div>
                <a href="#" class="menu-item">
                    <i class="bx bx-cog"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-user-circle"></i>
                    <span>User Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-lock-alt"></i>
                    <span>Roles & Permissions</span>
                </a>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="topbar">
                <div class="search-bar">
                    <i class="bx bx-search"></i>
                    <input type="text" placeholder="Search faculty by name, ID, department, expertise...">
                    <span class="cmd-k">⌘ /</span>
                </div>
                <div class="topbar-right">
                    <button class="icon-btn" id="theme-toggle"><i class="bx bx-moon"></i></button>
                    <button class="icon-btn has-badge">
                        <i class="bx bx-bell"></i>
                        <span class="badge">7</span>
                    </button>
                    <button class="icon-btn has-badge">
                        <i class="bx bx-envelope"></i>
                        <span class="badge">3</span>
                    </button>
                    <div class="user-profile">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Admin User">
                        <div class="user-info">
                            <span class="user-name">Admin User</span>
                            <span class="user-role">System Administrator</span>
                        </div>
                        <i class="bx bx-chevron-down profile-chevron"></i>
                    </div>
                </div>
            </header>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <h1>ExamShield-LPS Dashboard</h1>
                    <div class="breadcrumbs">
                        <span>Main Dashboard</span> <i class="bx bx-chevron-right"></i> <span class="current">Overview</span>
                    </div>
                </div>
                <div class="page-actions">
                    <button class="btn btn-outline"><i class="bx bx-download"></i> Export Data</button>
                    <div class="split-btn">
                        <button class="btn btn-primary main-btn add-faculty-trigger"><i class="bx bx-plus"></i> Add New Faculty</button>
                        <button class="btn btn-primary split-icon-btn"><i class="bx bx-chevron-down"></i></button>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- KPI Cards -->
                <div class="kpi-grid">
';

foreach($kpiCards as $card) {
    echo '
                    <div class="kpi-card">
                        <div class="kpi-card-content">
                            <div class="kpi-top">
                                <h3 class="kpi-title">' . $card['title'] . '</h3>
                                <div class="kpi-icon ' . $card['iconColor'] . '">
                                    <i class="bx ' . $card['icon'] . '"></i>
                                </div>
                            </div>
                            <div class="kpi-middle">
                                <div class="kpi-value-row">
                                    <span class="number">' . $card['value'] . '</span>';
    
    if($card['trend']) {
        echo '
                                    <span class="trend ' . $card['trendClass'] . '">' . $card['trend'] . '</span>';
    }
    
    echo '
                                </div>
                                <span class="kpi-subtitle ' . $card['subtitleClass'] . '">' . $card['subtitle'] . '</span>
                            </div>
                        </div>
                        <div class="kpi-chart">
                            <canvas id="' . $card['chartId'] . '"></canvas>
                        </div>
                        <div class="kpi-hover-panel">
                            <h5>' . $card['title'] . ' Breakdown</h5>
                            <div class="pie-container">
                                <canvas id="pie_' . $card['chartId'] . '"></canvas>
                            </div>
                        </div>
                    </div>
';
}

echo '
                </div>

                <!-- Middle Row: Charts & Lists -->
                <div class="middle-row-grid">
                    <!-- Faculty Distribution -->
                    <div class="card distribution-card">
                        <div class="card-header">
                            <h3>Faculty Distribution</h3>
                            <button class="icon-btn-small"><i class="bx bx-dots-vertical-rounded"></i></button>
                        </div>
                        <div class="card-body donut-chart-container">
                            <div class="donut-wrapper">
                                <canvas id="chartDistribution"></canvas>
                                <div class="donut-center">
                                    <span class="number">1,284</span>
                                    <span class="label">Total</span>
                                </div>
                            </div>
                            <div class="chart-legend">
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #6366f1;"></div>
                                    <span class="legend-label">Computer Science</span>
                                    <span class="legend-value">32% <span class="count">(410)</span></span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #3b82f6;"></div>
                                    <span class="legend-label">Engineering</span>
                                    <span class="legend-value">28% <span class="count">(359)</span></span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #f59e0b;"></div>
                                    <span class="legend-label">Humanities</span>
                                    <span class="legend-value">18% <span class="count">(231)</span></span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #10b981;"></div>
                                    <span class="legend-label">Sciences</span>
                                    <span class="legend-value">14% <span class="count">(179)</span></span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color" style="background: #8b5cf6;"></div>
                                    <span class="legend-label">Management</span>
                                    <span class="legend-value">8% <span class="count">(105)</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer centered">
                            <button class="btn btn-outline-full">View Full Report</button>
                        </div>
                    </div>

                    <!-- Recent Additions -->
                    <div class="card recent-additions-card">
                        <div class="card-header">
                            <h3>Recent Additions</h3>
                            <a href="#" class="link-btn">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="list-container">
';

foreach($recentAdditions as $addition) {
    echo '
                                <div class="list-item">
                                    <img src="' . $addition['avatar'] . '" alt="Avatar">
                                    <div class="item-info">
                                        <h4>' . $addition['name'] . '</h4>
                                        <p>' . $addition['role'] . '</p>
                                    </div>
                                    <div class="item-dept">' . $addition['dept'] . '</div>
                                    <div class="item-time">' . $addition['time'] . '</div>
                                </div>
';
}

echo '
                            </div>
                        </div>
                        <div class="card-footer centered">
                            <a href="#" class="link-btn">View All Recent Additions</a>
                        </div>
                    </div>

                    <!-- Faculty Status Overview -->
                    <div class="card status-overview-card">
                        <div class="card-header">
                            <h3>Faculty Status Overview</h3>
                            <a href="#" class="link-btn">View Report</a>
                        </div>
                        <div class="card-body">
                            <div class="progress-list">
';

foreach($facultyStatus as $status) {
    echo '
                                <div class="progress-item">
                                    <div class="progress-header">
                                        <div class="status-label">
                                            <div class="status-icon ' . $status['colorClass'] . '"><i class="bx ' . $status['icon'] . '"></i></div>
                                            <span>' . $status['label'] . '</span>
                                        </div>
                                        <div class="status-stats">
                                            <span class="count">' . $status['count'] . '</span>
                                            <span class="percent">' . $status['percent'] . '%</span>
                                        </div>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar ' . $status['bgClass'] . '" style="width: ' . $status['percent'] . '%"></div>
                                    </div>
                                </div>
';
}

echo '
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions-section">
                    <h3>Quick Actions</h3>
                    <div class="quick-actions-grid">
';

foreach($quickActions as $action) {
    $extraClass = isset($action['class']) ? ' ' . $action['class'] : '';
    echo '
                        ' . (isset($action['url']) ? '<a href="' . $action['url'] . '" class="action-btn' . $extraClass . '" style="display:inline-block; text-decoration:none;"><i class="bx ' . $action['icon'] . '"></i> ' . $action['label'] . '</a>' : '<button class="action-btn' . $extraClass . '"><i class="bx ' . $action['icon'] . '"></i> ' . $action['label'] . '</button>') . '
';
}

echo '
                    </div>
                </div>

                <!-- Faculty Directory Table -->
                <div class="card directory-card">
                    <div class="card-header table-header">
                        <div class="table-title">
                            <h3>Faculty Directory</h3>
                            <p>Manage and view all faculty members</p>
                        </div>
                        <div class="table-actions">
                            <div class="search-input">
                                <i class="bx bx-search"></i>
                                <input type="text" placeholder="Search faculty...">
                            </div>
                            <button class="btn btn-outline"><i class="bx bx-filter"></i> Filter <i class="bx bx-chevron-down"></i></button>
                            <button class="btn btn-outline"><i class="bx bx-sort"></i> Sort</button>
                            <button class="btn btn-outline" style="color: var(--danger); border-color: var(--danger);"><i class="bx bx-trash"></i> Delete</button>
                            <button class="icon-btn-small"><i class="bx bx-dots-vertical-rounded"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>FACULTY MEMBER</th>
                                    <th>EMPLOYEE ID</th>
                                    <th>DEPARTMENT</th>
                                    <th>DESIGNATION</th>
                                    <th>SUBJECT EXPERTISE</th>
                                    <th>STATUS</th>
                                    <th>JOINING DATE</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
';

foreach($facultyDirectory as $faculty) {
    echo '
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <img src="' . $faculty['avatar'] . '" alt="User">
                                            <div>
                                                <div class="name">' . $faculty['name'] . '</div>
                                                <div class="email">' . $faculty['email'] . '</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>' . $faculty['empId'] . '</td>
                                    <td>' . $faculty['dept'] . '</td>
                                    <td>' . $faculty['designation'] . '</td>
                                    <td><span class="badge ' . $faculty['expertiseClass'] . '">' . $faculty['expertise'] . '</span></td>
                                    <td><span class="status-dot ' . $faculty['statusDot'] . '"></span> ' . $faculty['status'] . '</td>
                                    <td>' . $faculty['joiningDate'] . '</td>
                                    <td class="actions-cell">
                                        <button class="action-icon"><i class="bx bx-show"></i></button>
                                        <button class="action-icon"><i class="bx bx-edit-alt"></i></button>
                                        <button class="action-icon" style="color: var(--danger);"><i class="bx bx-trash"></i></button>
                                        <button class="action-icon"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    </td>
                                </tr>
';
}

echo '
                            </tbody>
                        </table>
                    </div>
                    <div class="table-footer">
                        <div class="showing-entries">Showing 1 to 4 of 1,284 entries</div>
                        <div class="pagination">
                            <button class="page-btn"><i class="bx bx-chevron-left"></i></button>
                            <button class="page-btn active">1</button>
                            <button class="page-btn">2</button>
                            <button class="page-btn">3</button>
                            <span class="page-dots">...</span>
                            <button class="page-btn">129</button>
                            <button class="page-btn"><i class="bx bx-chevron-right"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Add Faculty Modal -->
    <div id="addFacultyModal" class="modal">
        <div class="modal-content">
            <div class="modal-header-custom">
                <div>
                    <h2>Add New Faculty Record</h2>
                    <p>Enter comprehensive details for the new staff member.</p>
                </div>
                <button class="close-modal" id="closeModalBtn"><i class="bx bx-x"></i></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body-custom">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>FULL NAME</label>
                            <input type="text" name="full_name" placeholder="e.g. Dr. Jane Doe" required>
                        </div>
                        <div class="form-group">
                            <label>EMPLOYEE ID</label>
                            <input type="text" name="employee_id" placeholder="FID-XXXXX" required>
                        </div>
                        <div class="form-group">
                            <label>EMAIL ADDRESS</label>
                            <input type="email" name="email_address" placeholder="jane.doe@edu-inst.edu" required>
                        </div>
                        <div class="form-group">
                            <label>PHONE NUMBER</label>
                            <input type="text" name="phone_number" placeholder="+1 (555) 000-0000" required>
                        </div>
                        <div class="form-group">
                            <label>DEPARTMENT</label>
                            <div class="select-wrapper">
                                <select name="department" required>
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="cs">Computer Science</option>
                                    <option value="eng">Engineering</option>
                                    <option value="hum">Humanities</option>
                                </select>
                                <i class="bx bx-chevron-down select-icon"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>SUBJECT EXPERTISE</label>
                            <input type="text" name="subject_expertise" placeholder="e.g. Artificial Intelligence" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-cancel" id="cancelModalBtn">Cancel</button>
                    <button type="submit" name="add_faculty" class="btn-create">Create Record</button>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
';
?>
