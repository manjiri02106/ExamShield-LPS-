// Central Application Controller

window.examState = window.examState || {};
window.examState.isExamStarted = false;
window.examState.isExamSubmitted = false;
window.examState.currentQuestionIndex = 0;
window.examState.answers = {}; // Map of { questionIndex: selectedOptionText }
window.examState.status = {};  // Map of { questionIndex: 'unvisited' | 'answered' | 'marked' }

// 15 MCQ Questions on Web Development
const questions = [
    {
        id: 1,
        text: "What does HTML stand for?",
        options: [
            "Hyper Text Markup Language",
            "Home Tool Markup Language",
            "Hyperlinks and Text Markup Language",
            "Hyperlink Text Management Language"
        ]
    },
    {
        id: 2,
        text: "Which CSS property is used to control the text size of an element?",
        options: [
            "font-style",
            "text-size",
            "font-size",
            "text-style"
        ]
    },
    {
        id: 3,
        text: "Which of the following is NOT a JavaScript library or framework?",
        options: [
            "React",
            "Django",
            "Vue",
            "Angular"
        ]
    },
    {
        id: 4,
        text: "How do you write 'Hello World' in an alert box using JavaScript?",
        options: [
            "msg('Hello World');",
            "alertBox('Hello World');",
            "alert('Hello World');",
            "console.log('Hello World');"
        ]
    },
    {
        id: 5,
        text: "What is the correct HTML element for inserting a line break?",
        options: [
            "<break>",
            "<lb>",
            "<br>",
            "<newline>"
        ]
    },
    {
        id: 6,
        text: "Which CSS selector matches elements with a specific class name?",
        options: [
            "#classname",
            ".classname",
            "*classname",
            "classname:"
        ]
    },
    {
        id: 7,
        text: "In modern JavaScript (ES6+), which keyword is used to declare a block-scoped constant variable?",
        options: [
            "var",
            "let",
            "const",
            "define"
        ]
    },
    {
        id: 8,
        text: "What does HTTP stand for?",
        options: [
            "Hypertext Transfer Protocol",
            "Hypertext Transfer Procedure",
            "High Transfer Text Protocol",
            "Hyperlink Text Technical Protocol"
        ]
    },
    {
        id: 9,
        text: "Which HTML element is used to define an internal style sheet?",
        options: [
            "<css>",
            "<style>",
            "<script>",
            "<link>"
        ]
    },
    {
        id: 10,
        text: "Which operator is used to compare both value and type in JavaScript?",
        options: [
            "==",
            "===",
            "=",
            "!=="
        ]
    },
    {
        id: 11,
        text: "What is the default port number for standard unsecured HTTP traffic?",
        options: [
            "443",
            "80",
            "21",
            "8080"
        ]
    },
    {
        id: 12,
        text: "Which SQL statement is used to retrieve data from a database?",
        options: [
            "GET",
            "OPEN",
            "SELECT",
            "EXTRACT"
        ]
    },
    {
        id: 13,
        text: "Which layout model allows design of responsive grids without floats or positioning?",
        options: [
            "Grid Layout (CSS Grid)",
            "Relative Box Mode",
            "Inline-Block Layout",
            "Absolute Grid"
        ]
    },
    {
        id: 14,
        text: "Which command is used to initialize a new local git repository?",
        options: [
            "git create",
            "git start",
            "git setup",
            "git init"
        ]
    },
    {
        id: 15,
        text: "In software development, what does API stand for?",
        options: [
            "Automated Protocol Interaction",
            "Application Programming Interface",
            "Applied Program Integration",
            "App Partition Indicator"
        ]
    }
];

window.examState.questions = questions;

// Initialize index layout elements
document.addEventListener('DOMContentLoaded', () => {
    // Generate Left Sidebar Buttons
    const gridContainer = document.getElementById('sidebar-question-grid');
    if (gridContainer) {
        questions.forEach((q, idx) => {
            // Set default status to unvisited
            window.examState.status[idx] = 'unvisited';

            const btn = document.createElement('button');
            btn.id = `qbtn-${idx}`;
            btn.className = 'question-btn q-not-visited';
            btn.textContent = idx + 1;
            btn.addEventListener('click', () => {
                if (window.examState.isExamStarted && !window.examState.isExamSubmitted) {
                    window.navigateToQuestion(idx);
                }
            });
            gridContainer.appendChild(btn);
        });
    }

    // Set up start exam trigger
    const startBtn = document.getElementById('start-exam-btn');
    if (startBtn) {
        startBtn.addEventListener('click', window.startExam);
    }

    // Set up warning modal confirmation
    const reenterFullscreenBtn = document.getElementById('warning-modal-reenter-btn');
    if (reenterFullscreenBtn) {
        reenterFullscreenBtn.addEventListener('click', () => {
            if (window.fullscreenManager && typeof window.fullscreenManager.enter === 'function') {
                window.fullscreenManager.enter();
            }
        });
    }

    // Set up manual submit trigger
    const submitBtn = document.getElementById('submit-exam-header-btn');
    if (submitBtn) {
        submitBtn.addEventListener('click', () => {
            if (confirm("Are you sure you want to submit the exam?")) {
                window.submitExam(false);
            }
        });
    }

    // Bind Navigation Buttons
    const prevBtn = document.getElementById('btn-prev');
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (window.examState.currentQuestionIndex > 0) {
                window.navigateToQuestion(window.examState.currentQuestionIndex - 1);
            }
        });
    }

    const nextBtn = document.getElementById('btn-next');
    if (nextBtn) {
        nextBtn.addEventListener('click', window.saveAndNext);
    }

    const reviewBtn = document.getElementById('btn-review');
    if (reviewBtn) {
        reviewBtn.addEventListener('click', window.markForReview);
    }

    const clearBtn = document.getElementById('btn-clear');
    if (clearBtn) {
        clearBtn.addEventListener('click', window.clearResponse);
    }

    // Modal reload/unload warning handlers
    window.addEventListener('beforeunload', (e) => {
        if (window.examState.isExamStarted && !window.examState.isExamSubmitted) {
            const message = "You have an ongoing exam. Leaving now will submit it automatically.";
            
            // Auto submit on unload/close
            window.submitExam(true);

            e.returnValue = message;
            return message;
        }
    });
});

