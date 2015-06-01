CREATE DOMAIN event_date_not_null as date NOT NULL;
CREATE DOMAIN event_time_not_null as time NOT NULL;
CREATE DOMAIN event_date_nullable as date NULL;
CREATE DOMAIN event_time_nullable as time NULL;
CREATE DOMAIN name_field as VARCHAR(50) NOT NULL;
CREATE DOMAIN smallint_not_null_domain as SMALLINT NOT NULL;
CREATE DOMAIN domain_integer_not_null as INTEGER NOT NULL;

CREATE TABLE Events(
    event_code serial,
    event_date_start date NOT NULL,
    event_date_end date NOT NULL,
    event_time_start event_time_not_null,
    event_time_end event_time_not_null,

    event_type domain_integer_not_null,

    teacher_code domain_integer_not_null,
    subject_code domain_integer_not_null,
    auditory_number domain_integer_not_null,

    repeat_type domain_integer_not_null,

    PRIMARY KEY(event_code)
);

CREATE TABLE Groups(
    group_code serial,
    group_name name_field,
    group_course domain_integer_not_null,
    group_students_count domain_integer_not_null,
    PRIMARY KEY(group_code)
);

CREATE TABLE Event_group(
    event_code domain_integer_not_null,
    group_code domain_integer_not_null
);

CREATE TABLE Teachers(
    teacher_code serial,
    teacher_name name_field,
    teacher_surname name_field,
    teacher_last_name name_field,
    teacher_phone VARCHAR (11),
    PRIMARY KEY(teacher_code)
);

CREATE TABLE Subjects(
    subject_code serial,
    subject_name name_field,
    PRIMARY KEY(subject_code)
);

CREATE TABLE Teacher_subject(
    teacher_code domain_integer_not_null,
    subject_code domain_integer_not_null
);

CREATE TABLE Auditories(
    auditory_number domain_integer_not_null UNIQUE,
    auditory_type smallint_not_null_domain,
    PRIMARY KEY(auditory_number)
);

CREATE TABLE Exceptions(
    event_replace_date_start event_date_nullable,
    event_replace_date_end event_date_nullable,
    event_replace_time_start event_time_nullable,
    event_replace_time_end event_time_nullable,
    parent_event domain_integer_not_null,
    event_code domain_integer_not_null,

    FOREIGN KEY(event_code) REFERENCES Events(event_code),
    FOREIGN KEY(parent_event) REFERENCES Events(event_code)
);

CREATE TABLE Everyday(
  everyDay smallint_not_null_domain,
  event_code integer,
  FOREIGN KEY(event_code) REFERENCES Events(event_code)
);

CREATE TABLE Everyweek(
  everyDay BIT(7) NOT NULL,
  everyWeek smallint_not_null_domain,
  event_code integer,
  FOREIGN KEY(event_code) REFERENCES Events(event_code)
);

CREATE TABLE Everymonth(
  repeatedAt smallint_not_null_domain,
  everyMonth smallint_not_null_domain,
  event_code integer,
  FOREIGN KEY(event_code) REFERENCES Events(event_code)
);

ALTER TABLE Events ADD CONSTRAINT event_fg_key_to_teacher FOREIGN KEY (teacher_code) REFERENCES Teachers;
ALTER TABLE Events ADD CONSTRAINT event_fg_key_to_subject FOREIGN KEY (subject_code) REFERENCES Subjects;
ALTER TABLE Events ADD CONSTRAINT event_fg_key_to_auditory FOREIGN KEY (auditory_number) REFERENCES Auditories;

ALTER TABLE Teacher_subject ADD CONSTRAINT teacher_subject_group_fg_key_to_event FOREIGN KEY (teacher_code) REFERENCES Teachers MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE Teacher_subject ADD CONSTRAINT teacher_subject_fg_key_to_group FOREIGN KEY (subject_code) REFERENCES Subjects MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION DEFERRABLE INITIALLY IMMEDIATE;