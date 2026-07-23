<?php
require_once "../middleware/auth.php";
require_once "../middleware/role.php";
require_once "../config/database.php";

// Only ADMIN role has access to this module
checkRole("ADMIN");

require_once "../includes/header.php";
require_once "../includes/sidebar_admin.php";
require_once "../includes/navbar.php";
?>

<link rel="stylesheet" href="../../assets/css/admin_tables.css">

<div class="content-wrapper">

    <!-- ── Page Header ── -->
    <div class="adm-header">
        <div class="adm-breadcrumb">
            <i class="bi bi-house-fill"></i>
            <i class="bi bi-chevron-right"></i>
            <a href="../dashboard/admin.php">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <span>Institute</span>
        </div>
        <div class="adm-title-row">
            <div>
                <h1 class="adm-page-title">Institute</h1>
                <p class="adm-page-subtitle">Institute Management</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <span class="badge" style="background: rgba(99, 102, 241, 0.1); color: #6366f1; padding: 8px 16px; font-size: 14px; border-radius: 8px; border: 1px solid rgba(99, 102, 241, 0.2);">
                    <i class="bi bi-clock-history me-1"></i> Coming Soon
                </span>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- ── Placeholder Information Card ── -->
            <div class="adm-table-card mb-4">
                <div style="padding: 60px 40px; text-align: center;">
                    
                    <!-- Icon / Illustration -->
                    <div style="
                        width: 100px; height: 100px; border-radius: 28px;
                        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(56, 189, 248, 0.1) 100%);
                        display: flex; align-items: center; justify-content: center;
                        margin: 0 auto 30px; font-size: 44px; color: #6366f1;
                        box-shadow: inset 0 0 0 1px rgba(99, 102, 241, 0.2);
                        position: relative;
                    ">
                        <i class="bi bi-building"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" style="font-size: 12px; padding: 6px 10px; border: 2px solid white;">
                            Dev
                        </span>
                    </div>

                    <h2 style="font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 12px; letter-spacing: -0.5px;">
                        Institute Module Under Development
                    </h2>
                    
                    <p style="font-size: 15px; color: #64748b; margin-bottom: 30px; line-height: 1.7; max-width: 500px; margin-left: auto; margin-right: auto;">
                        This module is currently under development by another team member. The interface, forms, and database architecture will be fully integrated once their development is completed.
                    </p>

                    <a href="../dashboard/admin.php" class="btn-adm btn-adm-secondary">
                        <i class="bi bi-arrow-left"></i> Return to Dashboard
                    </a>
                </div>
            </div>

            <!-- ── Integration Status Card ── -->
            <div class="section-card">
                <div class="section-card-header" style="border-bottom: 1px solid #e2e8f0; padding-bottom: 16px; margin-bottom: 20px;">
                    <h2 class="section-card-title">
                        <i class="bi bi-list-check"></i>
                        Integration Status
                    </h2>
                </div>
                <div class="section-card-body" style="padding: 0 10px 10px;">
                    
                    <ul class="list-unstyled mb-0" style="font-size: 14.5px; color: #475569;">
                        <li class="mb-3 d-flex align-items-center gap-3">
                            <div style="width:28px;height:28px;border-radius:50%;background:rgba(16,185,129,0.15);color:#10b981;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-check-lg" style="font-size:16px;"></i>
                            </div>
                            <span style="font-weight:500;color:#0f172a;">Admin navigation integrated</span>
                        </li>
                        
                        <li class="mb-3 d-flex align-items-center gap-3">
                            <div style="width:28px;height:28px;border-radius:50%;background:rgba(16,185,129,0.15);color:#10b981;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-check-lg" style="font-size:16px;"></i>
                            </div>
                            <span style="font-weight:500;color:#0f172a;">Access control ready</span>
                        </li>

                        <li class="mb-3 d-flex align-items-center gap-3">
                            <div style="width:28px;height:28px;border-radius:50%;background:rgba(16,185,129,0.15);color:#10b981;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-check-lg" style="font-size:16px;"></i>
                            </div>
                            <span style="font-weight:500;color:#0f172a;">Placeholder page ready</span>
                        </li>

                        <li class="mb-3 d-flex align-items-center gap-3">
                            <div style="width:28px;height:28px;border-radius:50%;background:rgba(245,158,11,0.15);color:#f59e0b;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-hourglass-split" style="font-size:14px;"></i>
                            </div>
                            <span style="color:#64748b;">CRUD module pending</span>
                        </li>

                        <li class="mb-3 d-flex align-items-center gap-3">
                            <div style="width:28px;height:28px;border-radius:50%;background:rgba(245,158,11,0.15);color:#f59e0b;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-hourglass-split" style="font-size:14px;"></i>
                            </div>
                            <span style="color:#64748b;">Database integration pending</span>
                        </li>

                        <li class="d-flex align-items-center gap-3">
                            <div style="width:28px;height:28px;border-radius:50%;background:rgba(245,158,11,0.15);color:#f59e0b;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-hourglass-split" style="font-size:14px;"></i>
                            </div>
                            <span style="color:#64748b;">UI implementation pending</span>
                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </div>

</div><!-- /content-wrapper -->

<!-- ── Footer ── -->
</div><!-- /main-content -->

<footer class="dashboard-footer" style="margin-left:var(--sidebar-width);transition:margin-left .25s ease;">
    &copy; <?php echo date('Y'); ?> ExamShield LPS &mdash; Admin Panel. All rights reserved.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
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
