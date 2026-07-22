// Exam Countdown Timer Module

window.examState = window.examState || {};
window.examState.timerRemaining = 3600; // 60 minutes in seconds
window.examState.timerInterval = null;
window.examState.totalDuration = 3600;

/**
 * Start the countdown timer.
 * @param {number} durationSeconds - The total duration in seconds.
 */
window.startTimer = function(durationSeconds = 3600) {
    window.examState.timerRemaining = durationSeconds;
    window.examState.totalDuration = durationSeconds;
    
    // Clear any existing timer
    if (window.examState.timerInterval) {
        clearInterval(window.examState.timerInterval);
    }

    // Initial draw
    window.updateTimerUI();

    window.examState.timerInterval = setInterval(() => {
        if (window.examState.isExamSubmitted) {
            clearInterval(window.examState.timerInterval);
            return;
        }

        window.examState.timerRemaining--;

        // Update UI
        window.updateTimerUI();

        if (window.examState.timerRemaining <= 0) {
            clearInterval(window.examState.timerInterval);
            window.handleTimerExpired();
        }
    }, 1000);
};

/**
 * Stop the countdown timer.
 */
window.stopTimer = function() {
    if (window.examState.timerInterval) {
        clearInterval(window.examState.timerInterval);
    }
};

/**
 * Update the countdown display in HH:MM:SS format in the UI.
 */
window.updateTimerUI = function() {
    const timerElement = document.getElementById('countdown-timer');
    if (!timerElement) return;

    const remaining = window.examState.timerRemaining;
    const hours = Math.floor(remaining / 3600);
    const minutes = Math.floor((remaining % 3600) / 60);
    const seconds = remaining % 60;

    const formattedHours = String(hours).padStart(2, '0');
    const formattedMinutes = String(minutes).padStart(2, '0');
    const formattedSeconds = String(seconds).padStart(2, '0');

    timerElement.textContent = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
};

/**
 * Triggered when the timer runs down to 00:00:00.
 */
window.handleTimerExpired = function() {
    // Prevent multiple submissions
    if (window.examState.isExamSubmitted) return;

    // Show timer expiration popup / toast / modal alert
    alert("Time is over. Exam submitted successfully.");

    // Submit the exam
    if (typeof window.submitExam === 'function') {
        window.submitExam(true); // pass true for auto-submit
    }
};

/**
 * Get formatted string representing the time taken by the user.
 * @returns {string} - Formatted MM:SS time taken
 */
window.getTimeTakenString = function() {
    const timeTakenSeconds = window.examState.totalDuration - window.examState.timerRemaining;
    const mins = Math.floor(timeTakenSeconds / 60);
    const secs = timeTakenSeconds % 60;
    return `${String(mins).padStart(2, '0')}m ${String(secs).padStart(2, '0')}s`;
};