/**
 * Transition UI from Setup screen to Live Exam
 */
window.startExam = function() {
    window.examState.isExamStarted = true;

    // Start timer (60 minutes = 3600 seconds)
    window.startTimer(3600);

    // Request Fullscreen
    if (window.fullscreenManager) {
        window.fullscreenManager.enter();
        window.fullscreenManager.init();
    }

    // Request Webcam and Microphone
    if (window.proctoringMedia) {
        window.proctoringMedia.startCameraAndMic();
    }

    // Request tab switches
    if (window.tabDetectionManager) {
        window.tabDetectionManager.init();
    }

    // Fade out overlay
    const overlay = document.getElementById('setup-overlay');
    if (overlay) {
        overlay.style.opacity = '0';
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 500);
    }

    // Redraw status bar
    const statusVal = document.getElementById('fullscreen-status');
    if (statusVal) {
        statusVal.textContent = 'Active';
        statusVal.className = 'value text-success';
    }

    // Render the first question
    window.navigateToQuestion(0);
};

/**
 * Navigate to a specific question by index
 * @param {number} index - Index of the question to load
 */
window.navigateToQuestion = function(index) {
    // Save current status back to button class before leaving
    const prevIndex = window.examState.currentQuestionIndex;
    window.updateSidebarButtonUI(prevIndex);

    // Set new active index
    window.examState.currentQuestionIndex = index;

    // Render HTML components of the question
    const q = window.examState.questions[index];
    const qNumEl = document.getElementById('question-number-title');
    const qTextEl = document.getElementById('question-text-content');
    const optionsContainer = document.getElementById('options-container');

    if (qNumEl) qNumEl.textContent = `Question ${index + 1}`;
    if (qTextEl) qTextEl.textContent = q.text;

    if (optionsContainer) {
        optionsContainer.innerHTML = '';
        
        q.options.forEach((optText, optIdx) => {
            const letter = String.fromCharCode(65 + optIdx); // A, B, C, D
            const isSelected = window.examState.answers[index] === letter;

            const card = document.createElement('div');
            card.className = `option-card ${isSelected ? 'selected' : ''}`;
            card.id = `opt-card-${letter}`;

            const radio = document.createElement('input');
            radio.type = 'radio';
            radio.name = 'question-options';
            radio.value = letter;
            radio.id = `radio-${letter}`;
            radio.checked = isSelected;

            // Clicking option card selects the radio
            card.addEventListener('click', () => {
                radio.checked = true;
                // Highlight option card
                document.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                
                // Set status to answered and store result
                window.examState.answers[index] = letter;
                window.examState.status[index] = 'answered';
                window.updateSidebarButtonUI(index);
            });

            const label = document.createElement('label');
            label.htmlFor = `radio-${letter}`;
            label.className = 'ms-2 flex-grow-1 cursor-pointer';
            label.textContent = `${letter}. ${optText}`;

            card.appendChild(radio);
            card.appendChild(label);
            optionsContainer.appendChild(card);
        });
    }

    // Set styling of active button in left grid
    window.updateSidebarButtonUI(index);
    const currBtn = document.getElementById(`qbtn-${index}`);
    if (currBtn) {
        currBtn.classList.add('q-current');
    }

    // Manage Previous / Next button active state
    const prevBtn = document.getElementById('btn-prev');
    if (prevBtn) {
        if (index === 0) {
            prevBtn.classList.add('disabled');
        } else {
            prevBtn.classList.remove('disabled');
        }
    }

    const nextBtn = document.getElementById('btn-next');
    if (nextBtn) {
        if (index === window.examState.questions.length - 1) {
            nextBtn.textContent = 'Save & Finish';
        } else {
            nextBtn.textContent = 'Save & Next';
        }
    }
};

