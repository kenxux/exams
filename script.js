document.addEventListener('DOMContentLoaded', function() {
    loadExams();
});

function loadExams() {
    fetch('get_exams.php')
    .then(response => response.json())
    .then(data => {
        let examsList = document.getElementById('examsList');
        examsList.innerHTML = '';
        data.forEach(exam => {
            examsList.innerHTML += `<div class="exam">
                                        <h3>${exam.title}</h3>
                                        <p>${exam.description}</p>
                                        <p>Start Time: ${exam.start_time}</p>
                                        <p>End Time: ${exam.end_time}</p>
                                     </div>`;
        });
    })
    .catch(error => console.error('Error:', error));
}

document.getElementById('createExamForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var title = document.getElementById('title').value;
    var description = document.getElementById('description').value;
    var start_time = document.getElementById('start_time').value;
    var end_time = document.getElementById('end_time').value;

    fetch('create_exam.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title: title, description: description, start_time: start_time, end_time: end_time })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('successMessage').innerText = data.message;
        loadExams(); // Reload exams list after creating new exam
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
