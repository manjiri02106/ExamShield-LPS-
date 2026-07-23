<?php
require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

checkRole("STUDENT");

$userId = (int)$_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

function studentCount(mysqli $c, string $sql): int {
    $r = $c->query($sql);
    return ($r) ? (int)$r->fetch_assoc()['total'] : 0;
}

$enrolledCourses = 1; // Assuming student is enrolled in at least 1 course
$mySubjects = 0;
$upcomingExams = 0;
$completedExams = 0;
$averageScore = 0;
$pendingExams = 0; // Exams assigned but not taken

if ($conn->query("SHOW TABLES LIKE 'subjects'")->num_rows) {
    // In a real scenario, this would filter by the student's department/course
    $mySubjects = studentCount($conn, "SELECT COUNT(*) AS total FROM subjects WHERE status='ACTIVE'");
}

if ($conn->query("SHOW TABLES LIKE 'exams'")->num_rows) {
    // Placeholder logic for upcoming exams
    $upcomingExams = studentCount($conn, "SELECT COUNT(*) AS total FROM exams WHERE exam_date >= CURDATE() AND status IN ('SCHEDULED','LIVE')");
}

/*
|--------------------------------------------------------------------------
| Performance Trend (Chart Data)
|--------------------------------------------------------------------------
*/
// Placeholder data until a results module is fully implemented
$perfChartLabels = ['Exam 1', 'Exam 2', 'Exam 3', 'Exam 4', 'Exam 5'];
$perfChartData = [75, 82, 78, 88, 91];

/*
|--------------------------------------------------------------------------
| Recent Activity / Upcoming Deadlines
|--------------------------------------------------------------------------
*/
$recentActivities = [];
// Placeholder activities
$recentActivities[] = ['title' => 'Software Engineering Midterm', 'meta' => 'Scheduled for tomorrow', 'time' => date('Y-m-d H:i:s', strtotime('+1 day'))];
$recentActivities[] = ['title' => 'Database Systems Quiz', 'meta' => 'Results published', 'time' => date('Y-m-d H:i:s', strtotime('-2 days'))];
$recentActivities[] = ['title' => 'Computer Networks Final', 'meta' => 'Registration open', 'time' => date('Y-m-d H:i:s', strtotime('-5 days'))];


require_once "../includes/header.php";
require_once "../includes/sidebar_student.php";
require_once "../includes/navbar.php";
?>

<link rel="stylesheet" href="../../assets/css/admin_tables.css">

