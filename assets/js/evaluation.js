// ==========================================
// ExamShield LPS - Automatic Evaluation JS
// ==========================================

document.addEventListener("DOMContentLoaded", function () {

    console.log("Automatic Evaluation Module Loaded");

});

// ==========================================
// Calculate Marks
// ==========================================

function calculateMarks() {

    let totalQuestions = document.querySelectorAll(".question").length;
    let correctAnswers = 0;

    document.querySelectorAll(".question").forEach(function (question) {

        let correct = question.getAttribute("data-answer");
        let selected = question.querySelector("input[type=radio]:checked");

        if (selected && selected.value === correct) {
            correctAnswers++;
        }

    });

    let totalMarks = totalQuestions;
    let obtainedMarks = correctAnswers;

    let percentage = ((obtainedMarks / totalMarks) * 100).toFixed(2);

    document.getElementById("totalMarks").innerHTML = totalMarks;
    document.getElementById("obtainedMarks").innerHTML = obtainedMarks;
    document.getElementById("percentage").innerHTML = percentage + "%";

    if (percentage >= 40) {
        document.getElementById("resultStatus").innerHTML = "PASS";
        document.getElementById("resultStatus").style.color = "green";
    } else {
        document.getElementById("resultStatus").innerHTML = "FAIL";
        document.getElementById("resultStatus").style.color = "red";
    }

}

// ==========================================
// Submit Confirmation
// ==========================================

function submitEvaluation() {

    let confirmSubmit = confirm("Are you sure you want to submit the exam?");

    if (confirmSubmit) {

        calculateMarks();

        alert("Evaluation Completed Successfully!");

        // Later:
        // Send marks to PHP using AJAX

    }

}

// ==========================================
// Reset Answers
// ==========================================

function resetExam() {

    let radios = document.querySelectorAll("input[type=radio]");

    radios.forEach(function (radio) {

        radio.checked = false;

    });

    document.getElementById("totalMarks").innerHTML = "0";
    document.getElementById("obtainedMarks").innerHTML = "0";
    document.getElementById("percentage").innerHTML = "0%";
    document.getElementById("resultStatus").innerHTML = "-";

}

// ==========================================
// Timer (Optional)
// ==========================================

let time = 1800; // 30 Minutes

function startTimer() {

    let timer = document.getElementById("timer");

    if (!timer) return;

    let interval = setInterval(function () {

        let minutes = Math.floor(time / 60);
        let seconds = time % 60;

        timer.innerHTML =
            minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);

        time--;

        if (time < 0) {

            clearInterval(interval);

            alert("Time Over!");

            submitEvaluation();

        }

    }, 1000);

}

// ==========================================
// Export Result
// ==========================================

function exportResult() {

    alert("Export Feature will be connected with PHP.");

}

// ==========================================
// Print Result
// ==========================================

function printResult() {

    window.print();

}