<?php
include "../../config/config.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo TITLE ?? "Enrollment System" ?> | Faculty</title>
    <link rel="icon" type="image/x-icon" href="\enrollment-system\public\resources/favicon.png">
    <link rel="stylesheet" href="\enrollment-system\public\resources\styles\style.css">
    <style>

        #add-student, #search-btn{
            padding: 5px;
        }

        #controls form{
            gap:1rem;
        }

        h2 {
            margin:0 0 10px 0;
        }

        hr {
            margin: 1rem 0;
            height: 2px;
            background-color: black;
        }

        #faculty-table {
            width: 100%;
        }
        th.col-actions {
            width:20%
        }
        #faculty-table .col-id {
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

        #add-faculty-dialog {
            background-color: white;
            width:400px;
            padding: 1rem;

            border: 1px solid var(--primary);
            border-radius:5px;
        }

        #add-faculty-dialog button{
            padding:5px;
        }

        .form-group{
            display: flex;
            flex-direction: column;
        }

        .grid {display: grid;gap:1rem;}

        .grid-cols-1 { grid-template-columns: repeat(1, 1fr); }
        .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }

    </style>
</head>
<body>
    <!-- OVERLAYY -->
    <!-- OVERLAYY -->
    <!-- OVERLAYY -->
    <div id="overlay" class="hidden">
        <div id="add-faculty-dialog">
            <h2>Add Faculty</h2>
            <hr>
            <form action="../../" method="POST" class="flex flex-col gap-1">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="actions flex just-end gap-1">
                    <button type="submit" class="btn-1">
                        Save Faculty
                    </button>
                    <button type="button" class="btn-3" onclick="closeModal('overlay')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
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
        <h2>
            Faculty
        </h2>
        <!-- CONTROLS -->
        <div id="controls" class="flex flex-row just-between">
            <form action="index.php" method="get" class="flex flex-row items-center">
                <div>
                    <label for="subject">Search Faculty: </label>
                    <input type="text" name="s" id="search">
                </div>
                <button id="search-btn" class="btn-1" type="submit">
                   <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l5.6 5.6q.275.275.275.7t-.275.7t-.7.275t-.7-.275l-5.6-5.6q-.75.6-1.725.95T9.5 16m0-2q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14" stroke-width="0.5" stroke="currentColor"/></svg>
                </button>
            </form>
            <button id="add-subject" class="btn-2" onclick="openModal('overlay')">
                Add Faculty
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M11.288 20.713Q11 20.425 11 20v-7H4q-.425 0-.712-.288T3 12t.288-.712T4 11h7V4q0-.425.288-.712T12 3t.713.288T13 4v7h7q.425 0 .713.288T21 12t-.288.713T20 13h-7v7q0 .425-.288.713T12 21t-.712-.288" stroke-width="0.5" stroke="currentColor"/></svg>
            </button>
        </div>
        <hr>
        <!-- TABLE -->
        <div id="table-container">
            <table id="faculty-table">
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="col-actions">Actions</th>
                    </tr>
                </thead>
                <tbody id="tbody">
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
<script>
    const faculties = [];

    function loadFaculties(){

    }
</script>
</html>