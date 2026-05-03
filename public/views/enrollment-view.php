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
        border: 1px solid #101122;
        border-radius: 5px;
    }

    .prof-pic {
        grid-area: prof-pic;
        padding: 1rem;
        border: 1px solid #101122;
        border-radius: 5px;
    }

    .info {
        grid-area: info;
        padding: 1rem;
        border: 1px solid #101122;
        border-radius: 5px;
    }

    .subject {
        grid-area: subject;
        padding: 1rem;
        border: 1px solid #101122;
        border-radius: 5px;
    }
    </style>
</head>
<body>
<main>
    <h2>Enrollment View</h2>
    <hr>

    <div class="enrollment-grid">

        <!-- CONTROL -->
        <!-- CONTROL -->
        <section class="control">
            <div class="flex flex-row gap-1 items-center">
                <strong>Enrollment ID:</strong>
                <span>#ENR-001</span>
            </div>

            <div class="flex flex-row gap-1">
                <button class="btn-1">Update Subjects</button>
                <button class="btn-3">Delete Enrollment</button>
            </div>
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
                <div><strong>ID:</strong> 2026-0001</div>
                <div><strong>Name:</strong> John Doe</div>
                <div><strong>Course:</strong> BSIT</div>
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
                    <tr>
                        <td>IT101</td>
                        <td>Intro to IT</td>
                        <td>Dr. Smith</td>
                        <td>Monday</td>
                        <td>08:00 - 09:30</td>
                    </tr>
                    <tr>
                        <td>CS102</td>
                        <td>Programming</td>
                        <td>Prof. Lee</td>
                        <td>Wednesday</td>
                        <td>10:00 - 12:00</td>
                    </tr>
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