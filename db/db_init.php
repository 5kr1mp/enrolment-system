<?php

$dbPath = __DIR__ . "/database.db";

$pdo = new PDO("sqlite:" . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("PRAGMA foreign_keys = ON;");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS student (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        full_name TEXT,
        email TEXT UNIQUE,
        course TEXT,
        profpic_path TEXT
    );
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS faculty (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        full_name TEXT,
        email TEXT UNIQUE
    );
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS subject (
        subject_code TEXT PRIMARY KEY,
        subject_name TEXT,
        faculty_id INTEGER,
        schedule_day TEXT,
        time_start TEXT,
        time_end TEXT,
        FOREIGN KEY (faculty_id) REFERENCES faculty(id)
            ON DELETE SET NULL
    );
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS enrollment (
        student_id INTEGER,
        subject_code TEXT,
        PRIMARY KEY (student_id, subject_code),
        FOREIGN KEY (student_id) REFERENCES student(id)
            ON DELETE CASCADE,
        FOREIGN KEY (subject_code) REFERENCES subject(subject_code)
            ON DELETE CASCADE
    );
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS class_schedule (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        subject_code TEXT,
        schedule_day TEXT,
        time_start TEXT,
        time_end TEXT,
        UNIQUE (subject_code, schedule_day, time_start),
        FOREIGN KEY (subject_code) REFERENCES subject(subject_code)
            ON DELETE CASCADE
    );
");