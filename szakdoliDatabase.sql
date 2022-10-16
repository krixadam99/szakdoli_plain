/*DROP TABLE neptun_validation;
DROP TABLE expectation_rules;
DROP TABLE task_due_to_date;
DROP TABLE grade_table;
DROP TABLE results;
DROP TABLE practice_task_points;
DROP TABLE user_groups;
DROP TABLE users;*/


CREATE TABLE neptun_validation (
    neptun_code varchar(6) NOT NULL,
    validation_code varchar(255) NOT NULL,
    
    UNIQUE (neptun_code)
);

CREATE TABLE users (
    neptun_code varchar(6) NOT NULL,
    email_address varchar(255) NOT NULL,
    user_password varchar(255) NOT NULL,
    is_administrator int(11) NOT NULL,
    
    UNIQUE (neptun_code),
    PRIMARY KEY(neptun_code)
);

CREATE TABLE user_groups (
    neptun_code varchar(6) NOT NULL,
    is_teacher int(11) NOT NULL DEFAULT 0,
    subject_group int(11) NOT NULL,
    subject_name varchar(255) NOT NULL,
    application_request_status varchar(10) NOT NULL DEFAULT "PENDING",
    
    UNIQUE ( neptun_code, subject_group, subject_name ),
    FOREIGN KEY( neptun_code) REFERENCES users( neptun_code ),
    PRIMARY KEY( neptun_code, subject_name, subject_group )
);

CREATE TABLE practice_task_points (
    neptun_code varchar(6) NOT NULL,
    subject_name varchar(255) NOT NULL,
    subject_group int(11) NOT NULL,
    practice_task_1 float NOT NULL DEFAULT 0,
    practice_task_2 float NOT NULL DEFAULT 0,
    practice_task_3 float NOT NULL DEFAULT 0,
    practice_task_4 float NOT NULL DEFAULT 0,
    practice_task_5 float NOT NULL DEFAULT 0,
    practice_task_6 float NOT NULL DEFAULT 0,
    practice_task_7 float NOT NULL DEFAULT 0,
    practice_task_8 float NOT NULL DEFAULT 0,
    practice_task_9 float NOT NULL DEFAULT 0,
    practice_task_10 float NOT NULL DEFAULT 0,
    
    UNIQUE (neptun_code, subject_name),
    FOREIGN KEY( neptun_code, subject_name ) REFERENCES user_groups( neptun_code, subject_name )
);

CREATE TABLE results (
    neptun_code varchar(6) NOT NULL,
    subject_name varchar(255) NOT NULL,
    subject_group int(11) NOT NULL,
    practice_count int(11) NOT NULL DEFAULT 0,
    extra int(11) NOT NULL DEFAULT 0,
    middle_term_exam int(11) NOT NULL DEFAULT 0,
    final_term_exam int(11) NOT NULL DEFAULT 0,
    middle_term_exam_correction int(11) NOT NULL DEFAULT 0,
    final_term_exam_correction int(11) NOT NULL DEFAULT 0,
    small_test_1 int(11) NOT NULL DEFAULT 0,
    small_test_2 int(11) NOT NULL DEFAULT 0,
    small_test_3 int(11) NOT NULL DEFAULT 0,
    small_test_4 int(11) NOT NULL DEFAULT 0,
    small_test_5 int(11) NOT NULL DEFAULT 0,
    small_test_6 int(11) NOT NULL DEFAULT 0,
    small_test_7 int(11) NOT NULL DEFAULT 0,
    small_test_8 int(11) NOT NULL DEFAULT 0,
    small_test_9 int(11) NOT NULL DEFAULT 0,
    small_test_10 int(11) NOT NULL DEFAULT 0,
    
    UNIQUE (neptun_code, subject_name),
    FOREIGN KEY( neptun_code, subject_name ) REFERENCES user_groups( neptun_code, subject_name )
);

