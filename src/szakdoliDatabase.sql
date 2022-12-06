/*DROP TABLE practice_task_points;
DROP TABLE results;
DROP TABLE expectation_rules;
DROP TABLE task_due_to_date_table;
DROP TABLE grade_table;
DROP TABLE messages;
DROP TABLE user_status;
DROP TABLE users;
DROP TABLE subject_groups;*/


CREATE TABLE users (
    neptun_code varchar(6) NOT NULL,
    email_address varchar(255) NOT NULL,
    user_password varchar(255) NOT NULL,
    is_administrator int(11) NOT NULL,
    
    UNIQUE (neptun_code),
    PRIMARY KEY(neptun_code)
);

CREATE TABLE subject_groups (
    subject_group_id BIGINT NOT NULL AUTO_INCREMENT,
    group_number int(11) NOT NULL,
    subject_id varchar(255) NOT NULL,
    
    UNIQUE ( group_number, subject_id ),
    PRIMARY KEY( subject_group_id, subject_id )
);

CREATE TABLE user_status (
    subject_group_id BIGINT NOT NULL,
    neptun_code varchar(6) NOT NULL,
    is_teacher int(11) NOT NULL DEFAULT 0,
    application_request_status varchar(10) NOT NULL DEFAULT "PENDING",
    
    UNIQUE ( subject_group_id, neptun_code),
    FOREIGN KEY( neptun_code ) REFERENCES users( neptun_code ),
    FOREIGN KEY( subject_group_id ) REFERENCES subject_groups( subject_group_id )
);

CREATE TABLE practice_task_points (
    neptun_code varchar(6) NOT NULL,
    subject_group_id BIGINT NOT NULL,
    task_type varchar(255) NOT NULL,
    task_point float(11) NOT NULL DEFAULT 0,
    
    UNIQUE ( subject_group_id, neptun_code, task_type ),
    FOREIGN KEY( neptun_code ) REFERENCES users( neptun_code ),
    FOREIGN KEY( subject_group_id ) REFERENCES subject_groups( subject_group_id )
);

CREATE TABLE results (
    neptun_code varchar(6) NOT NULL,
    subject_group_id BIGINT NOT NULL,
    task_type varchar(255) NOT NULL,
    result float(11) NOT NULL DEFAULT 0,
    
    UNIQUE ( subject_group_id, neptun_code, task_type ),
    FOREIGN KEY( neptun_code ) REFERENCES users( neptun_code ),
    FOREIGN KEY( subject_group_id ) REFERENCES subject_groups( subject_group_id )
);

CREATE TABLE expectation_rules (
    subject_group_id BIGINT NOT NULL,
    task_type varchar(255) NOT NULL,
    is_better int(11) NOT NULL DEFAULT -1,
    minimum_for_pass int(11) NOT NULL DEFAULT 0,
    maximum_value int(11) NOT NULL DEFAULT 100,

    UNIQUE ( subject_group_id, task_type),
    FOREIGN KEY( subject_group_id ) REFERENCES subject_groups( subject_group_id )
);

CREATE TABLE task_due_to_date_table (
    subject_group_id BIGINT NOT NULL,
    task_type varchar(255) NOT NULL,
    due_to DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE ( subject_group_id, task_type),
    FOREIGN KEY( subject_group_id ) REFERENCES subject_groups( subject_group_id )
);

CREATE TABLE grade_table (
    subject_group_id BIGINT NOT NULL,
    pass_level_point int(11) NOT NULL DEFAULT 1,
    satisfactory_level_point int(11) NOT NULL DEFAULT 2,
    good_level_point int(11) NOT NULL DEFAULT 3,
    excellent_level_point int(11) NOT NULL DEFAULT 4,

    UNIQUE ( subject_group_id ),
    FOREIGN KEY( subject_group_id ) REFERENCES subject_groups( subject_group_id )

);

CREATE TABLE messages (
    neptun_code_from varchar(6) NOT NULL,
    neptun_code_to varchar(6) NOT NULL,
    message_id BIGINT NOT NULL AUTO_INCREMENT,
    belongs_to BIGINT NOT NULL DEFAULT 0,
    message_topic varchar(255) NOT NULL DEFAULT "",
    message_text varchar(2024) NOT NULL DEFAULT "",
    is_seen_by_receiver int(11) NOT NULL DEFAULT 0,
    is_removed_by_receiver int(11) NOT NULL DEFAULT 0,
    is_removed_by_sender int(11) NOT NULL DEFAULT 0,
    thread_count int(11) NOT NULL DEFAULT 1,
    sent_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    UNIQUE ( message_id ),
    FOREIGN KEY( neptun_code_from) REFERENCES users( neptun_code ),
    FOREIGN KEY( neptun_code_to) REFERENCES users( neptun_code )
);

