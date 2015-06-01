INSERT INTO auditories(auditory_number, auditory_type) VALUES (130, 1);
INSERT INTO auditories(auditory_number, auditory_type) VALUES (129, 1);
INSERT INTO auditories(auditory_number, auditory_type) VALUES (127, 2);

INSERT INTO subjects(subject_name) VALUES('Організація баз данных');
INSERT INTO subjects(subject_name) VALUES('Web-програмування та web-дизайн');
INSERT INTO subjects(subject_name) VALUES('ЧМІ');

INSERT INTO teachers(teacher_name, teacher_surname, teacher_last_name, teacher_phone) VALUES('Юрій', 'Яриніч', 'Олегович', '0680000000');
INSERT INTO teachers(teacher_name, teacher_surname, teacher_last_name, teacher_phone) VALUES('Артем', 'Авраменко', 'Сергійович', '0680000000');
INSERT INTO teachers(teacher_name, teacher_surname, teacher_last_name, teacher_phone) VALUES('Юлія', 'Гребенович', 'Євгенівна', '0680000000');

INSERT INTO teacher_subject(teacher_code, subject_code) VALUES(1, 1);
INSERT INTO teacher_subject(teacher_code, subject_code) VALUES(2, 2);
INSERT INTO teacher_subject(teacher_code, subject_code) VALUES(3, 3);

INSERT INTO groups(group_name, group_course, group_students_count) VALUES('КЕ-12', 2012, 13);
INSERT INTO groups(group_name, group_course, group_students_count) VALUES('КМ-12', 2012, 12);
INSERT INTO groups(group_name, group_course, group_students_count) VALUES('КІ-12', 2012, 15);
INSERT INTO groups(group_name, group_course, group_students_count) VALUES('КС-12', 2012, 15);

INSERT INTO event_group(event_code, group_code)  VALUES(7,1);
INSERT INTO event_group(event_code, group_code)  VALUES(7,2);
INSERT INTO event_group(event_code, group_code)  VALUES(7,3);
INSERT INTO event_group(event_code, group_code)  VALUES(8,2);
INSERT INTO event_group(event_code, group_code)  VALUES(8,1);
INSERT INTO event_group(event_code, group_code)  VALUES(4,2);
INSERT INTO event_group(event_code, group_code)  VALUES(4,3);
INSERT INTO event_group(event_code, group_code)  VALUES(5,1);

INSERT INTO events(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, repeat_type) VALUES ('01.05.2015', '30.06.2015', '09:00', '11:00', 1, 1, 1, 130, 1);
INSERT INTO event_group VALUES(1, 1);
INSERT INTO event_group VALUES(1, 3);

INSERT INTO events(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, repeat_type) VALUES ('01.03.2015', '31.05.2015', '11:00', '13:00', 1, 2, 2, 130, 2);
INSERT INTO event_group VALUES(2, 2);
INSERT INTO event_group VALUES(2, 1);
INSERT INTO everyday VALUES(2, 2);

INSERT INTO events(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, repeat_type) VALUES ('01.04.2015', '30.04.2015', '14:00', '16:00', 1, 3, 3, 129, 2);
INSERT INTO event_group VALUES(3, 2);
INSERT INTO event_group VALUES(3, 3);
INSERT INTO everyday VALUES(1, 3);

INSERT INTO events(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, repeat_type) VALUES ('01.05.2015', '31.05.2015', '8:00', '10:00', 1, 2, 2, 130, 3);
INSERT INTO event_group VALUES(4, 2);
INSERT INTO event_group VALUES(4, 1);
INSERT INTO everyweek VALUES(b'0011001', 2, 4);

INSERT INTO events(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, repeat_type) VALUES ('01.02.2015', '15.03.2015', '09:00', '11:00', 2, 1, 1, 127, 3);
INSERT INTO event_group VALUES(5, 2);
INSERT INTO event_group VALUES(5, 1);
INSERT INTO event_group VALUES(5, 3);
INSERT INTO everyweek VALUES(b'1100110', 1, 5);