CREATE TABLE expectation_rules (
    subject_group int(11) NOT NULL,
    subject_name varchar(255) NOT NULL,
    task_type varchar(255) NOT NULL,
    is_better int(11) NOT NULL DEFAULT -1,
    minimum_for_pass int(11) NOT NULL DEFAULT 0,
    maximum_value int(11) NOT NULL DEFAULT 100,

    UNIQUE (subject_group, subject_name, task_type)
);

CREATE TABLE grade_table (
    subject_group int(11) NOT NULL,
    subject_name varchar(255) NOT NULL,
    pass_level_point int(11) NOT NULL DEFAULT 0,
    satisfactory_level_point int(11) NOT NULL DEFAULT 0,
    good_level_point int(11) NOT NULL DEFAULT 0,
    excellent_level_point int(11) NOT NULL DEFAULT 0,

    UNIQUE (subject_group, subject_name)
);

CREATE TABLE task_due_to_date (
    subject_group int(11) NOT NULL,
    subject_name varchar(255) NOT NULL,
    task_type varchar(255) NOT NULL,
    due_to DATE NOT NULL DEFAULT CURRENT_DATE,

    UNIQUE (subject_group, subject_name, task_type)
);

/*
CREATE TABLE messages (
    neptun_code varchar(6) NOT NULL,
    message_id int(11) NOT NULL,
    message varchar(4048) NOT NULL DEFAULT "",
    is_submitter int(11) NOT NULL DEFAULT 0,
    is_seen int(11) NOT NULL DEFAULT 0,
    is_removed int(11) NOT NULL DEFAULT 0,
    thread_count int(11) NOT NULL DEFAULT 0

    FOREIGN KEY( neptun_code) REFERENCES users( neptun_code )
);

CREATE TABLE customized_task (
    neptun_code varchar(6) NOT NULL,
    subject_group int(11) NOT NULL,
    subject_name varchar(255) NOT NULL,
    task_type varchar(255) NOT NULL,
    question varchar(2024) NOT NULL,
    answer varchar(2024) NOT NULL
    
    FOREIGN KEY( neptun_code) REFERENCES users( neptun_code )
);
*/

INSERT INTO users VALUES("admin", "-", "$2y$10$9nSKotQ51hqlRaNt8AMaXOgCw97rLwvobEP8KuM7OC4cS3Ae7gixu", 1);
INSERT INTO users VALUES("AAAAAA", "crx.adam1999@gmail.com", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("ABCABC", "abcabc@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("BBBBBB", "bbbbbb@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("CBACBA", "cbacba@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("ALMA12", "alma12@example.hu", "$2y$10$1QGG.K.mP1AFMZ05clvezu5Jhj9Ol5sS5bm.qQCK2BmEB/jMXfJV.", 0);


INSERT INTO user_groups VALUES("AAAAAA", 1, 1, "i", "APPROVED");
INSERT INTO user_groups VALUES("AAAAAA", 1, 2, "ii", "APPROVED");
INSERT INTO user_groups VALUES("AAAAAA", 1, 2, "i", "APPROVED");
INSERT INTO user_groups VALUES("AAAAAA", 1, 3, "ii", "APPROVED");
INSERT INTO user_groups VALUES("ABCABC", 0, 1, "i", "WITHDRAWN");
INSERT INTO user_groups VALUES("ABCABC", 0, 2, "ii", "APPROVED");
INSERT INTO user_groups VALUES("ALMA12", 1, 1, "i", "APPROVED");
INSERT INTO user_groups VALUES("ALMA12", 0, 2, "i", "WITHDRAWN");
INSERT INTO user_groups VALUES("BBBBBB", 0, 1, "i", "APPROVED");
INSERT INTO user_groups VALUES("CBACBA", 0, 3, "ii", "APPROVED");


INSERT INTO practice_task_points(neptun_code, subject_name, subject_group, practice_task_1, practice_task_2) VALUES("ABCABC", "ii", 2, 2, 0.5);
INSERT INTO practice_task_points(neptun_code, subject_name, subject_group, practice_task_1) VALUES("ABCABC", "i", 1, 0.2);
INSERT INTO practice_task_points(neptun_code, subject_name, subject_group) VALUES("ALMA12", "i", 1);
INSERT INTO practice_task_points(neptun_code, subject_name, subject_group,  practice_task_1) VALUES("BBBBBB", "i", 1, 5);
INSERT INTO practice_task_points(neptun_code, subject_name, subject_group) VALUES("CBACBA", "ii", 3);


INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("ABCABC", "ii", 2);
INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("ABCABC", "i", 1);
INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("ALMA12", "i", 1);
INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("BBBBBB", "i", 1);
INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("CBACBA", "ii", 3);


INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(1, "i", "practice_count");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(1, "i", "extra");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(1, "i", "middle_term_exam");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(1, "i", "final_term_exam");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(1, "i", "middle_term_exam_correction");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(1, "i", "final_term_exam_correction");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(1, "i", "small_tests");

INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "middle_term_exam");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "final_term_exam");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "middle_term_exam_correction");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "final_term_exam_correction");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "small_test_1");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "small_test_2");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "small_test_3");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "small_test_4");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "small_test_5");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "small_test_6");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "small_test_7");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "small_test_8");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "small_test_9");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "small_test_10");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "practice_task_1");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "practice_task_2");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "practice_task_3");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "practice_task_4");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "practice_task_5");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "practice_task_6");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "practice_task_7");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "practice_task_8");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "practice_task_9");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(1, "i", "practice_task_10");

