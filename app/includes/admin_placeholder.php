<?php
/**
 * admin_placeholder.php
 * Include this file to render a professional "Coming Soon" placeholder page.
 *
 * Required variables before including:
 *   $pageTitle       string   e.g. "Departments"
 *   $pageSubtitle    string   e.g. "Manage academic departments"
 *   $pageIcon        string   Bootstrap icon class e.g. "bi-diagram-3"
 *   $iconColorClass  string   adm-tables icon class e.g. "icon-indigo"
 *   $breadcrumbs     array    [['label'=>'Dashboard','url'=>'../dashboard/admin.php'], ...]
 *   $quickLinks      array    [['label'=>'Add Item','url'=>'create.php','icon'=>'bi-plus'], ...]
 *   $comingSoonMsg   string   Optional override message
 *
 * Then include sidebar_admin, navbar, header BEFORE including this file.
 */
$comingSoonMsg = $comingSoonMsg ?? 'This module is currently under development. Check back soon.';
?>

<link rel="stylesheet" href="../../assets/css/admin_tables.css">
<div class="content-wrapper">

    <!-- ── Page Header ── -->
    <div class="adm-header">
        <div class="adm-breadcrumb">
            <i class="bi bi-house-fill"></i>
            <?php foreach ($breadcrumbs as $i => $crumb): ?>
                <?php if ($i > 0): ?><i class="bi bi-chevron-right"></i><?php endif; ?>
                <?php if (isset($crumb['url'])): ?>
                    <a href="<?php echo htmlspecialchars($crumb['url']); ?>"><?php echo htmlspecialchars($crumb['label']); ?></a>
                <?php else: ?>
                    <span><?php echo htmlspecialchars($crumb['label']); ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="adm-title-row">
            <div>
                <h1 class="adm-page-title"><?php echo htmlspecialchars($pageTitle); ?></h1>
                <p class="adm-page-subtitle"><?php echo htmlspecialchars($pageSubtitle); ?></p>
            </div>
            <?php if (!empty($quickLinks)): ?>
            <div class="d-flex gap-2 flex-wrap">
                <?php foreach ($quickLinks as $ql): ?>
                <a href="<?php echo htmlspecialchars($ql['url']); ?>" class="btn-adm btn-adm-primary">
                    <i class="bi <?php echo $ql['icon']; ?>"></i>
                    <?php echo htmlspecialchars($ql['label']); ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ── Coming Soon Card ── -->
    <div class="adm-table-card" style="max-width:600px;margin:40px auto;">
        <div style="padding:56px 40px;text-align:center;">
            <div style="
                width:88px;height:88px;border-radius:22px;
                background:rgba(99,102,241,.1);
                display:flex;align-items:center;justify-content:center;
                margin:0 auto 22px;font-size:36px;color:#6366f1;">
                <i class="bi <?php echo htmlspecialchars($pageIcon); ?>"></i>
            </div>
            <h2 style="font-size:20px;font-weight:700;color:#0f172a;margin-bottom:8px;">
                <?php echo htmlspecialchars($pageTitle); ?> Module
            </h2>
            <p style="font-size:13.5px;color:#64748b;margin-bottom:28px;line-height:1.7;">
                <?php echo htmlspecialchars($comingSoonMsg); ?>
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <?php if (!empty($quickLinks)): ?>
                <?php foreach ($quickLinks as $ql): ?>
                <a href="<?php echo htmlspecialchars($ql['url']); ?>" class="btn-adm btn-adm-primary">
                    <i class="bi <?php echo $ql['icon']; ?>"></i>
                    <?php echo htmlspecialchars($ql['label']); ?>
                </a>
                <?php endforeach; ?>
                <?php endif; ?>
                <a href="../dashboard/admin.php" class="btn-adm btn-adm-secondary">
                    <i class="bi bi-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>
    </div>

</div><!-- /content-wrapper -->

</div><!-- /main-content -->
<footer class="dashboard-footer" style="margin-left:var(--sidebar-width);transition:margin-left .25s ease;">
    &copy; <?php echo date('Y'); ?> ExamShield LPS &mdash; Admin Panel. All rights reserved.
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateFooter() {
    const f = document.querySelector('.dashboard-footer');
    if (f) f.style.marginLeft = window.innerWidth <= 768 ? '0' :
        getComputedStyle(document.documentElement).getPropertyValue('--sidebar-width').trim();
}
updateFooter(); window.addEventListener('resize', updateFooter);
</script>
</body></html>
