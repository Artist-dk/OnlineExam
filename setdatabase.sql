DROP DATABASE exam_db;

CREATE DATABASE exam_db;

USE exam_db;

-- Table to store questions
CREATE TABLE questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL
);

-- Table to store options for each question
CREATE TABLE options (
    option_id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT,
    option_text TEXT NOT NULL,
    is_correct BOOLEAN NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(question_id)
);

-- Table to store students
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    fname VARCHAR(255) NOT NULL,
    lname VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL
);




-- Table to store tests
CREATE TABLE tests (
    test_id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    test_date DATETIME NOT NULL,      -- Date of the test
    duration_minutes INT NOT NULL, -- Duration of the test in minutes
    description TEXT            -- Optional description or notes
    -- Add other columns for test details as needed
);




-- Table to associate questions with tests
CREATE TABLE test_questions (
    test_question_id INT AUTO_INCREMENT PRIMARY KEY,
    test_id INT,
    question_id INT,
    FOREIGN KEY (test_id) REFERENCES tests(test_id),
    FOREIGN KEY (question_id) REFERENCES questions(question_id)
);



-- Table to store test results


CREATE TABLE submitted_tests (
    submission_id INT AUTO_INCREMENT PRIMARY KEY,
    test_id INT,
    student_id INT,
    submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    score INT,  -- Add more columns as needed, e.g., date of the test, duration, etc.
    -- You can add more columns for additional information
    FOREIGN KEY (test_id) REFERENCES tests(test_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);



-- Table to store student answers
CREATE TABLE student_answers (
    student_answer_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    question_id INT,
    selected_option_id INT,
    test_id INT, -- Add the test_id column
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (question_id) REFERENCES questions(question_id),
    FOREIGN KEY (selected_option_id) REFERENCES options(option_id),
    FOREIGN KEY (test_id) REFERENCES tests(test_id) -- Add a foreign key for the test_id
);
-- ALTER TABLE student_answers ADD COLUMN test_id INT;

-- Add a foreign key constraint to relate test_id to the tests table
ALTER TABLE student_answers
ADD FOREIGN KEY (test_id) REFERENCES tests(test_id);





use exam_db;


CREATE VIEW question_view AS
SELECT
    tq.test_id,
    tq.question_id,
    q.question_text,
    o.option_id,
    o.option_text,
    o.is_correct
FROM
    test_questions AS tq
INNER JOIN
    questions AS q ON tq.question_id = q.question_id
LEFT JOIN
    options AS o ON q.question_id = o.question_id
WHERE
    tq.test_id = 1;



-- SELECT * FROM question_view;

-- DROP VIEW question_view;


CREATE VIEW test_questions_distinct AS
SELECT DISTINCT *
FROM question_view;

-- CREATE VIEW question_view AS
-- SELECT * FROM test_questions_distinct;


