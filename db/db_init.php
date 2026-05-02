<?php

$dbHost = getenv("DB_HOST") ?? "localhost";
$dbUser = getenv("DB_USER") ?? "root";
$dbPass = getenv("DB_PASS") ?? "";

try {
    $pdo = new PDO("mysql:host=$dbHost",$dbUser,$dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $pdo->exec("CREATE DATABASE IF NOT EXISTS enrollment_system");
    echo "Database Created";

    createTables($pdo);

} catch(PDOException $err) {
    die("Database Initialization Failed: ". $err->getMessage());
}

function createTables(PDO $pdo) {
    $pdo->exec("USE enrollment_system");
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS student(
            id int primary key auto_increment,
            full_name varchar(100),
            email varchar(100) unique,
            course varchar(50),
            profpic_path varchar(255)
        );

        CREATE TABLE IF NOT EXISTS faculty(
            id int primary key auto_increment,
            full_name varchar(100),
        );
        
        CREATE TABLE IF NOT EXISTS subject(
            subject_code varchar(15) primary key,
            subject_name varchar(100),
            faculty_id int,
            foreign key (faculty_id) references faculty(id)
                on delete set null
                on update cascade
        );

        CREATE TABLE IF NOT EXISTS enrollment(
            student_id int,
            subject_code varchar(15),
            primary key (student_id,subject_code),
            foreign key (student_id) references student(id)
                on delete cascade
                on update cascade,
            foreign key (subject_code) references subject(subject_code)
                on delete cascade,
                on update cascade
        );

        CREATE TABLE IF NOT EXISTS class_schedule(
            id int primary key auto_increment,
            subject_code varchar(15),
            schedule_day varchar(10),
            time_start time,
            time_end time,
            unique (subject_code,schedule_day,time_start),
            foreign key (subject_code) references subject(subject_code)
                on delete cascade
                on update cascade
        );

        CREATE TABLE IF NOT EXISTS faculty(
            id int primary key auto_increment,
            full_name varchar(100),
        );
    ");
}
?>