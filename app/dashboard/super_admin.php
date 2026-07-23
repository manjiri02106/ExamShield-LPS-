<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

checkRole("SUPER_ADMIN");

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

// Institutes (placeholder until module exists)
$totalInstitutes = 1;

// Departments – real count
$totalDepartments = 0;
$q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM departments");
if ($q) {
    $totalDepartments = (int) mysqli_fetch_assoc($q)['total'];
}

// Users – real count
$totalUsers = 0;
$q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
if ($q) {
    $totalUsers = (int) mysqli_fetch_assoc($q)['total'];
}

// Exams Today – placeholder until exams module exists
$todayExams = 0;

/*
|--------------------------------------------------------------------------
| User Distribution by Role
|--------------------------------------------------------------------------
*/
function roleCount(mysqli $conn, string $role): int {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role = ?");
    if (!$stmt) return 0;
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $result = $stmt->get_result();
    return (int) $result->fetch_assoc()['total'];
}

$superAdmins = roleCount($conn, "SUPER_ADMIN");
$admins      = roleCount($conn, "ADMIN");
$faculty     = roleCount($conn, "FACULTY");
$students    = roleCount($conn, "STUDENT");

/*
|--------------------------------------------------------------------------
| Recent Activities – Latest Registered Users
|--------------------------------------------------------------------------
*/
$recentUsers = [];
$rq = mysqli_query($conn, "
    SELECT name, role, email, created_at
    FROM users
    ORDER BY created_at DESC
    LIMIT 6
");
if ($rq) {
    while ($row = mysqli_fetch_assoc($rq)) {
        $recentUsers[] = $row;
    }
}

require_once "../includes/header.php";
require_once "../includes/sidebar_super_admin.php";
require_once "../includes/navbar.php";
?>

<!-- ================================================================
     CONTENT WRAPPER
     ================================================================ -->
<div class="content-wrapper">

    <!-- ── Page Header ── -->
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Overview</p>
    </div>

    <!-- ── Stat Cards ── -->
    <div class="row g-4 mb-4">

        <!-- Institutes -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon blue">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <span class="stat-trend neu">
                        <i class="bi bi-dash"></i> Active
                    </span>
                </div>
                <div>
                    <div class="stat-value"><?php echo number_format($totalInstitutes); ?></div>
                    <div class="stat-label">Institutes</div>
                </div>
                <div class="stat-card-footer">
                    <a href="#" class="stat-footer-link" id="cardInstitutesLink">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Departments -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon green">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <span class="stat-trend up">
                        <i class="bi bi-arrow-up"></i> Live
                    </span>
                </div>
                <div>
                    <div class="stat-value"><?php echo number_format($totalDepartments); ?></div>
                    <div class="stat-label">Departments</div>
                </div>
                <div class="stat-card-footer">
                    <a href="../department/view_departments.php" class="stat-footer-link" id="cardDepartmentsLink">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon red">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <span class="stat-trend up">
                        <i class="bi bi-arrow-up"></i> Total
                    </span>
                </div>
                <div>
                    <div class="stat-value"><?php echo number_format($totalUsers); ?></div>
                    <div class="stat-label">Registered Users</div>
                </div>
                <div class="stat-card-footer">
                    <a href="../users/view_admins.php" class="stat-footer-link" id="cardUsersLink">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Exams Today -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon amber">
                        <i class="bi bi-journal-check"></i>
                    </div>
                    <span class="stat-trend neu">
                        <i class="bi bi-clock"></i> Today
                    </span>
                </div>
                <div>
                    <div class="stat-value"><?php echo number_format($todayExams); ?></div>
                    <div class="stat-label">Exams Today</div>
                </div>
                <div class="stat-card-footer">
                    <a href="#" class="stat-footer-link" id="cardExamsLink">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div><!-- /row stat cards -->

    <!-- ── Charts & Activity ── -->
    <div class="row g-4">

        <!-- User Distribution Chart -->
        <div class="col-lg-5">
            <div class="section-card">

                <div class="section-card-header">
                    <h2 class="section-card-title">
                        <i class="bi bi-pie-chart-fill"></i>
                        User Distribution
                    </h2>
                    <span class="section-card-badge"><?php echo $totalUsers; ?> Total</span>
                </div>

                <div class="section-card-body">

                    <div class="chart-container">
                        <canvas id="userDistributionChart"></canvas>
                    </div>

                    <!-- Legend -->
                    <div class="row g-2 mt-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8fafc;">
                                <div style="width:10px;height:10px;border-radius:50%;background:#6366f1;flex-shrink:0;"></div>
                                <div>
                                    <div style="font-size:11px;color:#64748b;">Super Admin</div>
                                    <div style="font-size:15px;font-weight:700;color:#0f172a;"><?php echo $superAdmins; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8fafc;">
                                <div style="width:10px;height:10px;border-radius:50%;background:#10b981;flex-shrink:0;"></div>
                                <div>
                                    <div style="font-size:11px;color:#64748b;">Admin</div>
                                    <div style="font-size:15px;font-weight:700;color:#0f172a;"><?php echo $admins; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8fafc;">
                                <div style="width:10px;height:10px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></div>
                                <div>
                                    <div style="font-size:11px;color:#64748b;">Faculty</div>
                                    <div style="font-size:15px;font-weight:700;color:#0f172a;"><?php echo $faculty; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8fafc;">
                                <div style="width:10px;height:10px;border-radius:50%;background:#ef4444;flex-shrink:0;"></div>
                                <div>
                                    <div style="font-size:11px;color:#64748b;">Student</div>
                                    <div style="font-size:15px;font-weight:700;color:#0f172a;"><?php echo $students; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-lg-7">
            <div class="section-card">

                <div class="section-card-header">
                    <h2 class="section-card-title">
                        <i class="bi bi-activity"></i>
                        Recent Activities
                    </h2>
                    <a href="../users/view_admins.php" class="stat-footer-link" id="viewAllUsersLink">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="section-card-body" style="padding-top:8px;padding-bottom:8px;">

                    <?php if (empty($recentUsers)): ?>
                        <div class="text-center py-5" style="color:var(--text-secondary);">
                            <i class="bi bi-inbox" style="font-size:40px;opacity:.4;"></i>
                            <p class="mt-2 mb-0" style="font-size:13px;">No users found.</p>
                        </div>
                    <?php else: ?>

                        <ul class="activity-list">
                            <?php foreach ($recentUsers as $user):
                                $roleLower = strtolower($user['role']);
                                $roleDisplay = match($user['role']) {
                                    'SUPER_ADMIN' => 'Super Admin',
                                    'ADMIN'       => 'Admin',
                                    'FACULTY'     => 'Faculty',
                                    'STUDENT'     => 'Student',
                                    default       => htmlspecialchars($user['role']),
                                };
                                $initial      = strtoupper(substr($user['name'], 0, 1));
                                $isoDate      = date('c', strtotime($user['created_at']));
                                $dateReadable = date('d M Y, g:i A', strtotime($user['created_at']));
                            ?>
                            <li class="activity-item">

                                <div class="activity-avatar <?php echo $roleLower; ?>">
                                    <?php echo $initial; ?>
                                </div>

                                <div class="activity-info">
                                    <div class="activity-name"><?php echo htmlspecialchars($user['name']); ?></div>
                                    <div class="activity-meta">
                                        <span class="activity-role-badge role-<?php echo $roleLower; ?>">
                                            <?php echo $roleDisplay; ?>
                                        </span>
                                        <span style="opacity:.5;">·</span>
                                        <?php echo htmlspecialchars($user['email']); ?>
                                    </div>
                                </div>

                                <div class="activity-date">
                                    <time
                                        class="relative-time"
                                        datetime="<?php echo $isoDate; ?>"
                                        title="<?php echo $dateReadable; ?>">
                                        <?php echo $dateReadable; ?>
                                    </time>
                                </div>

                            </li>
                            <?php endforeach; ?>
                        </ul>

                    <?php endif; ?>

                </div>

            </div>
        </div>

    </div><!-- /row charts & activity -->

</div><!-- /content-wrapper -->

<!-- ================================================================
     FOOTER
     ================================================================ -->
</div><!-- /main-content — opened in sidebar_super_admin.php -->

<footer class="dashboard-footer" style="margin-left:var(--sidebar-width);transition:margin-left .25s ease;">
    &copy; <?php echo date('Y'); ?> ExamShield LPS &mdash; Learning &amp; Proctoring Suite. All rights reserved.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ─── User Distribution Doughnut ─── */
    const ctx = document.getElementById('userDistributionChart');
    if (ctx) {
        const data = {
            superAdmin : <?php echo $superAdmins; ?>,
            admin      : <?php echo $admins; ?>,
            faculty    : <?php echo $faculty; ?>,
            student    : <?php echo $students; ?>
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Super Admin', 'Admin', 'Faculty', 'Student'],
                datasets: [{
                    data: [data.superAdmin, data.admin, data.faculty, data.student],
                    backgroundColor: [
                        '#6366f1',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const pct   = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                return ` ${context.label}: ${context.raw} (${pct}%)`;
                            }
                        },
                        backgroundColor: 'rgba(15,23,42,0.9)',
                        titleFont: { family: 'Poppins', size: 12, weight: '600' },
                        bodyFont:  { family: 'Poppins', size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: true
                    }
                }
            }
        });
    }

    /* ─── Relative Timestamps ─── */
    function timeAgo(dateStr) {
        const now  = new Date();
        const past = new Date(dateStr);
        const diff = Math.floor((now - past) / 1000);
        if (isNaN(diff) || diff < 0)  return past.toLocaleDateString();
        if (diff < 60)                return 'Just now';
        if (diff < 3600)              return Math.floor(diff / 60) + 'm ago';
        if (diff < 86400)             return Math.floor(diff / 3600) + 'h ago';
        if (diff < 2592000)           return Math.floor(diff / 86400) + 'd ago';
        if (diff < 31536000)          return Math.floor(diff / 2592000) + 'mo ago';
        return Math.floor(diff / 31536000) + 'y ago';
    }

    document.querySelectorAll('time.relative-time').forEach(function (el) {
        el.textContent = timeAgo(el.getAttribute('datetime'));
    });

    /* ─── Responsive footer margin ─── */
    function updateFooterMargin() {
        const footer   = document.querySelector('.dashboard-footer');
        const sidebar  = document.getElementById('mainSidebar');
        if (footer && sidebar) {
            if (window.innerWidth <= 768) {
                footer.style.marginLeft = '0';
            } else {
                footer.style.marginLeft = getComputedStyle(document.documentElement)
                    .getPropertyValue('--sidebar-width').trim();
            }
        }
    }
    updateFooterMargin();
    window.addEventListener('resize', updateFooterMargin);

});
</script>

</body>
</html>
