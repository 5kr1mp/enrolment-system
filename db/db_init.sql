-- Active: 1777719121524@@127.0.0.1@3306
PRAGMA foreign_keys = ON;

CREATE TABLE IF NOT EXISTS student (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT,
    email TEXT UNIQUE,
    course TEXT,
    profpic_path TEXT
);

CREATE TABLE IF NOT EXISTS faculty (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT,
    email TEXT UNIQUE
);

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

CREATE TABLE IF NOT EXISTS enrollment (
    enrollment_id INTEGER PRIMARY KEY AUTOINCREMENT,
    student_id INTEGER,
    subject_code TEXT,
    UNIQUE (student_id, subject_code),
    FOREIGN KEY (student_id) REFERENCES student(id)
        ON DELETE CASCADE,
    FOREIGN KEY (subject_code) REFERENCES subject(subject_code)
        ON DELETE CASCADE
);