<div class="content-wrapper">

    <!-- ── Page Header ── -->
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">My Portal &mdash; <?php echo date('l, d M Y'); ?></p>
    </div>

    <!-- ── Stat Cards ── -->
    <div class="row g-3 mb-4">

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon indigo"><i class="bi bi-journal-bookmark-fill"></i></div>
                    <span class="stat-trend neu"><i class="bi bi-dash"></i> Active</span>
                </div>
                <div class="stat-value"><?php echo $enrolledCourses; ?></div>
                <div class="stat-label">Enrolled Courses</div>
                <div class="stat-card-footer">
                    <a href="../student/courses/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon green"><i class="bi bi-book-fill"></i></div>
                    <span class="stat-trend neu"><i class="bi bi-dash"></i> Total</span>
                </div>
                <div class="stat-value"><?php echo $mySubjects; ?></div>
                <div class="stat-label">My Subjects</div>
                <div class="stat-card-footer">
                    <a href="../student/subjects/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon amber"><i class="bi bi-calendar-event"></i></div>
                    <span class="stat-trend up"><i class="bi bi-clock"></i> Soon</span>
                </div>
                <div class="stat-value"><?php echo $upcomingExams; ?></div>
                <div class="stat-label">Upcoming Exams</div>
                <div class="stat-card-footer">
                    <a href="../student/exams/upcoming.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon cyan"><i class="bi bi-check-circle-fill"></i></div>
                    <span class="stat-trend neu"><i class="bi bi-dash"></i> Done</span>
                </div>
                <div class="stat-value"><?php echo $completedExams; ?></div>
                <div class="stat-label">Completed Exams</div>
                <div class="stat-card-footer">
                    <a href="../student/exams/history.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon red"><i class="bi bi-graph-up-arrow"></i></div>
                    <span class="stat-trend up"><i class="bi bi-arrow-up"></i> Top 10%</span>
                </div>
                <div class="stat-value"><?php echo $averageScore; ?>%</div>
                <div class="stat-label">Average Score</div>
                <div class="stat-card-footer">
                    <a href="../student/results/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon violet"><i class="bi bi-hourglass-split"></i></div>
                    <span class="stat-trend neu"><i class="bi bi-dash"></i> To do</span>
                </div>
                <div class="stat-value"><?php echo $pendingExams; ?></div>
                <div class="stat-label">Pending Exams</div>
                <div class="stat-card-footer">
                    <a href="../student/exams/upcoming.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div><!-- /stat cards -->

    <!-- ── Charts + Quick Actions ── -->
    <div class="row g-4 mb-4">

        <!-- Chart -->
        <div class="col-lg-7">
            <div class="section-card">
                <div class="section-card-header">
                    <h2 class="section-card-title">
                        <i class="bi bi-graph-up"></i>
                        Performance Trend
                    </h2>
                    <span class="section-card-badge">Last 5 Exams</span>
                </div>
                <div class="section-card-body" style="position:relative;height:260px;">
                    <canvas id="perfChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-5">
            <div class="section-card h-100">
                <div class="section-card-header">
                    <h2 class="section-card-title">
                        <i class="bi bi-lightning-charge-fill"></i>
                        Quick Actions
                    </h2>
                </div>
                <div class="section-card-body">
                    <div class="d-grid gap-2">
                        <a href="../student/exams/take.php" class="btn-adm btn-adm-primary">
                            <i class="bi bi-pencil-square"></i> Start Exam
                        </a>
                        <a href="../student/exams/upcoming.php" class="btn-adm btn-adm-secondary">
                            <i class="bi bi-calendar-event"></i> View Schedule
                        </a>
                        <a href="../student/results/index.php" class="btn-adm btn-adm-secondary">
                            <i class="bi bi-award"></i> View Results
                        </a>
                        <a href="../student/courses/index.php" class="btn-adm btn-adm-secondary">
                            <i class="bi bi-journal-bookmark"></i> Open Course Materials
                        </a>
                        <a href="../profile/profile.php" class="btn-adm btn-adm-secondary">
                            <i class="bi bi-person-circle"></i> Update Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /charts row -->

    <!-- ── Recent Activity ── -->
    <div class="row g-4">
        
        <div class="col-lg-12">
            <div class="section-card">
                <div class="section-card-header">
                    <h2 class="section-card-title">
                        <i class="bi bi-clock-history"></i>
                        Upcoming Deadlines & Recent Activity
                    </h2>
                    <a href="../student/notifications/index.php" class="section-card-badge" style="text-decoration:none;cursor:pointer;">View All</a>
                </div>
                <div class="section-card-body" style="padding:0;">
                    <?php if (empty($recentActivities)): ?>
                        <div class="adm-empty" style="padding:32px 0;">
                            <div class="adm-empty-icon"><i class="bi bi-bell-slash"></i></div>
                            <div class="adm-empty-text">No recent activity.</div>
                        </div>
                    <?php else: ?>
                    <div class="activity-list">
                        <?php foreach ($recentActivities as $a):
                            $ts = date('d M Y, h:i A', strtotime($a['time']));
                        ?>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background:rgba(99,102,241,.15); color:#6366f1; font-size:16px;">
                                <i class="bi bi-app-indicator"></i>
                            </div>
                            <div class="activity-info">
                                <div class="activity-name"><?php echo htmlspecialchars($a['title']); ?></div>
                                <div class="activity-meta"><?php echo htmlspecialchars($a['meta']); ?></div>
                            </div>
                            <time class="activity-time relative-time"
                                  datetime="<?php echo date('c', strtotime($a['time'])); ?>"
                                  title="<?php echo $ts; ?>">
                                <?php echo $ts; ?>
                            </time>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div><!-- /recent rows -->

</div><!-- /content-wrapper -->

<!-- ── Footer ── -->
</div><!-- /main-content -->

<footer class="dashboard-footer" style="margin-left:var(--sidebar-width);transition:margin-left .25s ease;">
    &copy; <?php echo date('Y'); ?> ExamShield LPS &mdash; Student Portal. All rights reserved.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ─── Relative timestamps ─── */
    function timeAgo(d) {
        const s = Math.floor((new Date() - new Date(d)) / 1000);
        
        // Handle future dates (upcoming)
        if (s < 0) {
            const fs = Math.abs(s);
            if (fs < 3600) return 'In ' + Math.floor(fs/60) + 'm';
            if (fs < 86400) return 'In ' + Math.floor(fs/3600) + 'h';
            return 'In ' + Math.floor(fs/86400) + 'd';
        }
        
        if (s < 60)      return 'Just now';
        if (s < 3600)    return Math.floor(s/60) + 'm ago';
        if (s < 86400)   return Math.floor(s/3600) + 'h ago';
        if (s < 2592000) return Math.floor(s/86400) + 'd ago';
        return Math.floor(s/2592000) + 'mo ago';
    }
    document.querySelectorAll('time.relative-time').forEach(el => {
        el.textContent = timeAgo(el.getAttribute('datetime'));
    });

    /* ─── Performance Chart ─── */
    const ctx = document.getElementById('perfChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($perfChartLabels); ?>,
                datasets: [{
                    label: 'Score (%)',
                    data: <?php echo json_encode($perfChartData); ?>,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6366f1',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { family:'Poppins', size:11 } } },
                    y: { 
                        grid: { color:'#f1f5f9', borderDash: [5, 5] }, 
                        ticks: { font: { family:'Poppins', size:11 } },
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    }

    /* ─── Responsive footer margin ─── */
    const footer = document.querySelector('.dashboard-footer');
    function updateFooter() {
        if (!footer) return;
        footer.style.marginLeft = window.innerWidth <= 768 ? '0' :
            getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width').trim();
    }
    updateFooter();
    window.addEventListener('resize', updateFooter);

    /* ─── Mobile sidebar toggle ─── */
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebar   = document.getElementById('mainSidebar');
    const content   = document.getElementById('mainContent');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar?.classList.toggle('sidebar-open');
            content?.classList.toggle('sidebar-pushed');
        });
    }
});
</script>

</body>
</html>