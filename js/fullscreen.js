// Fullscreen Enforcement Module

window.examState = window.examState || {};
window.examState.fullscreenActive = false;

window.fullscreenManager = {
    /**
     * Request fullscreen mode on the document body/root element.
     */
    enter: function() {
        const elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen().catch(err => {
                console.warn(`Error attempting to enable full-screen mode: ${err.message}`);
            });
        } else if (elem.webkitRequestFullscreen) { /* Safari */
            elem.webkitRequestFullscreen().catch(err => {
                console.warn(`Error attempting to enable full-screen mode: ${err.message}`);
            });
        } else if (elem.msRequestFullscreen) { /* IE11 */
            elem.msRequestFullscreen().catch(err => {
                console.warn(`Error attempting to enable full-screen mode: ${err.message}`);
            });
        }
    },

    /**
     * Set up the fullscreen change listener.
     */
    init: function() {
        const handleFullscreenChange = () => {
            const isFullscreenNow = !!(document.fullscreenElement || 
                                       document.webkitFullscreenElement || 
                                       document.mozFullScreenElement || 
                                       document.msFullscreenElement);
            
            window.examState.fullscreenActive = isFullscreenNow;
            
            // Update UI status card
            const statusVal = document.getElementById('fullscreen-status');
            if (statusVal) {
                if (isFullscreenNow) {
                    statusVal.textContent = 'Active';
                    statusVal.className = 'value text-success';
                } else {
                    statusVal.textContent = 'Exited';
                    statusVal.className = 'value text-danger';
                }
            }

            // If exam has started and is not submitted, and user exits, trigger a violation
            if (window.examState.isExamStarted && !window.examState.isExamSubmitted && !isFullscreenNow) {
                if (typeof window.logViolation === 'function') {
                    window.logViolation("Fullscreen Exited");
                }
            }
        };

        document.addEventListener('fullscreenchange', handleFullscreenChange);
        document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
        document.addEventListener('mozfullscreenchange', handleFullscreenChange);
        document.addEventListener('MSFullscreenChange', handleFullscreenChange);
    }
};
