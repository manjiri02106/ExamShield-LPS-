<?php
require_once "../middleware/auth.php";
require_once "../config/database.php";

// Always use session user ID — no URL param
$userId = (int)$_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Handle Profile Update (POST)
|--------------------------------------------------------------------------
*/
$successMsg = '';
$errorMsg   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'update_profile') {
        $newName  = trim($_POST['name']  ?? '');
        $newPhone = trim($_POST['phone'] ?? '');
        $newAddr  = trim($_POST['address'] ?? '');

        if (empty($newName)) {
            $errorMsg = 'Name cannot be empty.';
        } else {
            $upd = $conn->prepare("UPDATE users SET name=? WHERE id=?");
            $upd->bind_param('si', $newName, $userId);
            if ($upd->execute()) {
                $_SESSION['name'] = $newName;
                $successMsg = 'Profile updated successfully.';
            } else {
                $errorMsg = 'Failed to update profile. Please try again.';
            }
        }
    }

    // Avatar upload
    if ($_POST['action'] === 'upload_avatar' && isset($_FILES['avatar'])) {
        $file     = $_FILES['avatar'];
        $allowed  = ['image/jpeg','image/png','image/gif','image/webp'];
        $maxSize  = 2 * 1024 * 1024; // 2 MB

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errorMsg = 'Upload error. Please try again.';
        } elseif (!in_array($file['type'], $allowed)) {
            $errorMsg = 'Only JPG, PNG, GIF, or WEBP images are allowed.';
        } elseif ($file['size'] > $maxSize) {
            $errorMsg = 'Image must be smaller than 2 MB.';
        } else {
            $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;
            $destDir  = __DIR__ . '/../../uploads/avatars/';
            if (!is_dir($destDir)) mkdir($destDir, 0755, true);
            $dest = $destDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $dest)) {
                // Remove old avatar if stored (column doesn't exist yet — we store in session only)
                $_SESSION['avatar'] = 'uploads/avatars/' . $filename;
                $successMsg = 'Profile picture updated.';
            } else {
                $errorMsg = 'Failed to save image.';
            }
        }
    }
}

/*
|--------------------------------------------------------------------------
| Fetch User Data
|--------------------------------------------------------------------------
*/
$stmt = $conn->prepare(
    "SELECT u.id, u.name, u.email, u.role, u.status, u.created_at,
            d.department_name
     FROM   users u
     LEFT JOIN departments d ON u.department_id = d.id
     WHERE  u.id = ?
     LIMIT  1"
);
$stmt->bind_param('i', $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    session_destroy();
    header('Location: ../auth/login.php');
    exit();
}

/*
|--------------------------------------------------------------------------
| Role Helpers
|--------------------------------------------------------------------------
*/
$role      = $user['role'];
$roleLabel = match($role) {
    'SUPER_ADMIN' => 'Super Admin',
    'ADMIN'       => 'Admin',
    'FACULTY'     => 'Faculty',
    'STUDENT'     => 'Student',
    default       => htmlspecialchars($role),
};
$roleClass = 'pf-role-' . strtolower($role);
$avatarBgClass = match($role) {
    'SUPER_ADMIN' => 'avatar-sa',
    'ADMIN'       => 'avatar-admin',
    'FACULTY'     => 'avatar-faculty',
    default       => 'avatar-student',
};

$initial    = strtoupper(substr($user['name'], 0, 1));
$joinedDate = date('d M Y', strtotime($user['created_at']));
$statusCls  = strtolower($user['status']) === 'active' ? 'pf-status-active' : 'pf-status-inactive';
$statusLbl  = ucfirst(strtolower($user['status']));
$dept       = $user['department_name'] ?? '—';

// Avatar (session-stored path, no DB column)
$avatarPath = $_SESSION['avatar'] ?? null;
$avatarUrl  = $avatarPath ? '../../' . $avatarPath : null;

// Dashboard link per role
$dashLink = match($role) {
    'SUPER_ADMIN' => '../dashboard/super_admin.php',
    'ADMIN'       => '../dashboard/admin.php',
    'FACULTY'     => '../dashboard/faculty.php',
    default       => '../dashboard/student.php',
};

// Sidebar per role
$sidebarFile = match($role) {
    'SUPER_ADMIN' => '../includes/sidebar_super_admin.php',
    'ADMIN'       => '../includes/sidebar_admin.php',
    'FACULTY'     => '../includes/sidebar_faculty.php',
    default       => '../includes/sidebar_student.php',
};

// Wrapper div opened by sidebar: super_admin uses main-content, others use content-wrapper
$wrapperClass = ($role === 'SUPER_ADMIN') ? 'main-content' : 'content-wrapper';

require_once "../includes/header.php";
require_once $sidebarFile;
require_once "../includes/navbar.php";
?>

<link rel="stylesheet" href="../../assets/css/profile.css">

