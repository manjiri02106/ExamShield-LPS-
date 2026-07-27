/* assets/js/exam.js */
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize DataTables if table exists
    if (document.getElementById('examTable')) {
        $('#examTable').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search exams..."
            }
        });
    }

    // Toggle Random vs Manual Selection
    const qSelectionType = document.getElementById('qSelectionType');
    if (qSelectionType) {
        qSelectionType.addEventListener('change', function(e) {
            if (e.target.value === 'random') {
                document.getElementById('randomSelectionDiv').classList.remove('d-none');
                document.getElementById('manualSelectionDiv').classList.add('d-none');
            } else {
                document.getElementById('randomSelectionDiv').classList.add('d-none');
                document.getElementById('manualSelectionDiv').classList.remove('d-none');
                loadQuestionBank();
            }
        });
    }

    // Handle Time Validation
    const startTime = document.getElementById('startTime');
    const endTime = document.getElementById('endTime');
    const durationInput = document.getElementById('duration');

    if (startTime && endTime) {
        endTime.addEventListener('change', validateTime);
        startTime.addEventListener('change', validateTime);
    }

    if (durationInput) {
        durationInput.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    }

    function validateTime() {
        if (startTime.value && endTime.value) {
            const start = new Date(`1970-01-01T${startTime.value}Z`);
            const end = new Date(`1970-01-01T${endTime.value}Z`);
            
            if (end <= start) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Time',
                    text: 'End time cannot be before or equal to start time.',
                    confirmButtonColor: '#6f42c1'
                });
                endTime.value = '';
            } else {
                // Auto calculate duration in minutes
                const diffMs = end - start;
                const diffMins = Math.round(diffMs / 60000);
                if (durationInput) {
                    durationInput.value = diffMins;
                }
            }
        }
    }

    // Generate Random Questions Action
    const btnGenerateRandom = document.getElementById('btnGenerateRandom');
    if (btnGenerateRandom) {
        btnGenerateRandom.addEventListener('click', function() {
            const subjectId = document.getElementById('subject').value;
            const easyCount = document.getElementById('easyCount').value;
            const mediumCount = document.getElementById('mediumCount').value;
            const hardCount = document.getElementById('hardCount').value;

            if (!subjectId) {
                Swal.fire('Warning', 'Please select a subject first.', 'warning');
                return;
            }

            showSpinner();
            
            // AJAX call to random_questions.php API
            fetch('backend/api/random_questions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `subject_id=${subjectId}&easy=${easyCount}&medium=${mediumCount}&hard=${hardCount}`
            })
            .then(response => response.json())
            .then(data => {
                hideSpinner();
                if (data.status === 'success') {
                    displaySelectedQuestions(data.questions);
                    Swal.fire({
                        icon: 'success',
                        title: 'Generated!',
                        text: `Generated ${data.questions.length} questions successfully.`,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                hideSpinner();
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to generate questions.', 'error');
            });
        });
    }

    // Handle form submit for exam creation
    const formCreateExam = document.getElementById('formCreateExam');
    if(formCreateExam) {
        formCreateExam.addEventListener('submit', function(e) {
            e.preventDefault();
            // Perform final validation
            const duration = document.getElementById('duration').value;
            if (duration <= 0) {
                Swal.fire('Error', 'Duration must be a positive number.', 'error');
                return;
            }

            // Submit logic via AJAX
            const formData = new FormData(this);
            showSpinner();
            
            fetch('backend/api/create_exam.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideSpinner();
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'exam_list.php';
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                hideSpinner();
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to create exam.', 'error');
            });
        });
    }

    // Handle form submit for schedule exam
    const formScheduleExam = document.getElementById('formScheduleExam');
    if (formScheduleExam) {
        formScheduleExam.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            showSpinner();
            
            fetch('backend/api/schedule_exam.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideSpinner();
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'exam_list.php';
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                hideSpinner();
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to schedule exam.', 'error');
            });
        });
    }

    // Handle form submit for edit exam
    const formEditExam = document.getElementById('formEditExam');
    if (formEditExam) {
        formEditExam.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            // exam_id is a hidden input in the form, but let's make sure it posts id
            formData.append('id', formData.get('exam_id'));
            
            showSpinner();
            
            fetch('backend/api/update_exam.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideSpinner();
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'exam_list.php';
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                hideSpinner();
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to update exam.', 'error');
            });
        });
    }
});

