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
        th.col-actions {
            width:20%
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

        #add-student-dialog {
            background-color: white;
            padding: 1rem;

            border: 1px solid var(--primary);
            border-radius:5px;
        }

        #add-student-dialog button{
            padding:5px;
        }

        .form-group{
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <!-- OVERLAYYY -->
    <!-- OVERLAYYY -->
    <!-- OVERLAYYY -->
    <!-- OVERLAYYY -->
    <div id="overlay" class="hidden">
        <div id="add-student-dialog">
            <h2>Add Student</h2>
            <hr>
            <form action="routes/api.php?route=students.create" method="POST" class="flex flex-col gap-1">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Course</label>
                    <select name="course" id="course">
                        <option value="bsit">BSIT</option>
                        <option value="bsabe">BSABE</option>
                        <option value="beced">BECED</option>
                        <option value="bsed">BSED</option>
                        <option value="bsned">BSNED</option>
                        <option value="btvted">BTVTED</option>
                        <option value="beed">BEED</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" name="profile_picture" accept="image">
                </div>

                <div class="actions flex just-end gap-1">
                    <button type="submit" class="btn-1">
                        Save Student
                    </button>
                    <button type="button" class="btn-3" onclick="closeModal('overlay')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- HEADER -->
    <!-- HEADER -->
    <!-- HEADER -->
    <!-- HEADER -->
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
        <h2>Students</h2>
        <!-- CONTROLS -->
        <!-- CONTROLS -->
        <!-- CONTROLS -->
        <!-- CONTROLS -->
        <div id="controls" class="flex flex-row just-between">
            <form action="index.php" method="get" class="flex flex-row items-center">
                <div>
                    <label for="search">Search Student: </label>
                    <input type="text" name="s" id="search">
                </div>
                <button id="search-btn" class="btn-1" type="submit">
                   <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l5.6 5.6q.275.275.275.7t-.275.7t-.7.275t-.7-.275l-5.6-5.6q-.75.6-1.725.95T9.5 16m0-2q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14" stroke-width="0.5" stroke="currentColor"/></svg>
                </button>
            </form>
            <button id="add-student" class="btn-2" onclick="openModal('overlay')">
                Add Student
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M11.288 20.713Q11 20.425 11 20v-7H4q-.425 0-.712-.288T3 12t.288-.712T4 11h7V4q0-.425.288-.712T12 3t.713.288T13 4v7h7q.425 0 .713.288T21 12t-.288.713T20 13h-7v7q0 .425-.288.713T12 21t-.712-.288" stroke-width="0.5" stroke="currentColor"/></svg>
            </button>
        </div>
        <hr>
        <!-- TABLE -->
        <!-- TABLE -->
        <!-- TABLE -->
        <!-- TABLE -->
        <div id="table-container">
            <table id="student-profiles-table">
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th class="col-prof">Profile</th>
                        <th>Full Name</th>
                        <th>Course</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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