<?php
include "../config/config.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? "Enrollment System" ?></title>
    <link rel="icon" type="image/x-icon" href="resources/favicon.png">
    <link rel="stylesheet" href="resources/styles/style.css">
    <style>
        header {
            padding: 0.5rem;
        }

        ul {
            margin: 0;
        }
        li,a {
            list-style-type: none;
            color: black;
            text-decoration: none;
        }

    </style>
</head>
<body>
    <header class="flex flex-row just-between">
        <h1>Student Enrollment</h1>
        <div class="flex just-between items-center">
            <ul class="flex just-between items-center">
                <li><a href="/views/faculty-management.php">Faculties</a></li>
                <li><a href="/views/faculty-management.php">Subject</a></li>
            </ul>
        </div>
    </header>
</body>
</html>