function loadQuestionBank() {
    const subjectId = document.getElementById('subject')?.value;
    if (!subjectId) return;

    // Fetch questions from backend/api/get_questions.php and populate #manualSelectionDiv
    showSpinner();
    fetch(`backend/api/get_questions.php?subject_id=${subjectId}`)
    .then(response => response.json())
    .then(data => {
        hideSpinner();
        if (data.status === 'success') {
            let html = '<div class="list-group">';
            data.questions.forEach(q => {
                let badgeColor = 'bg-secondary';
                if (q.difficulty === 'Easy') badgeColor = 'bg-success';
                if (q.difficulty === 'Medium') badgeColor = 'bg-warning text-dark';
                if (q.difficulty === 'Hard') badgeColor = 'bg-danger';
                
                html += `<label class="list-group-item d-flex gap-3 align-items-start">
                            <input class="form-check-input flex-shrink-0 q-checkbox mt-1" type="checkbox" value="${q.id}" data-marks="${q.marks}" data-text="${q.question_text.replace(/"/g, '&quot;')}">
                            <div>
                                <div class="fw-bold mb-1">${q.question_text}</div>
                                <span class="badge ${badgeColor} me-2">${q.difficulty}</span>
                                <span class="badge bg-info me-2">Unit ${q.unit}</span>
                                <span class="badge bg-dark me-2">${q.type}</span>
                                <span class="text-primary fw-bold" style="font-size: 0.85rem;"><i class="fas fa-star"></i> ${q.marks} Marks</span>
                            </div>
                         </label>`;
            });
            html += '</div>';
            document.getElementById('questionBankContainer').innerHTML = html;
        } else {
            document.getElementById('questionBankContainer').innerHTML = `<div class="alert alert-warning">${data.message}</div>`;
        }
    })
    .catch(error => {
        hideSpinner();
        console.error('Error:', error);
        document.getElementById('questionBankContainer').innerHTML = `<div class="alert alert-danger">Failed to load questions.</div>`;
    });
}

function displaySelectedQuestions(questions) {
    const container = document.getElementById('selectedQuestionsList');
    if (!container) return;
    
    let html = '<ul class="list-group">';
    let totalMarks = 0;
    
    questions.forEach(q => {
        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    ${q.question_text}
                    <span class="badge bg-primary rounded-pill">${q.marks} Marks</span>
                    <input type="hidden" name="question_ids[]" value="${q.id}">
                 </li>`;
        totalMarks += parseInt(q.marks);
    });
    html += '</ul>';
    
    container.innerHTML = html;
    
    const marksDisplay = document.getElementById('totalMarksDisplay');
    if (marksDisplay) marksDisplay.innerText = totalMarks;
}

function showSpinner() {
    let spinner = document.getElementById('globalSpinner');
    if (!spinner) {
        spinner = document.createElement('div');
        spinner.id = 'globalSpinner';
        spinner.className = 'spinner-overlay';
        spinner.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';
        document.body.appendChild(spinner);
    }
    spinner.style.display = 'flex';
}

function hideSpinner() {
    const spinner = document.getElementById('globalSpinner');
    if (spinner) spinner.style.display = 'none';
}

// Function to handle Publish toggle
function togglePublishStatus(examId, currentStatus) {
    Swal.fire({
        title: 'Are you sure?',
        text: currentStatus === 'Published' ? 'Do you want to unpublish this exam?' : 'Do you want to publish this exam? Students will be able to view it.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6f42c1',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed!'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to publish_exam.php
            fetch('backend/api/publish_exam.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${examId}&status=${currentStatus}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to update status.', 'error');
            });
        }
    });
}
