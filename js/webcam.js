// Webcam and Microphone Proctoring Module

window.examState = window.examState || {};
window.examState.cameraActive = false;
window.examState.micActive = false;

window.proctoringMedia = {
    stream: null,

    /**
     * Request permissions and initiate video/audio capture.
     */
    startCameraAndMic: async function() {
        let cameraGranted = false;
        let micGranted = false;

        // 1. Try to request both video and audio in one prompt
        try {
            this.stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            cameraGranted = true;
            micGranted = true;

            const videoEl = document.getElementById('webcam-preview');
            if (videoEl) {
                videoEl.srcObject = this.stream;
                videoEl.play().catch(err => console.warn("Video auto-play failed:", err));
            }

            // Hide webcam placeholder
            const placeholder = document.getElementById('camera-placeholder');
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        } catch (err) {
            console.warn("Joint media access request failed. Trying separate device requests...", err);

            // 2. Try camera only
            try {
                const videoStream = await navigator.mediaDevices.getUserMedia({ video: true });
                cameraGranted = true;
                this.stream = videoStream;

                const videoEl = document.getElementById('webcam-preview');
                if (videoEl) {
                    videoEl.srcObject = videoStream;
                    videoEl.play().catch(err => console.warn("Video auto-play failed:", err));
                }

                const placeholder = document.getElementById('camera-placeholder');
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            } catch (camErr) {
                console.warn("Camera permission denied:", camErr);
                cameraGranted = false;
            }

            // 3. Try microphone only
            try {
                const audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
                micGranted = true;

                if (!this.stream) {
                    this.stream = audioStream;
                } else {
                    // Combine audio track into existing video stream
                    audioStream.getAudioTracks().forEach(track => this.stream.addTrack(track));
                }
            } catch (micErr) {
                console.warn("Microphone permission denied:", micErr);
                micGranted = false;
            }
        }

        // Update state and UI
        this.updateCameraUI(cameraGranted);
        this.updateMicUI(micGranted);

        // If exam is running, log initial denials as violations
        if (window.examState.isExamStarted) {
            if (!cameraGranted) {
                window.logViolation("Camera Disabled", false); // Don't block screen on start
            }
            if (!micGranted) {
                window.logViolation("Microphone Permission Denied", false);
            }
        }
    },

    /**
     * Update camera status indicators.
     */
    updateCameraUI: function(active) {
        window.examState.cameraActive = active;
        const camEl = document.getElementById('camera-status');
        if (camEl) {
            if (active) {
                camEl.textContent = 'Active';
                camEl.className = 'value text-success';
            } else {
                camEl.textContent = 'Disabled';
                camEl.className = 'value text-danger';
            }
        }
    },

    /**
     * Update microphone status indicators.
     */
    updateMicUI: function(active) {
        window.examState.micActive = active;
        const micEl = document.getElementById('mic-status');
        if (micEl) {
            if (active) {
                micEl.textContent = 'Active';
                micEl.className = 'value text-success';
            } else {
                micEl.textContent = 'Denied';
                micEl.className = 'value text-danger';
            }
        }
    },

    /**
     * Stop all active media tracks.
     */
    stop: function() {
        if (this.stream) {
            this.stream.getTracks().forEach(track => {
                track.stop();
            });
            this.stream = null;
        }
        
        // Show placeholder again
        const placeholder = document.getElementById('camera-placeholder');
        if (placeholder) {
            placeholder.style.display = 'flex';
        }
        const videoEl = document.getElementById('webcam-preview');
        if (videoEl) {
            videoEl.srcObject = null;
        }
    }
};
