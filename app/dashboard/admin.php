<?php
require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

checkRole("ADMIN");

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

// Helper: safe count query
function adminCount(mysqli $c, string $sql): int {
    $r = $c->query($sql);
    return ($r) ? (int)$r->fetch_assoc()['total'] : 0;
}

$totalDepartments = adminCount($conn, "SELECT COUNT(*) AS total FROM departments");
$totalFaculty     = adminCount($conn, "SELECT COUNT(*) AS total FROM users WHERE role='FACULTY'");
$totalStudents    = adminCount($conn, "SELECT COUNT(*) AS total FROM users WHERE role='STUDENT'");

// Courses & exams may not exist yet — suppress errors
$totalCourses   = 0;
$totalQuestions = 0;
$upcomingExams  = 0;
if ($conn->query("SHOW TABLES LIKE 'courses'")->num_rows)
    $totalCourses = adminCount($conn, "SELECT COUNT(*) AS total FROM courses");
if ($conn->query("SHOW TABLES LIKE 'questions'")->num_rows)
    $totalQuestions = adminCount($conn, "SELECT COUNT(*) AS total FROM questions WHERE is_active=1");
if ($conn->query("SHOW TABLES LIKE 'exams'")->num_rows)
    $upcomingExams = adminCount($conn, "SELECT COUNT(*) AS total FROM exams WHERE exam_date >= CURDATE() AND status IN ('SCHEDULED','LIVE')");

/*
|--------------------------------------------------------------------------
| Recent Faculty & Students
|--------------------------------------------------------------------------
*/
$recentFaculty = [];
$rf = $conn->query("SELECT name, email, created_at FROM users WHERE role='FACULTY' ORDER BY created_at DESC LIMIT 5");
if ($rf) while ($row = $rf->fetch_assoc()) $recentFaculty[] = $row;

$recentStudents = [];
$rs = $conn->query("SELECT name, email, created_at FROM users WHERE role='STUDENT' ORDER BY created_at DESC LIMIT 5");
if ($rs) while ($row = $rs->fetch_assoc()) $recentStudents[] = $row;