<div class="content-wrapper">

    <!-- ── Alerts ── -->
    <?php if ($successMsg): ?>
    <div class="pf-alert pf-alert-success">
        <i class="bi bi-check-circle-fill"></i>
        <div><?php echo htmlspecialchars($successMsg); ?></div>
    </div>
    <?php endif; ?>
    <?php if ($errorMsg): ?>
    <div class="pf-alert pf-alert-danger">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div><?php echo htmlspecialchars($errorMsg); ?></div>
    </div>
    <?php endif; ?>

    <!-- ── Page Header ── -->
    <div class="pf-page-header">
        <div class="pf-breadcrumb">
            <i class="bi bi-house-fill"></i>
            <a href="<?php echo $dashLink; ?>">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <span>Profile</span>
        </div>
        <h1 class="pf-page-title">My Profile</h1>
        <p class="pf-page-subtitle">Manage your personal information and account settings.</p>
    </div>

    <!-- ── Two-Column Layout ── -->
    <div class="pf-layout">

        <!-- ══════════════════════════
             LEFT: Profile Card
             ══════════════════════════ -->
        <div>
            <div class="pf-card">

                <!-- Banner -->
                <div class="pf-card-banner"></div>

                <!-- Avatar + Name -->
                <div class="pf-avatar-wrap">

                    <div class="pf-avatar-ring"
                         title="Click to change photo"
                         onclick="document.getElementById('avatarFileInput').click();">
                        <?php if ($avatarUrl): ?>
                            <img src="<?php echo htmlspecialchars($avatarUrl); ?>"
                                 alt="Avatar" id="avatarPreviewImg">
                        <?php else: ?>
                            <span id="avatarInitial"><?php echo $initial; ?></span>
                        <?php endif; ?>
                        <div class="pf-avatar-overlay">
                            <i class="bi bi-camera-fill"></i>
                        </div>
                    </div>

                    <!-- Hidden upload form -->
                    <form method="POST" enctype="multipart/form-data" id="avatarUploadForm" style="display:none;">
                        <input type="hidden" name="action" value="upload_avatar">
                        <input type="file" name="avatar" id="avatarFileInput"
                               accept="image/jpeg,image/png,image/gif,image/webp">
                    </form>

                    <div class="pf-name"><?php echo htmlspecialchars($user['name']); ?></div>
                    <div class="pf-email-sub"><?php echo htmlspecialchars($user['email']); ?></div>

                    <span class="pf-role-badge <?php echo $roleClass; ?>">
                        <i class="bi bi-shield-check"></i>
                        <?php echo $roleLabel; ?>
                    </span>

                    <span class="pf-status-badge <?php echo $statusCls; ?>">
                        <?php echo $statusLbl; ?>
                    </span>

                </div><!-- /avatar-wrap -->

                <div class="pf-info-divider"></div>

                <!-- Quick info -->
                <div class="pf-info-list">

                    <div class="pf-info-row">
                        <span class="pf-info-label"><i class="bi bi-diagram-3"></i> Department</span>
                        <span class="pf-info-value <?php echo $dept==='—'?'muted':''; ?>">
                            <?php echo htmlspecialchars($dept); ?>
                        </span>
                    </div>

                    <div class="pf-info-row">
                        <span class="pf-info-label"><i class="bi bi-calendar3"></i> Joined</span>
                        <span class="pf-info-value"><?php echo $joinedDate; ?></span>
                    </div>

                    <div class="pf-info-row">
                        <span class="pf-info-label"><i class="bi bi-person-badge"></i> Role</span>
                        <span class="pf-info-value"><?php echo $roleLabel; ?></span>
                    </div>

                    <div class="pf-info-row">
                        <span class="pf-info-label"><i class="bi bi-hash"></i> User ID</span>
                        <span class="pf-info-value">#<?php echo $user['id']; ?></span>
                    </div>

                </div>

                <div class="pf-info-divider" style="margin-top:0;"></div>

                <!-- Quick actions -->
                <div class="pf-quick-actions">

                    <button type="button"
                            class="btn-pf-action"
                            data-bs-toggle="modal"
                            data-bs-target="#editProfileModal"
                            id="btnOpenEditModal">
                        <i class="bi bi-pencil-square"></i>
                        Edit Profile
                    </button>

                    <a href="../auth/change_password.php" class="btn-pf-action">
                        <i class="bi bi-key"></i>
                        Change Password
                    </a>

                    <a href="../auth/logout.php" class="btn-pf-action danger"
                       onclick="return confirm('Are you sure you want to logout?');">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </a>

                </div>

            </div><!-- /pf-card -->
        </div>

        <!-- ══════════════════════════
             RIGHT: Detail Sections
             ══════════════════════════ -->
        <div>

            <!-- Section 1: Personal Information -->
            <div class="pf-section-card">
                <div class="pf-section-header">
                    <h2 class="pf-section-title">
                        <i class="bi bi-person-lines-fill"></i>
                        Personal Information
                    </h2>
                    <button type="button"
                            class="btn-pf-edit"
                            data-bs-toggle="modal"
                            data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
                <div class="pf-section-body">
                    <div class="pf-fields-grid">

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-person"></i> Full Name</div>
                            <div class="pf-field-value"><?php echo htmlspecialchars($user['name']); ?></div>
                        </div>

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-envelope"></i> Email Address</div>
                            <div class="pf-field-value"><?php echo htmlspecialchars($user['email']); ?></div>
                        </div>

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-telephone"></i> Phone Number</div>
                            <div class="pf-field-value muted">Not provided</div>
                        </div>

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-diagram-3"></i> Department</div>
                            <div class="pf-field-value <?php echo $dept==='—'?'muted':''; ?>">
                                <?php echo htmlspecialchars($dept); ?>
                            </div>
                        </div>

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-gender-ambiguous"></i> Gender</div>
                            <div class="pf-field-value muted">Not provided</div>
                        </div>

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-cake"></i> Date of Birth</div>
                            <div class="pf-field-value muted">Not provided</div>
                        </div>

                        <div class="pf-field" style="grid-column:1/-1;border-right:none;padding-right:0;">
                            <div class="pf-field-label"><i class="bi bi-geo-alt"></i> Address</div>
                            <div class="pf-field-value muted">Not provided</div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Section 2: Account Information -->
            <div class="pf-section-card">
                <div class="pf-section-header">
                    <h2 class="pf-section-title">
                        <i class="bi bi-shield-lock"></i>
                        Account Information
                    </h2>
                </div>
                <div class="pf-section-body">
                    <div class="pf-fields-grid">

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-person-badge"></i> Role</div>
                            <div class="pf-field-value">
                                <span class="pf-role-badge <?php echo $roleClass; ?>" style="margin-top:0;display:inline-flex;">
                                    <?php echo $roleLabel; ?>
                                </span>
                            </div>
                        </div>

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-at"></i> Username / Email</div>
                            <div class="pf-field-value"><?php echo htmlspecialchars($user['email']); ?></div>
                        </div>

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-activity"></i> Account Status</div>
                            <div class="pf-field-value">
                                <span class="pf-status-badge <?php echo $statusCls; ?>" style="margin-top:0;display:inline-flex;">
                                    <?php echo $statusLbl; ?>
                                </span>
                            </div>
                        </div>

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-calendar-plus"></i> Created On</div>
                            <div class="pf-field-value"><?php echo $joinedDate; ?></div>
                        </div>

                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-hash"></i> User ID</div>
                            <div class="pf-field-value">#<?php echo $user['id']; ?></div>
                        </div>

                        <!-- Role-specific field -->
                        <div class="pf-field">
                            <div class="pf-field-label">
                                <i class="bi bi-info-circle"></i>
                                <?php echo match($role) {
                                    'SUPER_ADMIN' => 'System Permissions',
                                    'ADMIN'       => 'Managed Users',
                                    'FACULTY'     => 'Assigned Exams',
                                    default       => 'Enrollment',
                                }; ?>
                            </div>
                            <div class="pf-field-value muted">
                                <?php echo match($role) {
                                    'SUPER_ADMIN' => 'Full system access',
                                    'ADMIN'       => 'View in Users section',
                                    'FACULTY'     => 'View in Exams section',
                                    default       => 'View in Results section',
                                }; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Section 3: Security -->
            <div class="pf-section-card">
                <div class="pf-section-header">
                    <h2 class="pf-section-title">
                        <i class="bi bi-lock-fill"></i>
                        Security
                    </h2>
                </div>
                <div class="pf-section-body">

                    <div class="pf-fields-grid" style="margin-bottom:20px;">
                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-key"></i> Password</div>
                            <div class="pf-field-value password-mask">••••••••••</div>
                        </div>
                        <div class="pf-field">
                            <div class="pf-field-label"><i class="bi bi-clock-history"></i> Last Changed</div>
                            <div class="pf-field-value muted">Unknown</div>
                        </div>
                    </div>

                    <div class="pf-security-actions">
                        <a href="../auth/change_password.php" class="btn-pf-primary" id="btnChangePassword">
                            <i class="bi bi-key-fill"></i>
                            Change Password
                        </a>
                        <button type="button"
                                class="btn-pf-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#editProfileModal"
                                id="btnUpdateProfile">
                            <i class="bi bi-pencil-square"></i>
                            Update Profile
                        </button>
                    </div>

                </div>
            </div>

        </div><!-- /right column -->

    </div><!-- /pf-layout -->

