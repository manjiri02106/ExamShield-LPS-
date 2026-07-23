<?php
require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

checkRole("FACULTY");

$userId = (int)$_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

function facultyCount(mysqli $c, string $sql): int {
    $r = $c->query($sql);
    return ($r) ? (int)$r->fetch_assoc()['total'] : 0;
}

$myQuestions = 0;
$assignedExams = 0;
$upcomingExams = 0;
$pendingEvals = 0;
$publishedResults = 0;

if ($conn->query("SHOW TABLES LIKE 'questions'")->num_rows) {
    $myQuestions = facultyCount($conn, "SELECT COUNT(*) AS total FROM questions WHERE created_by = $userId AND is_active=1");
}

if ($conn->query("SHOW TABLES LIKE 'exam_faculty'")->num_rows && $conn->query("SHOW TABLES LIKE 'exams'")->num_rows) {
    $assignedExams = facultyCount($conn, "SELECT COUNT(*) AS total FROM exam_faculty WHERE faculty_id = $userId");
    $upcomingExams = facultyCount($conn, "
        SELECT COUNT(*) AS total 
        FROM exams e 
        JOIN exam_faculty ef ON e.id = ef.exam_id 
        WHERE ef.faculty_id = $userId 
        AND e.exam_date >= CURDATE() 
        AND e.status IN ('SCHEDULED','LIVE')
    ");
}

/*
|--------------------------------------------------------------------------
| Questions by Difficulty (Chart Data)
|--------------------------------------------------------------------------
*/
$diffChartLabels = ['Easy', 'Medium', 'Hard'];
$diffChartData = [0, 0, 0];
if ($conn->query("SHOW TABLES LIKE 'questions'")->num_rows) {
    $dq = $conn->query("
        SELECT difficulty, COUNT(*) as cnt 
        FROM questions 
        WHERE created_by = $userId 
        GROUP BY difficulty
    ");
    if ($dq) {
        while ($r = $dq->fetch_assoc()) {
            $diff = strtoupper($r['difficulty']);
            if ($diff === 'EASY') $diffChartData[0] = (int)$r['cnt'];
            if ($diff === 'MEDIUM') $diffChartData[1] = (int)$r['cnt'];
            if ($diff === 'HARD') $diffChartData[2] = (int)$r['cnt'];
        }
    }
}

/*
|--------------------------------------------------------------------------
| Recent Activity
|--------------------------------------------------------------------------
*/
$recentQuestions = [];
if ($conn->query("SHOW TABLES LIKE 'questions'")->num_rows) {
    $rq = $conn->query("
        SELECT q.question_text, q.difficulty, q.created_at, s.subject_name 
        FROM questions q
        LEFT JOIN subjects s ON q.subject_id = s.id
        WHERE q.created_by = $userId 
        ORDER BY q.created_at DESC 
        LIMIT 5
    ");
    if ($rq) while ($row = $rq->fetch_assoc()) $recentQuestions[] = $row;
}

require_once "../includes/header.php";
require_once "../includes/sidebar_faculty.php";
require_once "../includes/navbar.php";
?>

<link rel="stylesheet" href="../../assets/css/admin_tables.css">

<div class="content-wrapper">

    <!-- ── Page Header ── -->
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Teaching Overview &mdash; <?php echo date('l, d M Y'); ?></p>
    </div>

    <!-- ── Stat Cards ── -->
    <div class="row g-3 mb-4">

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon indigo"><i class="bi bi-patch-question-fill"></i></div>
                    <span class="stat-trend up"><i class="bi bi-arrow-up"></i> Total</span>
                </div>
                <div class="stat-value"><?php echo $myQuestions; ?></div>
                <div class="stat-label">My Questions</div>
                <div class="stat-card-footer">
                    <a href="../faculty/question_bank/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon green"><i class="bi bi-journal-check"></i></div>
                    <span class="stat-trend neu"><i class="bi bi-dash"></i> Total</span>
                </div>
                <div class="stat-value"><?php echo $assignedExams; ?></div>
                <div class="stat-label">Assigned Exams</div>
                <div class="stat-card-footer">
                    <a href="../faculty/exams/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon red"><i class="bi bi-calendar-event"></i></div>
                    <span class="stat-trend up"><i class="bi bi-clock"></i> Soon</span>
                </div>
                <div class="stat-value"><?php echo $upcomingExams; ?></div>
                <div class="stat-label">Upcoming Exams</div>
                <div class="stat-card-footer">
                    <a href="../faculty/exams/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon amber"><i class="bi bi-pencil-square"></i></div>
                    <span class="stat-trend neu"><i class="bi bi-dash"></i> Pending</span>
                </div>
                <div class="stat-value"><?php echo $pendingEvals; ?></div>
                <div class="stat-label">Pending Eval.</div>
                <div class="stat-card-footer">
                    <a href="#" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon cyan"><i class="bi bi-clipboard-data-fill"></i></div>
                    <span class="stat-trend up"><i class="bi bi-check-all"></i> Published</span>
                </div>
                <div class="stat-value"><?php echo $publishedResults; ?></div>
                <div class="stat-label">Published Results</div>
                <div class="stat-card-footer">
                    <a href="../faculty/results/index.php" class="stat-footer-link">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon violet"><i class="bi bi-bell-fill"></i></div>
                    <span class="stat-trend neu"><i class="bi bi-dash"></i> Unread</span>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Notifications</div>
                <div class="stat-card-footer">
                    <a href="../faculty/notifications/index.php" class="stat-footer-link">
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
                        <i class="bi bi-pie-chart-fill"></i>
                        My Questions by Difficulty
                    </h2>
                    <span class="section-card-badge"><?php echo $myQuestions; ?> Total</span>
                </div>
                <div class="section-card-body" style="position:relative;height:260px;display:flex;align-items:center;justify-content:center;">
                    <?php if ($myQuestions === 0): ?>
                        <div class="adm-empty" style="padding:0;">
                            <div class="adm-empty-icon" style="width:50px;height:50px;font-size:20px;margin-bottom:10px;"><i class="bi bi-pie-chart"></i></div>
                            <div class="adm-empty-text">No questions created yet.</div>
                        </div>
                    <?php else: ?>
                        <canvas id="diffChart" style="max-height:100%;"></canvas>
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
                        <a href="../faculty/question_bank/create.php" class="btn-adm btn-adm-primary">
                            <i class="bi bi-plus-circle"></i> Create Question
                        </a>
                        <a href="../faculty/question_bank/index.php" class="btn-adm btn-adm-secondary">
                            <i class="bi bi-patch-question"></i> Manage Question Bank
                        </a>
                        <a href="../faculty/exams/index.php" class="btn-adm btn-adm-secondary">
                            <i class="bi bi-journal-check"></i> View Assigned Exams
                        </a>
                        <a href="../faculty/results/index.php" class="btn-adm btn-adm-secondary">
                            <i class="bi bi-clipboard-data"></i> Review Results
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
                        Recently Added Questions
                    </h2>
                    <a href="../faculty/question_bank/index.php" class="section-card-badge" style="text-decoration:none;cursor:pointer;">View All</a>
                </div>
                <div class="section-card-body" style="padding:0;">
                    <?php if (empty($recentQuestions)): ?>
                        <div class="adm-empty" style="padding:32px 0;">
                            <div class="adm-empty-icon"><i class="bi bi-patch-question"></i></div>
                            <div class="adm-empty-text">You haven't added any questions recently.</div>
                        </div>
                    <?php else: ?>
                    <div class="activity-list">
                        <?php foreach ($recentQuestions as $q):
                            $diff = strtolower($q['difficulty']);
                            $diffColor = match($diff) {
                                'easy' => '#10b981',
                                'medium' => '#f59e0b',
                                'hard' => '#ef4444',
                                default => '#6366f1'
                            };
                            $ts = date('d M Y, h:i A', strtotime($q['created_at']));
                        ?>
                        <div class="activity-item">
                            <div class="activity-avatar" style="background:<?php echo $diffColor; ?>; font-size:12px; font-weight:700;">
                                <?php echo strtoupper(substr($diff, 0, 1)); ?>
                            </div>
                            <div class="activity-info">
                                <div class="activity-name text-truncate" style="max-width: 400px;"><?php echo htmlspecialchars($q['question_text']); ?></div>
                                <div class="activity-meta"><?php echo htmlspecialchars($q['subject_name'] ?? 'Unknown Subject'); ?></div>
                            </div>
                            <time class="activity-time relative-time"
                                  datetime="<?php echo date('c', strtotime($q['created_at'])); ?>"
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
    &copy; <?php echo date('Y'); ?> ExamShield LPS &mdash; Faculty Portal. All rights reserved.
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

    /* ─── Difficulty Chart ─── */
    const ctx = document.getElementById('diffChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($diffChartLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($diffChartData); ?>,
                    backgroundColor: [
                        'rgba(16,185,129,0.85)', // Easy
                        'rgba(245,158,11,0.85)', // Medium
                        'rgba(239,68,68,0.85)'   // Hard
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { position: 'right', labels: { font: { family:'Poppins', size:12 }, usePointStyle:true, padding:20 } }
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