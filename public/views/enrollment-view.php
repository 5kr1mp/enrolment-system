<?php
include "../../config/config.php";


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? "Enrollment System" ?> | Enrollment</title>
    <link rel="icon" type="image/x-icon" href="\enrollment-system\public\resources/favicon.png">
    <link rel="stylesheet" href="\enrollment-system\public\resources\styles\style.css">
    <style>
        h2 {
            margin:0 0 10px 0;
        }

        #add-student, #search-btn{
            padding: 5px;
        }

        #controls form{
            gap:1rem;
        }

        hr {
            margin: 1rem 0;
            height: 2px;
            background-color: black;
        }

        .btn-1, .btn-2,.btn-3 {
            padding:0.5rem
        }

        #student-profiles-table {
            width: 100%;
        }

        #student-profiles-table .col-id,.col-prof {
            width: 80px;
        }

        #overlay{
            position: fixed;
            height: 100vh;
            width: 100vw;
            top: 0;

            background-color: #00000033;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hidden {
            display: none !important;
        }
        
        .col-actions {
            width:20%
        }

        #enroll-subject-dialog {
            background-color: white;
            padding: 1rem;

            border: 1px solid var(--primary);
            border-radius:5px;
        }

        #enroll-subject-dialog button{
            padding:5px;
        }

        .form-group{
            display: flex;
            flex-direction: column;
        }
        .enrollment-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            grid-template-rows: auto auto auto;
            grid-template-areas:
                "control control"
                "prof-pic subject"
                "info subject";
            gap: 1rem;
        }

        .control {
            grid-area: control;
            padding: 1rem;
            border-radius: 5px;
        }

        .prof-pic {
            grid-area: prof-pic;
            padding: 1rem;
            border-radius: 5px;
        }

        .info {
            grid-area: info;
            padding: 1rem;
            border-radius: 5px;
        }

        .subject {
            grid-area: subject;
            padding: 1rem;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<header class="flex flex-row just-between items-center">
    <h1><a href="/enrollment-system/public/index.php"> Student Enrollment</a></h1>
    <ul class="flex just-between items-center">
        <li><a href="/enrollment-system/public/index.php">Enrollment</a></li>
        <li><a href="/enrollment-system/public/views/student-management.php">Students</a></li>
        <li><a href="/enrollment-system/public/views/faculty-management.php">Faculties</a></li>
        <li><a href="/enrollment-system/public/views/subject-management.php">Subject</a></li>
    </ul>
</header>
<main>


    <div class="enrollment-grid">
        
        <!-- CONTROL -->
        <!-- CONTROL -->
        <section class="control">
            <h2>Enrollment</h2>
            <div class="flex flex-row just-end gap-1">
                <button class="btn-1">Update Subjects</button>
                <button class="btn-3">Delete Enrollment</button>
            </div>
            <hr>
        </section>

        <!-- PROFILE PICTURE -->
        <section class="prof-pic flex items-center just-center">
            <img src="../resources/default-profile.png"
                 alt="Student Profile"
                 style="width:150px;height:150px;border-radius:50%;object-fit:cover;">
        </section>

        <!-- INFO -->
        <section class="info">
            <h3>Student Information</h3>

            <div class="flex flex-col gap-1">
                <div><strong>ID:</strong> <span></span></div>
                <div><strong>Name:</strong> <span></span> </div>
                <div><strong>Course:</strong> <span></span></div>
            </div>
        </section>

        <!-- SUBJECT LIST -->
        <section class="subject">
            <h3>Enrolled Subjects</h3>

            <table style="width:100%;">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Faculty</th>
                        <th>Day</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>

    </div>
</main>
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove("hidden");
        }

        function closeModal(id) {
            document.getElementById(id).classList.add("hidden");
        }
    </script>
</body>
</html>