</div><!-- /content-wrapper -->

<!-- ================================================================
     EDIT PROFILE MODAL
     ================================================================ -->
<div class="modal fade" id="editProfileModal" tabindex="-1"
     aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="bi bi-pencil-square"></i> Edit Profile
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" enctype="multipart/form-data" id="editProfileForm">
                <input type="hidden" name="action" value="update_profile">

                <div class="modal-body">

                    <!-- Avatar Upload -->
                    <div class="pf-modal-form-group">
                        <label class="pf-modal-label">
                            <i class="bi bi-camera"></i> Profile Photo
                        </label>
                        <div class="pf-avatar-upload-area"
                             onclick="document.getElementById('modalAvatarInput').click();">
                            <div class="pf-avatar-preview" id="modalAvatarPreview">
                                <?php if ($avatarUrl): ?>
                                    <img src="<?php echo htmlspecialchars($avatarUrl); ?>"
                                         id="modalAvatarImg" alt="Avatar">
                                <?php else: ?>
                                    <span><?php echo $initial; ?></span>
                                <?php endif; ?>
                            </div>
                            <div style="font-size:13px;font-weight:600;color:var(--text-secondary);">
                                Click to upload photo
                            </div>
                            <div class="pf-upload-hint">JPG, PNG, GIF or WEBP · Max 2 MB</div>
                        </div>
                        <input type="file" name="avatar" id="modalAvatarInput"
                               accept="image/jpeg,image/png,image/gif,image/webp"
                               style="display:none;">
                    </div>

                    <!-- Name -->
                    <div class="pf-modal-form-group">
                        <label class="pf-modal-label" for="editName">
                            <i class="bi bi-person"></i> Full Name <span style="color:var(--danger);">*</span>
                        </label>
                        <input type="text"
                               id="editName"
                               name="name"
                               class="pf-modal-input"
                               value="<?php echo htmlspecialchars($user['name']); ?>"
                               required
                               maxlength="100">
                    </div>

                    <!-- Email (read-only) -->
                    <div class="pf-modal-form-group">
                        <label class="pf-modal-label" for="editEmail">
                            <i class="bi bi-envelope"></i> Email Address
                        </label>
                        <input type="email"
                               id="editEmail"
                               class="pf-modal-input"
                               value="<?php echo htmlspecialchars($user['email']); ?>"
                               disabled
                               title="Email cannot be changed here">
                        <div style="font-size:11px;color:var(--text-secondary);margin-top:4px;">
                            <i class="bi bi-info-circle"></i> Email cannot be changed here.
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="pf-modal-form-group">
                        <label class="pf-modal-label" for="editPhone">
                            <i class="bi bi-telephone"></i> Phone Number
                        </label>
                        <input type="tel"
                               id="editPhone"
                               name="phone"
                               class="pf-modal-input"
                               placeholder="+91 00000 00000"
                               maxlength="20">
                    </div>

                    <!-- Address -->
                    <div class="pf-modal-form-group">
                        <label class="pf-modal-label" for="editAddress">
                            <i class="bi bi-geo-alt"></i> Address
                        </label>
                        <textarea id="editAddress"
                                  name="address"
                                  class="pf-modal-input"
                                  style="height:70px;padding-top:10px;resize:none;"
                                  placeholder="Your address…"
                                  maxlength="300"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn-pf-primary" id="btnSaveProfile">
                        <i class="bi bi-check-lg"></i> Save Changes
                    </button>
                    <button type="button" class="btn-pf-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Cancel
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- ================================================================
     FOOTER + SCRIPTS
     ================================================================ -->