INSERT INTO users VALUES("admin", "admin@example.hu", "$2y$10$9nSKotQ51hqlRaNt8AMaXOgCw97rLwvobEP8KuM7OC4cS3Ae7gixu", 1);
INSERT INTO users VALUES("AAAAAA", "aaaaaa@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("ABCABC", "abcabc@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("BBBBBB", "bbbbbb@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("CBACBA", "cbacba@example.hu", "$2y$10$fR6hVQ88X1R1uUZJm0CAROQ7HNkb0SA/klR6EV.mS4cf8YMtSaMva", 0);
INSERT INTO users VALUES("ALMA12", "alma12@example.hu", "$2y$10$1QGG.K.mP1AFMZ05clvezu5Jhj9Ol5sS5bm.qQCK2BmEB/jMXfJV.", 0);


INSERT INTO subject_groups VALUES(1, 0, "");
INSERT INTO subject_groups VALUES(2, 1, "i");
INSERT INTO subject_groups VALUES(3, 2, "ii");
INSERT INTO subject_groups VALUES(4, 2, "i");
INSERT INTO subject_groups VALUES(5, 3, "ii");


INSERT INTO user_status VALUES(2, "AAAAAA", 1, "APPROVED");
INSERT INTO user_status VALUES(3, "AAAAAA", 1, "APPROVED");
INSERT INTO user_status VALUES(4, "AAAAAA", 1, "APPROVED");
INSERT INTO user_status VALUES(5, "AAAAAA", 1, "APPROVED");
INSERT INTO user_status VALUES(2, "ALMA12", 1, "APPROVED");

INSERT INTO user_status VALUES(2, "ABCABC", 0, "WITHDRAWN");
INSERT INTO user_status VALUES(3, "ABCABC", 0, "APPROVED");
INSERT INTO user_status VALUES(4, "ALMA12", 0, "WITHDRAWN");
INSERT INTO user_status VALUES(2, "BBBBBB", 0, "APPROVED");
INSERT INTO user_status VALUES(5, "CBACBA", 0, "APPROVED");

INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type, task_point) VALUES("ABCABC", 2,"practice_task_1", 0.2); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"practice_task_2"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"practice_task_3"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"practice_task_4"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"practice_task_5"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"practice_task_6"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"practice_task_7"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"practice_task_8"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"practice_task_9"); 

INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type, task_point) VALUES("ABCABC", 3,"practice_task_1", 2); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type, task_point) VALUES("ABCABC", 3,"practice_task_2", 0.5); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"practice_task_3"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"practice_task_4"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"practice_task_5"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"practice_task_6"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"practice_task_7"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"practice_task_8"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"practice_task_9"); 

INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"practice_task_1"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"practice_task_2"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"practice_task_3"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"practice_task_4"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"practice_task_5"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"practice_task_6"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"practice_task_7"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"practice_task_8"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"practice_task_9"); 

INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type, task_point) VALUES("BBBBBB", 2,"practice_task_1", 5); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"practice_task_2"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"practice_task_3"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"practice_task_4"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"practice_task_5"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"practice_task_6"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"practice_task_7"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"practice_task_8"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"practice_task_9"); 

INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"practice_task_1"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"practice_task_2"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"practice_task_3"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"practice_task_4"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"practice_task_5"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"practice_task_6"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"practice_task_7"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"practice_task_8"); 
INSERT INTO practice_task_points(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"practice_task_9"); 


INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"extra");
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"practice_count"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"middle_term_exam"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"middle_term_exam_correction"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"final_term_exam"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"final_term_exam_correction"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"small_test_1"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"small_test_2"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"small_test_3"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"small_test_4"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"small_test_5"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"small_test_6"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"small_test_7"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"small_test_8"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"small_test_9"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 2,"small_test_10");

INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"extra");
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"practice_count"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"middle_term_exam"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"middle_term_exam_correction"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"final_term_exam"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"final_term_exam_correction"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"small_test_1"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"small_test_2"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"small_test_3"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"small_test_4"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"small_test_5"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"small_test_6"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"small_test_7"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"small_test_8"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"small_test_9"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ABCABC", 3,"small_test_10");

INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"extra");
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"practice_count"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"middle_term_exam"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"middle_term_exam_correction"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"final_term_exam"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"final_term_exam_correction"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"small_test_1"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"small_test_2"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"small_test_3"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"small_test_4"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"small_test_5"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"small_test_6"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"small_test_7"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"small_test_8"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"small_test_9"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("ALMA12", 4,"small_test_10");

INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"extra");
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"practice_count"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"middle_term_exam"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"middle_term_exam_correction"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"final_term_exam"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"final_term_exam_correction"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"small_test_1"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"small_test_2"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"small_test_3"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"small_test_4"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"small_test_5"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"small_test_6"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"small_test_7"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"small_test_8"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"small_test_9"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("BBBBBB", 2,"small_test_10");

INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"extra");
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"practice_count"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"middle_term_exam"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"middle_term_exam_correction"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"final_term_exam"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"final_term_exam_correction"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"small_test_1"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"small_test_2"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"small_test_3"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"small_test_4"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"small_test_5"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"small_test_6"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"small_test_7"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"small_test_8"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"small_test_9"); 
INSERT INTO results(neptun_code, subject_group_id, task_type) VALUES("CBACBA", 5,"small_test_10");

INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(2, "practice_count");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(2, "extra");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(2, "middle_term_exam");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(2, "final_term_exam");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(2, "middle_term_exam_correction");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(2, "final_term_exam_correction");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(2, "small_tests");

INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "middle_term_exam");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "final_term_exam");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "middle_term_exam_correction");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "final_term_exam_correction");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "small_test_1");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "small_test_2");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "small_test_3");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "small_test_4");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "small_test_5");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "small_test_6");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "small_test_7");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "small_test_8");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "small_test_9");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "small_test_10");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "practice_task_1");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "practice_task_2");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "practice_task_3");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "practice_task_4");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "practice_task_5");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "practice_task_6");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "practice_task_7");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "practice_task_8");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(2, "practice_task_9");

INSERT INTO grade_table(subject_group_id) VALUES(2);


INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(3, "practice_count");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(3, "extra");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(3, "middle_term_exam");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(3, "final_term_exam");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(3, "middle_term_exam_correction");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(3, "final_term_exam_correction");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(3, "small_tests");

INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "middle_term_exam");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "final_term_exam");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "middle_term_exam_correction");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "final_term_exam_correction");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "small_test_1");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "small_test_2");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "small_test_3");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "small_test_4");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "small_test_5");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "small_test_6");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "small_test_7");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "small_test_8");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "small_test_9");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "small_test_10");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "practice_task_1");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "practice_task_2");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "practice_task_3");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "practice_task_4");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "practice_task_5");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "practice_task_6");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "practice_task_7");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "practice_task_8");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(3, "practice_task_9");

INSERT INTO grade_table(subject_group_id) VALUES(3);


INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(4, "practice_count");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(4, "extra");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(4, "middle_term_exam");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(4, "final_term_exam");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(4, "middle_term_exam_correction");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(4, "final_term_exam_correction");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(4, "small_tests");

INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "middle_term_exam");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "final_term_exam");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "middle_term_exam_correction");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "final_term_exam_correction");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "small_test_1");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "small_test_2");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "small_test_3");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "small_test_4");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "small_test_5");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "small_test_6");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "small_test_7");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "small_test_8");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "small_test_9");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "small_test_10");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "practice_task_1");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "practice_task_2");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "practice_task_3");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "practice_task_4");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "practice_task_5");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "practice_task_6");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "practice_task_7");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "practice_task_8");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(4, "practice_task_9");

INSERT INTO grade_table(subject_group_id) VALUES(4);


INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(5, "practice_count");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(5, "extra");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(5, "middle_term_exam");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(5, "final_term_exam");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(5, "middle_term_exam_correction");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(5, "final_term_exam_correction");
INSERT INTO expectation_rules(subject_group_id, task_type) VALUES(5, "small_tests");

INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "middle_term_exam");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "final_term_exam");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "middle_term_exam_correction");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "final_term_exam_correction");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "small_test_1");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "small_test_2");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "small_test_3");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "small_test_4");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "small_test_5");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "small_test_6");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "small_test_7");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "small_test_8");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "small_test_9");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "small_test_10");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "practice_task_1");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "practice_task_2");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "practice_task_3");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "practice_task_4");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "practice_task_5");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "practice_task_6");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "practice_task_7");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "practice_task_8");
INSERT INTO task_due_to_date_table(subject_group_id, task_type) VALUES(5, "practice_task_9");

INSERT INTO grade_table(subject_group_id) VALUES(5);
