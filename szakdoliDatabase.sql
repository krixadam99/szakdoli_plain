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
    pending_status int(11) NOT NULL,
    
    UNIQUE ( neptun_code, subject_group, subject_name ),
    FOREIGN KEY( neptun_code) REFERENCES users( neptun_code ),
    PRIMARY KEY( neptun_code, subject_name, subject_group )
);

CREATE TABLE practice_task_points (
    neptun_code varchar(6) NOT NULL,
    subject_name varchar(255) NOT NULL,
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
    FOREIGN KEY( neptun_code , subject_name ) REFERENCES user_groups( neptun_code, subject_name )
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
    
    UNIQUE (neptun_code, subject_group),
    FOREIGN KEY( neptun_code, subject_name, subject_group ) REFERENCES user_groups( neptun_code, subject_name, subject_group )
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

CREATE TABLE task (
    subject_group int(11) NOT NULL,
    subject_name varchar(255) NOT NULL,
    task_type varchar(255) NOT NULL,
    is_better int(11) NOT NULL DEFAULT 0,
    minimum_for_pass int(11) NOT NULL DEFAULT 0,
    expires_at DATE NOT NULL,
);

*/

INSERT INTO users VALUES("admin", "-", "$2y$10$9nSKotQ51hqlRaNt8AMaXOgCw97rLwvobEP8KuM7OC4cS3Ae7gixu", 1);
INSERT INTO users VALUES("AAAAAA", "aaaaaa@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("ABCABC", "abcabc@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("BBBBBB", "bbbbbb@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("CBACBA", "cbacba@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);

INSERT INTO user_groups VALUES("AAAAAA", 1, 1, "i", 0);
INSERT INTO user_groups VALUES("AAAAAA", 1, 2, "ii", 0);
INSERT INTO user_groups VALUES("AAAAAA", 1, 3, "ii", 0);
INSERT INTO user_groups VALUES("ABCABC", 0, 2, "ii", 0);
INSERT INTO user_groups VALUES("BBBBBB", 0, 1, "i", 0);
INSERT INTO user_groups VALUES("CBACBA", 0, 3, "ii", 0);

INSERT INTO practice_task_points(neptun_code, subject_name, practice_task_1, practice_task_2) VALUES("ABCABC", "ii", 2, 0.5);
INSERT INTO practice_task_points(neptun_code, subject_name, practice_task_1) VALUES("BBBBBB", "i", 5);
INSERT INTO practice_task_points(neptun_code, subject_name) VALUES("CBACBA", "ii");

INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("AAAAAA", "i", 1);
INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("AAAAAA", "ii", 2);
INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("AAAAAA", "ii", 3);
INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("ABCABC", "ii", 2);
INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("BBBBBB", "i", 1);
INSERT INTO results(neptun_code, subject_name, subject_group) VALUES("CBACBA", "ii", 3);