/**
 * Handle "Save & Next" action
 */
window.saveAndNext = function() {
    const idx = window.examState.currentQuestionIndex;

    // Check if an option is selected currently, if so it updates state
    const selectedRadio = document.querySelector('input[name="question-options"]:checked');
    if (selectedRadio) {
        window.examState.answers[idx] = selectedRadio.value;
        window.examState.status[idx] = 'answered';
    }

    window.updateSidebarButtonUI(idx);

    if (idx < window.examState.questions.length - 1) {
        window.navigateToQuestion(idx + 1);
    } else {
        // Last question, ask user to submit
        if (confirm("You are on the last question. Do you want to submit the exam?")) {
            window.submitExam(false);
        }
    }
};

/**
 * Handle "Mark for Review" action
 */
window.markForReview = function() {
    const idx = window.examState.currentQuestionIndex;

    // Save answer if selected
    const selectedRadio = document.querySelector('input[name="question-options"]:checked');
    if (selectedRadio) {
        window.examState.answers[idx] = selectedRadio.value;
    }
    
    // Set status to marked
    window.examState.status[idx] = 'marked';
    window.updateSidebarButtonUI(idx);

    // Auto-advance to next question if possible
    if (idx < window.examState.questions.length - 1) {
        window.navigateToQuestion(idx + 1);
    }
};

/**
 * Handle "Clear Response" action
 */
window.clearResponse = function() {
    const idx = window.examState.currentQuestionIndex;
    
    // Deselect radios
    const checkedRadio = document.querySelector('input[name="question-options"]:checked');
    if (checkedRadio) checkedRadio.checked = false;

    // Clear background selection
    document.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));

    // Clear state
    delete window.examState.answers[idx];
    window.examState.status[idx] = 'unvisited';

    window.updateSidebarButtonUI(idx);
};

/**
 * Update UI stylesheet styling for a sidebar question indicator
 * @param {number} idx - Index of question
 */
window.updateSidebarButtonUI = function(idx) {
    const btn = document.getElementById(`qbtn-${idx}`);
    if (!btn) return;

    // Clear existing state class names
    btn.className = 'question-btn';

    const status = window.examState.status[idx];
    if (status === 'answered') {
        btn.classList.add('q-answered');
    } else if (status === 'marked') {
        btn.classList.add('q-marked');
    } else {
        btn.classList.add('q-not-visited');
    }
};

/**
 * Submit the examination, calculating statistics and launching Summary Modal
 * @param {boolean} isAuto - True if auto-submitted (timer runout or tab violation)
 */
window.submitExam = function(isAuto = false) {
    if (window.examState.isExamSubmitted) return;
    window.examState.isExamSubmitted = true;

    // Stop timer and camera proctor
    window.stopTimer();
    if (window.proctoringMedia) {
        window.proctoringMedia.stop();
    }

    // Dismiss any open warning modals
    const warningModalEl = document.getElementById('warningModal');
    if (warningModalEl) {
        const warningInstance = bootstrap.Modal.getInstance(warningModalEl);
        if (warningInstance) {
            warningInstance.hide();
        }
    }

    // Calculate final exam metrics
    let answeredCount = 0;
    let markedCount = 0;
    const totalQCount = window.examState.questions.length;

    for (let i = 0; i < totalQCount; i++) {
        if (window.examState.status[i] === 'answered') {
            answeredCount++;
        } else if (window.examState.status[i] === 'marked') {
            markedCount++;
        }
    }

    const timeTakenStr = window.getTimeTakenString();

    // Populate Submission Modal metrics
    document.getElementById('modal-metric-total').textContent = totalQCount;
    document.getElementById('modal-metric-answered').textContent = answeredCount;
    document.getElementById('modal-metric-marked').textContent = markedCount;
    document.getElementById('modal-metric-violations').textContent = window.examState.violationsCount;
    document.getElementById('modal-metric-time').textContent = timeTakenStr;

    // Lock inputs (MCQs and controls)
    document.querySelectorAll('input[type="radio"]').forEach(r => r.disabled = true);
    document.querySelectorAll('.option-card').forEach(c => c.style.pointerEvents = 'none');
    document.getElementById('btn-prev').classList.add('disabled');
    document.getElementById('btn-next').classList.add('disabled');
    document.getElementById('btn-review').classList.add('disabled');
    document.getElementById('btn-clear').classList.add('disabled');
    document.getElementById('submit-exam-header-btn').classList.add('disabled');

    // Display Submission Modal via Bootstrap
    const resultModalEl = document.getElementById('submitResultModal');
    if (resultModalEl) {
        const resultInstance = new bootstrap.Modal(resultModalEl, {
            backdrop: 'static',
            keyboard: false
        });
        resultInstance.show();
    }

    // Exit Fullscreen
    if (document.fullscreenElement) {
        document.exitFullscreen().catch(err => console.log("Fullscreen exit fail:", err));
    }
};