/*
|--------------------------------------------------------------------------
| Faculty & Student distribution by department
|--------------------------------------------------------------------------
*/
$deptChartLabels = [];
$deptFacultyData = [];
$deptStudentData = [];
$dq = $conn->query("
    SELECT d.department_name,
           SUM(u.role='FACULTY') AS faculty_cnt,
           SUM(u.role='STUDENT') AS student_cnt
    FROM departments d
    LEFT JOIN users u ON u.department_id = d.id
    GROUP BY d.id, d.department_name
    ORDER BY d.department_name
    LIMIT 8
");
if ($dq) {
    while ($row = $dq->fetch_assoc()) {
        $deptChartLabels[] = $row['department_name'];
        $deptFacultyData[] = (int)$row['faculty_cnt'];
        $deptStudentData[] = (int)$row['student_cnt'];
    }
}

require_once "../includes/header.php";
require_once "../includes/sidebar_admin.php";
require_once "../includes/navbar.php";
?>

<link rel="stylesheet" href="../../assets/css/admin_tables.css">

<div class="content-wrapper">

    <!-- ── Page Header ── -->
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Overview &mdash; <?php echo date('l, d M Y'); ?></p>
    </div>

    <!-- ── Stat Cards ── -->
    <div class="row g-3 mb-4">

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon blue"><i class="bi bi-diagram-3-fill"></i></div>
                    <span class="stat-trend neu"><i class="bi bi-dash"></i> Total</span>
                </div>
                <div class="stat-value"><?php echo $totalDepartments; ?></div>
                <div class="stat-label">Departments</div>
                <div class="stat-card-footer">
                    <a href="../admin/departments/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon green"><i class="bi bi-person-badge-fill"></i></div>
                    <span class="stat-trend up"><i class="bi bi-arrow-up"></i> Active</span>
                </div>
                <div class="stat-value"><?php echo $totalFaculty; ?></div>
                <div class="stat-label">Faculty</div>
                <div class="stat-card-footer">
                    <a href="../admin/faculty/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon red"><i class="bi bi-mortarboard-fill"></i></div>
                    <span class="stat-trend up"><i class="bi bi-arrow-up"></i> Enrolled</span>
                </div>
                <div class="stat-value"><?php echo $totalStudents; ?></div>
                <div class="stat-label">Students</div>
                <div class="stat-card-footer">
                    <a href="../admin/students/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon amber"><i class="bi bi-journal-bookmark-fill"></i></div>
                    <span class="stat-trend neu"><i class="bi bi-dash"></i> Total</span>
                </div>
                <div class="stat-value"><?php echo $totalCourses; ?></div>
                <div class="stat-label">Courses</div>
                <div class="stat-card-footer">
                    <a href="../admin/courses/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon violet"><i class="bi bi-patch-question-fill"></i></div>
                    <span class="stat-trend neu"><i class="bi bi-dash"></i> Bank</span>
                </div>
                <div class="stat-value"><?php echo $totalQuestions; ?></div>
                <div class="stat-label">Questions</div>
                <div class="stat-card-footer">
                    <a href="../admin/question_bank/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon cyan"><i class="bi bi-journal-check"></i></div>
                    <span class="stat-trend up"><i class="bi bi-clock"></i> Soon</span>
                </div>
                <div class="stat-value"><?php echo $upcomingExams; ?></div>
                <div class="stat-label">Upcoming Exams</div>
                <div class="stat-card-footer">
                    <a href="../admin/exams/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div><!-- /stat cards -->

    <!-- ── Charts + Quick Actions ── -->
    <div class="row g-4 mb-4">

        <!-- Department Distribution Chart -->
        <div class="col-lg-7">
            <div class="section-card">
                <div class="section-card-header">
                    <h2 class="section-card-title">
                        <i class="bi bi-bar-chart-fill"></i>
                        Department Distribution
                    </h2>
                    <span class="section-card-badge"><?php echo count($deptChartLabels); ?> Depts</span>
                </div>
                <div class="section-card-body" style="position:relative;height:240px;">
                    <?php if (empty($deptChartLabels)): ?>
                        <div class="adm-empty" style="padding:40px 0;">
                            <div class="adm-empty-icon"><i class="bi bi-bar-chart"></i></div>
                            <div class="adm-empty-text">No department data yet.</div>
                        </div>
                    <?php else: ?>
                        <canvas id="deptChart"></canvas>
                    <?php endif; ?>
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
                        <a href="../admin/faculty/create.php" class="btn-adm btn-adm-primary" id="qaDashFaculty">
                            <i class="bi bi-person-plus-fill"></i> Add Faculty
                        </a>
                        <a href="../admin/students/create.php" class="btn-adm btn-adm-secondary" id="qaDashStudent">
                            <i class="bi bi-mortarboard"></i> Add Student
                        </a>
                        <a href="../admin/departments/create.php" class="btn-adm btn-adm-secondary" id="qaDashDept">
                            <i class="bi bi-diagram-3"></i> Add Department
                        </a>
                        <a href="../admin/exams/create.php" class="btn-adm btn-adm-secondary" id="qaDashExam">
                            <i class="bi bi-calendar-plus"></i> Schedule Exam
                        </a>
                        <a href="../admin/question_bank/create.php" class="btn-adm btn-adm-secondary" id="qaDashQuestion">
                            <i class="bi bi-patch-plus"></i> Add Question
                        </a>
                        <a href="../admin/notifications/create.php" class="btn-adm btn-adm-secondary" id="qaDashNotif">
                            <i class="bi bi-send"></i> Send Notification
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /charts row -->

    <!-- ── Recent Faculty + Students ── -->
    <div class="row g-4">

        <!-- Recent Faculty -->
        <div class="col-lg-6">
            <div class="section-card">
                <div class="section-card-header">
                    <h2 class="section-card-title">
                        <i class="bi bi-person-badge"></i>
                        Recent Faculty
                    </h2>
                    <a href="../admin/faculty/index.php" class="section-card-badge" style="text-decoration:none;cursor:pointer;">View All</a>
                </div>
                <div class="section-card-body" style="padding:0;">
                    <?php if (empty($recentFaculty)): ?>
                        <div class="adm-empty" style="padding:32px 0;">
                            <div class="adm-empty-icon"><i class="bi bi-person-badge"></i></div>
                            <div class="adm-empty-text">No faculty registered yet.</div>
                        </div>
                    <?php else: ?>
                    <div class="activity-list">
                        <?php foreach ($recentFaculty as $f):
                            $initial = strtoupper(substr($f['name'], 0, 1));
                            $ts = date('d M Y', strtotime($f['created_at']));
                        ?>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background:linear-gradient(135deg,#10b981,#34d399);">
                                <?php echo $initial; ?>
                            </div>
                            <div class="activity-info">
                                <div class="activity-name"><?php echo htmlspecialchars($f['name']); ?></div>
                                <div class="activity-meta"><?php echo htmlspecialchars($f['email']); ?></div>
                            </div>
                            <time class="activity-time relative-time"
                                  datetime="<?php echo date('c', strtotime($f['created_at'])); ?>"
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

        <!-- Recent Students -->
        <div class="col-lg-6">
            <div class="section-card">
                <div class="section-card-header">
                    <h2 class="section-card-title">
                        <i class="bi bi-mortarboard-fill"></i>
                        Recent Students
                    </h2>
                    <a href="../admin/students/index.php" class="section-card-badge" style="text-decoration:none;cursor:pointer;">View All</a>
                </div>
                <div class="section-card-body" style="padding:0;">
                    <?php if (empty($recentStudents)): ?>
                        <div class="adm-empty" style="padding:32px 0;">
                            <div class="adm-empty-icon"><i class="bi bi-mortarboard"></i></div>
                            <div class="adm-empty-text">No students registered yet.</div>
                        </div>
                    <?php else: ?>
                    <div class="activity-list">
                        <?php foreach ($recentStudents as $s):
                            $initial = strtoupper(substr($s['name'], 0, 1));
                            $ts = date('d M Y', strtotime($s['created_at']));
                        ?>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background:linear-gradient(135deg,#ef4444,#f87171);">
                                <?php echo $initial; ?>
                            </div>
                            <div class="activity-info">
                                <div class="activity-name"><?php echo htmlspecialchars($s['name']); ?></div>
                                <div class="activity-meta"><?php echo htmlspecialchars($s['email']); ?></div>
                            </div>
                            <time class="activity-time relative-time"
                                  datetime="<?php echo date('c', strtotime($s['created_at'])); ?>"
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
    &copy; <?php echo date('Y'); ?> ExamShield LPS &mdash; Admin Panel. All rights reserved.
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
        if (s < 60)      return 'Just now';
        if (s < 3600)    return Math.floor(s/60) + 'm ago';
        if (s < 86400)   return Math.floor(s/3600) + 'h ago';
        if (s < 2592000) return Math.floor(s/86400) + 'd ago';
        return Math.floor(s/2592000) + 'mo ago';
    }
    document.querySelectorAll('time.relative-time').forEach(el => {
        el.textContent = timeAgo(el.getAttribute('datetime'));
    });

    /* ─── Department Chart ─── */
    const ctx = document.getElementById('deptChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($deptChartLabels); ?>,
                datasets: [
                    {
                        label: 'Faculty',
                        data: <?php echo json_encode($deptFacultyData); ?>,
                        backgroundColor: 'rgba(16,185,129,0.75)',
                        borderRadius: 6,
                        borderSkipped: false
                    },
                    {
                        label: 'Students',
                        data: <?php echo json_encode($deptStudentData); ?>,
                        backgroundColor: 'rgba(99,102,241,0.75)',
                        borderRadius: 6,
                        borderSkipped: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { font: { family:'Poppins', size:12 }, usePointStyle:true, padding:16 } }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { family:'Poppins', size:11 } } },
                    y: { grid: { color:'#f1f5f9' }, ticks: { font: { family:'Poppins', size:11 }, precision:0 }, beginAtZero:true }
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