INSERT INTO auditories(auditory_number, auditory_type) VALUES (130, 0);
INSERT INTO auditories(auditory_number, auditory_type) VALUES (129, 0);
INSERT INTO auditories(auditory_number, auditory_type) VALUES (127, 0);


INSERT INTO everyday(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, everyday)
VALUES('2015-04-25', '2015-05-03', '08:00:00', '10:00:00', 0, 1, 1, 130, 3);

INSERT INTO everyday(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, everyday)
VALUES('2015-04-20', '2015-05-10', '13:00:00', '15:00:00', 0, 2, 2, 127, 3);

INSERT INTO everyweek(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, everyday, everyweek)
VALUES('2015-04-11', '2015-05-20', '08:00:00', '10:00:00', 0, 1, 1, 127, B'0001001', 2);

INSERT INTO everyweek(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, everyday, everyweek)
VALUES('2015-03-10', '2015-05-15', '12:00:00', '15:00:00', 0, 3, 3, 129, B'1000001', 2);

INSERT INTO everymonth(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, repeatedat, everyweek)
VALUES('2015-04-11', '2015-05-12', '08:00:00', '10:00:00', 0, 2, 2, 130, 3, 2);

INSERT INTO everymonth(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, repeatedat, everyweek)
VALUES('2015-04-12', '2015-05-01', '11:00:00', '14:00:00', 0, 1, 1, 129, 1, 2);

INSERT INTO events(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number)
VALUES('2015-02-13', '2015-05-12', '08:00:00', '10:00:00', 0, 2, 2, 130);

INSERT INTO events(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number)
VALUES('2015-05-01', '2015-05-05', '11:00:00', '14:00:00', 0, 1, 1, 129);

INSERT INTO groups(group_name, group_course, group_students_count) VALUES('КЕ-12', 3, 13);
INSERT INTO groups(group_name, group_course, group_students_count) VALUES('КМ-12', 3, 12);
INSERT INTO groups(group_name, group_course, group_students_count) VALUES('КІ-12', 3, 15);
INSERT INTO groups(group_name, group_course, group_students_count) VALUES('КС-12', 3, 15);

INSERT INTO subjects(subject_name) VALUES('Організація баз данных');
INSERT INTO subjects(subject_name) VALUES('Web-програмування та web-дизайн');
INSERT INTO subjects(subject_name) VALUES('ЧМІ');

INSERT INTO teachers(teacher_name, teacher_surname, teacher_last_name, teacher_phone) VALUES('Юрій', 'Яриніч', 'Олегович', '0680000000');
INSERT INTO teachers(teacher_name, teacher_surname, teacher_last_name, teacher_phone) VALUES('Артем', 'Авраменко', 'Сергійович', '0680000000');
INSERT INTO teachers(teacher_name, teacher_surname, teacher_last_name, teacher_phone) VALUES('Юлія', 'Гребенович', 'Євгенівна', '0680000000');

INSERT INTO teacher_subject(teacher_code, subject_code) VALUES(1, 1);
INSERT INTO teacher_subject(teacher_code, subject_code) VALUES(2, 2);
INSERT INTO teacher_subject(teacher_code, subject_code) VALUES(3, 3);