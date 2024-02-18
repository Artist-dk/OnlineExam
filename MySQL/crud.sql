
-- questions 
INSERT INTO questions (question_text) VALUES ('What is the capital of France?');
SELECT * FROM questions;
UPDATE questions SET question_text = 'What is the capital of Germany?' WHERE question_id = 1;
DELETE FROM questions WHERE question_id = 1;


-- options

INSERT INTO options (question_id, option_text, is_correct) VALUES (1, 'Paris', 1);
INSERT INTO options (question_id, option_text, is_correct) VALUES (1, 'Berlin', 0);
SELECT * FROM options WHERE question_id = 1;
UPDATE options SET option_text = 'Munich', is_correct = 1 WHERE option_id = 2;
DELETE FROM options WHERE option_id = 2;


-- students

INSERT INTO students (username, password, fname, lname, phone, email) VALUES ('student1', 'asdf', 'ganesh', 'kumbhar', '9096378354', 'ganeshhh2003@gmail.com');
SELECT * FROM students;
UPDATE students SET phone = '9096378354' WHERE student_id = 1;
DELETE FROM students WHERE student_id = 1;



-- student_answers

INSERT INTO student_answers (student_id, question_id, selected_option_id) VALUES (1, 1, 1);
SELECT * FROM student_answers;
UPDATE student_answers SET selected_option_id = 2 WHERE student_answer_id = 1;
DELETE FROM student_answers WHERE student_answer_id = 1;


-- tests

INSERT INTO tests (subject, test_date, duration_minutes, description) VALUES ('Geography', '2023-01-15', 90, 'World Capitals Quiz');
SELECT * FROM tests;
UPDATE tests SET description = 'World Geography Quiz' WHERE test_id = 1;
DELETE FROM tests WHERE test_id = 1;


-- test_questions

INSERT INTO test_questions (test_id, question_id) VALUES (1, 1);
SELECT * FROM test_questions WHERE test_id = 1;
UPDATE test_questions SET question_id = 2 WHERE test_question_id = 1;
DELETE FROM test_questions WHERE test_question_id = 1;