INSERT INTO grade_table(subject_group, subject_name) VALUES(1, "i");


INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_count");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "ii", "extra");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "ii", "middle_term_exam");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "ii", "final_term_exam");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "ii", "middle_term_exam_correction");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "ii", "final_term_exam_correction");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "ii", "small_tests");

INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "middle_term_exam");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "final_term_exam");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "middle_term_exam_correction");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "final_term_exam_correction");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "small_test_1");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "small_test_2");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "small_test_3");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "small_test_4");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "small_test_5");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "small_test_6");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "small_test_7");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "small_test_8");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "small_test_9");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "small_test_10");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_task_1");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_task_2");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_task_3");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_task_4");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_task_5");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_task_6");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_task_7");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_task_8");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_task_9");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "ii", "practice_task_10");

INSERT INTO grade_table(subject_group, subject_name) VALUES(2, "ii");


INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "i", "practice_count");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "i", "extra");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "i", "middle_term_exam");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "i", "final_term_exam");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "i", "middle_term_exam_correction");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "i", "final_term_exam_correction");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(2, "i", "small_tests");

INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "middle_term_exam");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "final_term_exam");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "middle_term_exam_correction");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "final_term_exam_correction");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "small_test_1");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "small_test_2");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "small_test_3");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "small_test_4");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "small_test_5");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "small_test_6");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "small_test_7");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "small_test_8");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "small_test_9");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "small_test_10");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "practice_task_1");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "practice_task_2");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "practice_task_3");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "practice_task_4");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "practice_task_5");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "practice_task_6");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "practice_task_7");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "practice_task_8");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "practice_task_9");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(2, "i", "practice_task_10");

INSERT INTO grade_table(subject_group, subject_name) VALUES(2, "i");


INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_count");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(3, "ii", "extra");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(3, "ii", "middle_term_exam");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(3, "ii", "final_term_exam");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(3, "ii", "middle_term_exam_correction");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(3, "ii", "final_term_exam_correction");
INSERT INTO expectation_rules(subject_group, subject_name, task_type) VALUES(3, "ii", "small_tests");

INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "middle_term_exam");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "final_term_exam");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "middle_term_exam_correction");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "final_term_exam_correction");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "small_test_1");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "small_test_2");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "small_test_3");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "small_test_4");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "small_test_5");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "small_test_6");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "small_test_7");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "small_test_8");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "small_test_9");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "small_test_10");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_task_1");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_task_2");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_task_3");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_task_4");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_task_5");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_task_6");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_task_7");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_task_8");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_task_9");
INSERT INTO task_due_to_date(subject_group, subject_name, task_type) VALUES(3, "ii", "practice_task_10");

INSERT INTO grade_table(subject_group, subject_name) VALUES(3, "ii");
