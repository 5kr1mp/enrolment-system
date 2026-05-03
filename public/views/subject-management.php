<?php
include "../../config/config.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo TITLE ?? "Enrollment System" ?> | Subjects</title>
    <link rel="icon" type="image/x-icon" href="\enrollment-system\public\resources/favicon.png">
    <link rel="stylesheet" href="\enrollment-system\public\resources\styles\style.css">
    <style>

        .btn-1, .btn-2{
            padding: 5px;
        }

        #search-btn{
            height: 2rem;
            width: 2rem;
        }

        h2 {
            margin:0 0 10px 0;
        }

        hr {
            margin: 1rem 0;
            height: 2px;
            background-color: black;
        }
        th.col-actions {
            width:20%
        }
        #subject-table {
            width: 100%;
        }

        #subject-table .col-code {
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

        #add-subject-dialog {
            background-color: white;
            width:400px;
            padding: 1rem;

            border: 1px solid var(--primary);
            border-radius:5px;
        }

        #add-subject-dialog button{
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
    <!-- OVERLAYY -->
    <div id="overlay" class="hidden">
        <div id="add-subject-dialog">
            <h2>Add Subject</h2>
            <hr>
            <form action="../../" method="POST" class="flex flex-col gap-1">
                <div class="form-group">
                    <label for="subject-code">Subject Code</label>
                    <input type="text" id="subject-code" name="subject_code" required>
                </div>

                <div class="form-group">
                    <label for="subject-name">Subject Name</label>
                    <input type="text" id="subject-name" name="subject_name" required>
                </div>

                <div class="form-group">
                    <label for="faculty">Faculty</label>
                    <select name="faculty" id="faculty">

                    </select>
                </div>

                <div class="form-group">
                    <label for="day">Day</label>
                    <select name="day" id="day">
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 w-full">
                    <div class="form-group">
                        <label for="time-start">Time Start</label>
                        <input type="time" id="time-start" name="time_start">
                    </div>
    
                    <div class="form-group">
                        <label for="time-end">Time End</label>
                        <input type="time" id="time-end" name="time_end">
                    </div>
                </div>


                <div class="actions flex just-end gap-1">
                    <button type="submit" class="btn-1">
                        Save Subject
                    </button>
                    <button type="button" class="btn-3" onclick="closeModal('overlay')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- HEADEARRR -->
    <header class="flex flex-row just-between items-center">
        <h1><a href="/enrollment-system/public/index.php"> Student Enrollment</a></h1>
        <ul class="flex just-between items-center">
            <li><a href="/enrollment-system/public/index.php">Enrollment</a></li>
            <li><a href="/enrollment-system/public/views/student-management.php">Students</a></li>
            <li><a href="/enrollment-system/public/views/faculty-management.php">Faculties</a></li>
            <li><a href="/enrollment-system/public/views/subject-management.php">Subject</a></li>
        </ul>
    </header>

<!-- Data List -->

<datalist id="faculties">
</datalist>
<!-- Data List -->
    <main>
        <h2>
            Subject
        </h2>
        <!-- CONTROLLS -->
        <!-- CONTROLLS -->
        <!-- CONTROLLS -->
        <!-- CONTROLLS -->
        <div id="controls" class="flex flex-row just-between">
            <form action="" method="get" class="flex flex-row items-center gap-2">
                <div>
                    <label for="faculty">By Faculty: </label>
                    <input name="f" id="faculty" list="faculties">
                </div>
                <div>
                    <label for="day">By Day: </label>
                    <select name="d" id="day">
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                    </select>
                </div>
                <button id="search-btn" class="btn-1" type="submit">
                    >
                </button>
                <a href="subject-management.php" id="clear-filter" class="btn-1" style="text-decoration: none;">
                    Clear Filter
                </a>
            </form>
            <button id="add-subject" class="btn-2" onclick="openModal('overlay')">
                Add Subject
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M11.288 20.713Q11 20.425 11 20v-7H4q-.425 0-.712-.288T3 12t.288-.712T4 11h7V4q0-.425.288-.712T12 3t.713.288T13 4v7h7q.425 0 .713.288T21 12t-.288.713T20 13h-7v7q0 .425-.288.713T12 21t-.712-.288" stroke-width="0.5" stroke="currentColor"/></svg>
            </button>
        </div>
        <hr>
        <!-- TABLE -->
        <!-- TABLE -->
        <!-- TABLE -->
        <div id="table-container">
            <table id="subject-table">
                <thead>
                    <tr>
                        <th class="col-code">Code</th>
                        <th>Name</th>
                        <th>Faculty</th>
                        <th>Schedules</th>
                        <th class="col-actions">Actions</th>
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
<script>
    const faculties = [];

    function loadFaculties(){



    }
</script>
</html>