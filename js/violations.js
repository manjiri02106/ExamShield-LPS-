// Violations and Logging Module

// Initialize global state namespace if not already defined
window.examState = window.examState || {};
window.examState.violationsCount = 0;
window.examState.logs = [];

/**
 * Log a new violation, update UI counts, and optionally show warning modal.
 * @param {string} violationName - Name/description of the violation
 * @param {boolean} triggerWarningModal - Whether to trigger the warning alert modal
 */
window.logViolation = function(violationName, triggerWarningModal = true) {
    // Only log if the exam has started and is not yet submitted
    if (!window.examState.isExamStarted || window.examState.isExamSubmitted) {
        return;
    }

    const now = new Date();
    const timeString = now.toTimeString().split(' ')[0]; // Returns "HH:MM:SS"
    
    // Add violation to state
    window.examState.violationsCount++;
    window.examState.logs.unshift({
        time: timeString,
        text: violationName
    });

    // Update UI counters
    const countElement = document.getElementById('violation-count');
    if (countElement) {
        countElement.textContent = window.examState.violationsCount;
    }

    // Refresh logs in UI
    window.renderLogs();

    // Trigger Warning Modal if requested
    if (triggerWarningModal) {
        const warningMessageElement = document.getElementById('warning-modal-message');
        if (warningMessageElement) {
            warningMessageElement.textContent = `Violation detected: ${violationName}. Please continue the examination honestly.`;
        }
        
        // Show Warning Modal via Bootstrap API
        const warningModalEl = document.getElementById('warningModal');
        if (warningModalEl) {
            const modalInstance = bootstrap.Modal.getInstance(warningModalEl) || new bootstrap.Modal(warningModalEl);
            modalInstance.show();
        }
    }
};

/**
 * Renders the log history list inside the proctoring panel.
 */
window.renderLogs = function() {
    const logContainer = document.getElementById('log-container');
    if (!logContainer) return;

    logContainer.innerHTML = '';
    window.examState.logs.forEach(log => {
        const logItem = document.createElement('div');
        logItem.className = 'log-item';
        
        const timeSpan = document.createElement('span');
        timeSpan.className = 'time';
        timeSpan.textContent = log.time;
        
        const textSpan = document.createElement('span');
        textSpan.textContent = log.text;

        logItem.appendChild(timeSpan);
        logItem.appendChild(textSpan);
        logContainer.appendChild(logItem);
    });
};