</div><!-- /main-content (opened by sidebar_super_admin) -->

<footer class="dashboard-footer"
        style="margin-left:var(--sidebar-width);transition:margin-left .25s ease;">
    &copy; <?php echo date('Y'); ?> ExamShield LPS &mdash; Learning &amp; Proctoring Suite. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ─── Avatar click-to-upload (left card) ─── */
    const avatarFileInput = document.getElementById('avatarFileInput');
    if (avatarFileInput) {
        avatarFileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                document.getElementById('avatarUploadForm').submit();
            }
        });
    }

    /* ─── Avatar preview in modal ─── */
    const modalAvatarInput   = document.getElementById('modalAvatarInput');
    const modalAvatarPreview = document.getElementById('modalAvatarPreview');

    if (modalAvatarInput) {
        modalAvatarInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    modalAvatarPreview.innerHTML =
                        '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;">';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    /* ─── Responsive footer margin ─── */
    function updateFooterMargin() {
        const footer = document.querySelector('.dashboard-footer');
        if (!footer) return;
        footer.style.marginLeft = window.innerWidth <= 768 ? '0' :
            getComputedStyle(document.documentElement)
                .getPropertyValue('--sidebar-width').trim();
    }
    updateFooterMargin();
    window.addEventListener('resize', updateFooterMargin);

});
</script>

</body>
</html>
