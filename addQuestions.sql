-- Question 1
INSERT INTO questions (question_text) VALUES ('What is the capital of France?');
SET @question_id1 = LAST_INSERT_ID();

-- Options for Question 1
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id1, 'Paris', 1);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id1, 'London', 0);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id1, 'Berlin', 0);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id1, 'Madrid', 0);

-- Question 2
INSERT INTO questions (question_text) VALUES ('Which planet is known as the Red Planet?');
SET @question_id2 = LAST_INSERT_ID();

-- Options for Question 2
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id2, 'Venus', 0);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id2, 'Mars', 1);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id2, 'Jupiter', 0);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id2, 'Saturn', 0);

-- Question 3
INSERT INTO questions (question_text) VALUES ('Who wrote the play "Romeo and Juliet"?');
SET @question_id3 = LAST_INSERT_ID();

-- Options for Question 3
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id3, 'William Shakespeare', 1);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id3, 'Jane Austen', 0);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id3, 'Charles Dickens', 0);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id3, 'George Orwell', 0);

-- Question 4
INSERT INTO questions (question_text) VALUES ('What is the chemical symbol for gold?');
SET @question_id4 = LAST_INSERT_ID();

-- Options for Question 4
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id4, 'Go', 0);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id4, 'Ag', 0);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id4, 'Ge', 0);
INSERT INTO options (question_id, option_text, is_correct) VALUES (@question_id4, 'Au', 1);
