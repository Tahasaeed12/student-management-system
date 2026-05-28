<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary">Student Management System</h2>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0" id="formTitle">Add Student</h5>
                </div>
                <div class="card-body">
                    <form id="studentForm">
                        <input type="hidden" name="id" id="student_id">
                        <input type="hidden" name="action" id="action" value="create">
                        
                        <div class="mb-3">
                            <label>Roll Number</label>
                            <input type="text" class="form-control" name="roll_number" id="roll_number" required>
                        </div>
                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="full_name" id="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label>Course</label>
                            <input type="text" class="form-control" name="course" id="course" required>
                        </div>
                        <div class="mb-3">
                            <label>Enrollment Date</label>
                            <input type="date" class="form-control" name="enrollment_date" id="enrollment_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="saveBtn">Save Record</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Roll No</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Enroll Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", loadData);

    function loadData() {
        fetch('backend.php?action=read')
        .then(response => response.json())
        .then(data => {
            let rows = '';
            data.forEach(student => {
                rows += `<tr>
                    <td>${student.id}</td>
                    <td>${student.roll_number}</td>
                    <td>${student.full_name}</td>
                    <td>${student.email}</td>
                    <td>${student.course}</td>
                    <td>${student.enrollment_date}</td>
                    <td>
                        <button class="btn btn-sm btn-warning mb-1" onclick="editStudent(${student.id}, '${student.roll_number}', '${student.full_name}', '${student.email}', '${student.course}', '${student.enrollment_date}')">Edit</button>
                        <button class="btn btn-sm btn-danger mb-1" onclick="deleteStudent(${student.id})">Delete</button>
                    </td>
                </tr>`;
            });
            document.getElementById('tableBody').innerHTML = rows;
        });
    }

    document.getElementById('studentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        
        fetch('backend.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text()).then(result => {
            this.reset();
            document.getElementById('action').value = 'create';
            document.getElementById('formTitle').innerText = 'Add Student';
            document.getElementById('saveBtn').innerText = 'Save Record';
            loadData();
        });
    });

    function editStudent(id, roll, name, email, course, enroll_date) {
        document.getElementById('student_id').value = id;
        document.getElementById('roll_number').value = roll;
        document.getElementById('full_name').value = name;
        document.getElementById('email').value = email;
        document.getElementById('course').value = course;
        
        // Enrollment date ka format sahi set karne ke liye (Sirf Date part le ga, time hata de ga)
        let formattedDate = enroll_date.split(' ')[0];
        document.getElementById('enrollment_date').value = formattedDate;
        
        document.getElementById('action').value = 'update';
        document.getElementById('formTitle').innerText = 'Update Student';
        document.getElementById('saveBtn').innerText = 'Update Record';
    }

    function deleteStudent(id) {
        if(confirm("Are you sure you want to delete this record?")) {
            let formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            fetch('backend.php', {
                method: 'POST',
                body: formData
            }).then(response => loadData());
        }
    }
</script>

</body>
</html>