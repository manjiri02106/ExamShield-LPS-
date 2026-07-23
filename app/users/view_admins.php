<?php

require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

checkRole("SUPER_ADMIN");

/*
|--------------------------------------------------------------------------
| Filters & Search (GET params)
|--------------------------------------------------------------------------
*/
$search     = trim($_GET['search']   ?? '');
$filterRole = trim($_GET['role']     ?? '');
$filterDept = trim($_GET['dept']     ?? '');
$filterStat = trim($_GET['status']   ?? '');

// Pagination
$perPage    = 10;
$page       = max(1, (int)($_GET['page'] ?? 1));
$offset     = ($page - 1) * $perPage;

/*
|--------------------------------------------------------------------------
| Build Query
|--------------------------------------------------------------------------
*/
$where  = [];
$params = [];
$types  = '';

if ($search !== '') {
    $where[]  = "(users.name LIKE ? OR users.email LIKE ?)";
    $like     = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $types   .= 'ss';
}
if ($filterRole !== '') {
    $where[]  = "users.role = ?";
    $params[] = $filterRole;
    $types   .= 's';
}
if ($filterDept !== '') {
    $where[]  = "users.department_id = ?";
    $params[] = (int)$filterDept;
    $types   .= 'i';
}
if ($filterStat !== '') {
    $where[]  = "users.status = ?";
    $params[] = $filterStat;
    $types   .= 's';
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Count total matching rows
$countSQL  = "SELECT COUNT(*) AS total FROM users LEFT JOIN departments ON users.department_id = departments.id $whereSQL";
$totalRows = 0;
if ($types) {
    $cs = $conn->prepare($countSQL);
    $cs->bind_param($types, ...$params);
    $cs->execute();
    $totalRows = (int)$cs->get_result()->fetch_assoc()['total'];
} else {
    $cr = $conn->query($countSQL);
    if ($cr) $totalRows = (int)$cr->fetch_assoc()['total'];
}
$totalPages = max(1, ceil($totalRows / $perPage));

// Fetch rows
$sql = "SELECT users.id, users.name, users.email, users.role, users.status,
               users.created_at, departments.department_name
        FROM users
        LEFT JOIN departments ON users.department_id = departments.id
        $whereSQL
        ORDER BY users.created_at DESC
        LIMIT ? OFFSET ?";

$fetchParams = $params;
$fetchTypes  = $types . 'ii';
$fetchParams[] = $perPage;
$fetchParams[] = $offset;

$users = [];
$stmt  = $conn->prepare($sql);
$stmt->bind_param($fetchTypes, ...$fetchParams);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

/*
|--------------------------------------------------------------------------
| Summary Counts
|--------------------------------------------------------------------------
*/
function roleCnt(mysqli $c, string $r): int {
    $s = $c->prepare("SELECT COUNT(*) AS t FROM users WHERE role=?");
    if (!$s) return 0;
    $s->bind_param('s', $r);
    $s->execute();
    return (int)$s->get_result()->fetch_assoc()['t'];
}
$cntTotal = (int)$conn->query("SELECT COUNT(*) AS t FROM users")->fetch_assoc()['t'];
$cntSA    = roleCnt($conn, 'SUPER_ADMIN');
$cntAdm   = roleCnt($conn, 'ADMIN');
$cntFac   = roleCnt($conn, 'FACULTY');
$cntStu   = roleCnt($conn, 'STUDENT');

/*
|--------------------------------------------------------------------------
| Departments for filter dropdown
|--------------------------------------------------------------------------
*/
$depts = [];
$dr    = $conn->query("SELECT id, department_name FROM departments ORDER BY department_name ASC");
if ($dr) { while ($d = $dr->fetch_assoc()) $depts[] = $d; }

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/
function roleLabel(string $r): string {
    return match($r) {
        'SUPER_ADMIN' => 'Super Admin',
        'ADMIN'       => 'Admin',
        'FACULTY'     => 'Faculty',
        'STUDENT'     => 'Student',
        default       => htmlspecialchars($r),
    };
}
function roleClass(string $r): string {
    return 'role-' . strtolower($r);
}
function avatarClass(string $r): string {
    return match($r) {
        'SUPER_ADMIN' => 'avatar-sa',
        'ADMIN'       => 'avatar-admin',
        'FACULTY'     => 'avatar-faculty',
        default       => 'avatar-student',
    };
}

// Build query string helper (for pagination links)
function pageUrl(int $p): string {
    $q = $_GET;
    $q['page'] = $p;
    return '?' . http_build_query($q);
}

require_once "../includes/header.php";
require_once "../includes/sidebar_super_admin.php";
require_once "../includes/navbar.php";
?>

<!-- extra CSS for this page -->
<link rel="stylesheet" href="../../assets/css/view_admins.css">

<div class="content-wrapper">

    <!-- ── Page Header ── -->
    <div class="users-page-header">
        <div>
            <h1 class="users-page-title">Manage Users</h1>
            <div class="users-breadcrumb">
                <i class="bi bi-house-fill"></i>
                <a href="../dashboard/super_admin.php">Dashboard</a>
                <i class="bi bi-chevron-right"></i>
                <span>Users</span>
                <i class="bi bi-chevron-right"></i>
                <span>Manage Users</span>
            </div>
        </div>
        <a href="create_admin.php" class="btn-add-user" id="btnAddUser">
            <i class="bi bi-person-plus-fill"></i> Add User
        </a>
    </div>

    <!-- ── Summary Cards ── -->
    <div class="row g-3 mb-4">

        <div class="col-xl col-md-4 col-6">
            <div class="users-stat-card">
                <div class="users-stat-icon stat-icon-total"><i class="bi bi-people-fill"></i></div>
                <div class="users-stat-info">
                    <div class="users-stat-value"><?php echo $cntTotal; ?></div>
                    <div class="users-stat-label">Total Users</div>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-4 col-6">
            <div class="users-stat-card">
                <div class="users-stat-icon stat-icon-sa"><i class="bi bi-shield-lock-fill"></i></div>
                <div class="users-stat-info">
                    <div class="users-stat-value"><?php echo $cntSA; ?></div>
                    <div class="users-stat-label">Super Admins</div>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-4 col-6">
            <div class="users-stat-card">
                <div class="users-stat-icon stat-icon-admin"><i class="bi bi-person-badge-fill"></i></div>
                <div class="users-stat-info">
                    <div class="users-stat-value"><?php echo $cntAdm; ?></div>
                    <div class="users-stat-label">Admins</div>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-6 col-6">
            <div class="users-stat-card">
                <div class="users-stat-icon stat-icon-faculty"><i class="bi bi-mortarboard-fill"></i></div>
                <div class="users-stat-info">
                    <div class="users-stat-value"><?php echo $cntFac; ?></div>
                    <div class="users-stat-label">Faculty</div>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-6 col-12">
            <div class="users-stat-card">
                <div class="users-stat-icon stat-icon-student"><i class="bi bi-person-fill"></i></div>
                <div class="users-stat-info">
                    <div class="users-stat-value"><?php echo $cntStu; ?></div>
                    <div class="users-stat-label">Students</div>
                </div>
            </div>
        </div>

    </div><!-- /stat cards -->

    <!-- ── Filter Toolbar ── -->
    <div class="filter-card">
        <form method="GET" id="filterForm">
            <div class="filter-row">

                <!-- Search -->
                <div class="filter-group" style="flex:2;min-width:200px;">
                    <label class="filter-label">Search</label>
                    <div class="filter-search-wrap">
                        <i class="bi bi-search search-icon"></i>
                        <input
                            type="text"
                            name="search"
                            class="filter-input"
                            placeholder="Name or email…"
                            value="<?php echo htmlspecialchars($search); ?>"
                            id="searchInput"
                            autocomplete="off">
                    </div>
                </div>

                <!-- Role -->
                <div class="filter-group">
                    <label class="filter-label">Role</label>
                    <select name="role" class="filter-select" id="filterRole">
                        <option value="">All Roles</option>
                        <?php foreach (['SUPER_ADMIN'=>'Super Admin','ADMIN'=>'Admin','FACULTY'=>'Faculty','STUDENT'=>'Student'] as $val=>$lbl): ?>
                        <option value="<?php echo $val; ?>" <?php echo $filterRole===$val?'selected':''; ?>>
                            <?php echo $lbl; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Department -->
                <div class="filter-group">
                    <label class="filter-label">Department</label>
                    <select name="dept" class="filter-select" id="filterDept">
                        <option value="">All Departments</option>
                        <?php foreach ($depts as $d): ?>
                        <option value="<?php echo $d['id']; ?>" <?php echo $filterDept==(string)$d['id']?'selected':''; ?>>
                            <?php echo htmlspecialchars($d['department_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Status -->
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-select" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="ACTIVE"   <?php echo $filterStat==='ACTIVE'  ?'selected':''; ?>>Active</option>
                        <option value="INACTIVE" <?php echo $filterStat==='INACTIVE'?'selected':''; ?>>Inactive</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="filter-group" style="flex:0;min-width:auto;">
                    <label class="filter-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-add-user" style="height:38px;padding:0 16px;box-shadow:none;" id="btnApplyFilter">
                            <i class="bi bi-funnel-fill"></i> Filter
                        </button>
                        <a href="view_admins.php" class="btn-filter-reset" id="btnResetFilter">
                            <i class="bi bi-x-lg"></i> Reset
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div><!-- /filter toolbar -->

    <!-- ── Users Table ── -->
    <div class="table-card">

        <div class="table-card-header">
            <h2 class="table-card-title">
                <i class="bi bi-table"></i>
                Users List
            </h2>
            <span class="table-result-count">
                <?php echo $totalRows; ?> result<?php echo $totalRows!=1?'s':''; ?> found
            </span>
        </div>

        <div class="users-table-wrap">

            <?php if (empty($users)): ?>

            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-state-icon"><i class="bi bi-people"></i></div>
                <div class="empty-state-title">No Users Found</div>
                <div class="empty-state-text">
                    <?php echo ($search||$filterRole||$filterDept||$filterStat)
                        ? 'No users match your current filters. Try adjusting your search.'
                        : 'There are no users in the system yet.'; ?>
                </div>
                <?php if ($search||$filterRole||$filterDept||$filterStat): ?>
                <a href="view_admins.php" class="btn-filter-reset d-inline-flex" style="margin:0 auto;">
                    <i class="bi bi-arrow-counterclockwise"></i> Clear Filters
                </a>
                <?php endif; ?>
            </div>

            <?php else: ?>

            <table class="users-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $rowNum = $offset + 1;
                foreach ($users as $u):
                    $isSelf    = ($u['id'] == $_SESSION['user_id']);
                    $initial   = strtoupper(substr($u['name'], 0, 1));
                    $aClass    = avatarClass($u['role']);
                    $rClass    = roleClass($u['role']);
                    $rLabel    = roleLabel($u['role']);
                    $sClass    = strtolower($u['status']) === 'active' ? 'status-active' : 'status-inactive';
                    $dept      = $u['department_name'] ?? null;
                    $joined    = date('d M Y', strtotime($u['created_at']));
                    $isoDate   = date('c', strtotime($u['created_at']));
                    $statusLbl = ucfirst(strtolower($u['status']));
                ?>
                <tr>
                    <!-- # -->
                    <td style="color:var(--text-secondary);font-size:12px;"><?php echo $rowNum++; ?></td>

                    <!-- User -->
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar <?php echo $aClass; ?>"><?php echo $initial; ?></div>
                            <div>
                                <div class="user-name"><?php echo htmlspecialchars($u['name']); ?></div>
                                <div class="user-id">ID #<?php echo $u['id']; ?></div>
                            </div>
                        </div>
                    </td>

                    <!-- Email -->
                    <td class="user-email"><?php echo htmlspecialchars($u['email']); ?></td>

                    <!-- Role -->
                    <td>
                        <span class="role-badge <?php echo $rClass; ?>"><?php echo $rLabel; ?></span>
                    </td>

                    <!-- Department -->
                    <td>
                        <?php if ($dept): ?>
                            <span class="dept-name"><?php echo htmlspecialchars($dept); ?></span>
                        <?php else: ?>
                            <span class="dept-none">—</span>
                        <?php endif; ?>
                    </td>

                    <!-- Status -->
                    <td>
                        <span class="status-badge <?php echo $sClass; ?>"><?php echo $statusLbl; ?></span>
                    </td>

                    <!-- Joined -->
                    <td>
                        <time class="date-cell relative-time"
                              datetime="<?php echo $isoDate; ?>"
                              title="<?php echo $joined; ?>">
                            <?php echo $joined; ?>
                        </time>
                    </td>

                    <!-- Actions -->
                    <td>
                        <?php if ($isSelf): ?>
                            <span class="current-user-tag"><i class="bi bi-person-check"></i> You</span>
                        <?php else: ?>
                        <div class="action-btns">

                            <!-- View -->
                            <button type="button"
                                class="btn-action btn-view"
                                title="View User"
                                data-bs-toggle="modal"
                                data-bs-target="#viewModal"
                                data-id="<?php echo $u['id']; ?>"
                                data-name="<?php echo htmlspecialchars($u['name'], ENT_QUOTES); ?>"
                                data-email="<?php echo htmlspecialchars($u['email'], ENT_QUOTES); ?>"
                                data-role="<?php echo $rLabel; ?>"
                                data-dept="<?php echo htmlspecialchars($dept ?? '—', ENT_QUOTES); ?>"
                                data-status="<?php echo $statusLbl; ?>"
                                data-joined="<?php echo $joined; ?>"
                                data-avatar-class="<?php echo $aClass; ?>"
                                data-initial="<?php echo $initial; ?>">
                                <i class="bi bi-eye"></i>
                            </button>

                            <!-- Edit (only for ADMIN role — existing route) -->
                            <?php if ($u['role'] === 'ADMIN'): ?>
                            <a href="edit_admin.php?id=<?php echo $u['id']; ?>"
                               class="btn-action btn-edit"
                               title="Edit User">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <?php endif; ?>

                            <!-- Toggle Status (ADMIN only — existing route) -->
                            <?php if ($u['role'] === 'ADMIN'): ?>
                            <a href="toggle_admin_status.php?id=<?php echo $u['id']; ?>"
                               class="btn-action btn-toggle"
                               title="<?php echo $u['status']==='ACTIVE'?'Deactivate':'Activate'; ?>"
                               onclick="return confirm('<?php echo $u['status']==='ACTIVE'?'Deactivate':'Activate'; ?> this user?')">
                                <i class="bi bi-toggle-<?php echo $u['status']==='ACTIVE'?'on':'off'; ?>"></i>
                            </a>
                            <?php endif; ?>

                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php endif; ?>

        </div><!-- /table-wrap -->

        <!-- ── Pagination ── -->
        <?php if ($totalPages > 1): ?>
        <div class="table-footer">

            <div class="pagination-info">
                Showing <strong><?php echo min($offset+1,$totalRows); ?></strong>–<strong><?php echo min($offset+$perPage,$totalRows); ?></strong> of <strong><?php echo $totalRows; ?></strong> users
            </div>

            <ul class="pagination-nav">

                <li>
                    <a href="<?php echo pageUrl(1); ?>"
                       class="page-btn <?php echo $page<=1?'disabled':''; ?>"
                       title="First">
                        <i class="bi bi-chevron-double-left"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo pageUrl($page-1); ?>"
                       class="page-btn <?php echo $page<=1?'disabled':''; ?>"
                       title="Previous">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>

                <?php
                $range  = 2;
                $start  = max(1, $page - $range);
                $end    = min($totalPages, $page + $range);
                if ($start > 1): ?>
                    <li><a href="<?php echo pageUrl(1); ?>" class="page-btn">1</a></li>
                    <?php if ($start > 2): ?><li><span class="page-btn disabled">…</span></li><?php endif; ?>
                <?php endif;
                for ($i = $start; $i <= $end; $i++): ?>
                    <li>
                        <a href="<?php echo pageUrl($i); ?>"
                           class="page-btn <?php echo $i===$page?'active':''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor;
                if ($end < $totalPages): ?>
                    <?php if ($end < $totalPages - 1): ?><li><span class="page-btn disabled">…</span></li><?php endif; ?>
                    <li><a href="<?php echo pageUrl($totalPages); ?>" class="page-btn"><?php echo $totalPages; ?></a></li>
                <?php endif; ?>

                <li>
                    <a href="<?php echo pageUrl($page+1); ?>"
                       class="page-btn <?php echo $page>=$totalPages?'disabled':''; ?>"
                       title="Next">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo pageUrl($totalPages); ?>"
                       class="page-btn <?php echo $page>=$totalPages?'disabled':''; ?>"
                       title="Last">
                        <i class="bi bi-chevron-double-right"></i>
                    </a>
                </li>

            </ul>

        </div>
        <?php endif; ?>

    </div><!-- /table-card -->

</div><!-- /content-wrapper -->

<!-- ================================================================
     VIEW USER MODAL
     ================================================================ -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">
                    <i class="bi bi-person-circle"></i> User Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="modal-user-avatar" id="viewModalAvatar">&nbsp;</div>
                    <div style="font-size:16px;font-weight:700;color:var(--text-primary);" id="viewModalName"></div>
                    <div style="font-size:12px;color:var(--text-secondary);margin-top:3px;" id="viewModalEmail"></div>
                </div>

                <div class="user-detail-row">
                    <span class="user-detail-label">Role</span>
                    <span class="user-detail-value" id="viewModalRole"></span>
                </div>
                <div class="user-detail-row">
                    <span class="user-detail-label">Department</span>
                    <span class="user-detail-value" id="viewModalDept"></span>
                </div>
                <div class="user-detail-row">
                    <span class="user-detail-label">Status</span>
                    <span class="user-detail-value" id="viewModalStatus"></span>
                </div>
                <div class="user-detail-row">
                    <span class="user-detail-label">Joined</span>
                    <span class="user-detail-value" id="viewModalJoined"></span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Close
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ================================================================
     FOOTER + SCRIPTS
     ================================================================ -->
</div><!-- /main-content -->

<footer class="dashboard-footer" style="margin-left:var(--sidebar-width);transition:margin-left .25s ease;">
    &copy; <?php echo date('Y'); ?> ExamShield LPS &mdash; Learning &amp; Proctoring Suite. All rights reserved.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

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

    /* ─── View Modal ─── */
    const viewModal = document.getElementById('viewModal');
    if (viewModal) {
        viewModal.addEventListener('show.bs.modal', function (e) {
            const btn = e.relatedTarget;
            const avatarClass = btn.dataset.avatarClass;
            const initial     = btn.dataset.initial;
            const role        = btn.dataset.role;
            const status      = btn.dataset.status;

            // Avatar
            const av = document.getElementById('viewModalAvatar');
            av.className = 'modal-user-avatar ' + avatarClass;
            av.textContent = initial;

            // Fields
            document.getElementById('viewModalName').textContent   = btn.dataset.name;
            document.getElementById('viewModalEmail').textContent  = btn.dataset.email;
            document.getElementById('viewModalRole').textContent   = role;
            document.getElementById('viewModalDept').textContent   = btn.dataset.dept;
            document.getElementById('viewModalJoined').textContent = btn.dataset.joined;

            // Status badge
            const sc = status.toLowerCase() === 'active' ? 'status-active' : 'status-inactive';
            document.getElementById('viewModalStatus').innerHTML =
                `<span class="status-badge ${sc}">${status}</span>`;
        });
    }

    /* ─── Responsive Footer Margin ─── */
    function updateFooterMargin() {
        const footer = document.querySelector('.dashboard-footer');
        if (!footer) return;
        footer.style.marginLeft = window.innerWidth <= 768 ? '0' :
            getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width').trim();
    }
    updateFooterMargin();
    window.addEventListener('resize', updateFooterMargin);

    /* ─── Auto-submit filter form on select change ─── */
    ['filterRole','filterDept','filterStatus'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) el.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    /* ─── Search debounce ─── */
    let searchTimer;
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                document.getElementById('filterForm').submit();
            }, 500);
        });
    }

});
</script>

</body>
</html>