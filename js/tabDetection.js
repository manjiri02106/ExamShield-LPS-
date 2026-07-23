// Tab Switching and Window Blur Detection Module

window.examState = window.examState || {};
window.examState.tabSwitchesCount = 0;

window.tabDetectionManager = {
    lastSwitchTime: 0,

    init: function() {
        const handleTabSwitch = () => {
            // Only trigger if exam is actively running and not submitted
            if (!window.examState.isExamStarted || window.examState.isExamSubmitted) {
                return;
            }

            const now = Date.now();
            // Prevent double triggers within 1.5 seconds (common when visibilitychange & blur fire together)
            if (now - this.lastSwitchTime < 1500) {
                return;
            }
            this.lastSwitchTime = now;

            window.examState.tabSwitchesCount++;

            // Update UI switch counter
            const tabCountEl = document.getElementById('tab-switch-count');
            if (tabCountEl) {
                tabCountEl.textContent = window.examState.tabSwitchesCount;
            }

            // Log tab switch violation
            if (typeof window.logViolation === 'function') {
                window.logViolation("Tab Switched");
            }

            // Check if 3 switches limit reached
            if (window.examState.tabSwitchesCount >= 3) {
                setTimeout(() => {
                    alert("Maximum of 3 tab switches exceeded. Exam will be automatically submitted.");
                    if (typeof window.submitExam === 'function') {
                        window.submitExam(true);
                    }
                }, 100);
            }
        };

        // Detect tab change (HTML5 Page Visibility API)
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden') {
                handleTabSwitch();
            }
        });

        // Detect window focus loss (e.g. Alt+Tab, click off window)
        window.addEventListener('blur', () => {
            handleTabSwitch();
        });
    }
};
