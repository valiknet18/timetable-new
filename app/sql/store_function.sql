DROP FUNCTION get_event_by_day();

CREATE OR REPLACE FUNCTION get_event_by_day()
  RETURNS VOID AS $$
DECLARE
  query text;
  query_r text;
  oneRow RECORD;
  twoRow RECORD;
  target_date DATE;
BEGIN
  target_date := '''2015-05-03''';
  query := 'SELECT * FROM events WHERE events.event_date_start <= ' || target_date || ' AND events.event_date_end >= NOW()';

  FOR oneRow IN SELECT * FROM events WHERE events.event_date_start <= NOW() AND events.event_date_end >= NOW()
    LOOP
      IF (oneRow.repeat_type <> 'single') THEN
-- x & 0x1  = 0x1
      query_r := 'SELECT * FROM everyday WHERE everyday."event_code"= ' || oneRow.event_code;
--            CASE oneRow.repeat_type
--           WHEN 'everyday' then
--             query_r := 'SELECT * FROM everyday WHERE events."event_code"= ' || oneRow.event_code;
-- --           WHEN 'everyweek' then
-- --             query_r := '';
-- --           WHEN 'everymonth' then
-- --             query_r := '';
--         END CASE;
--
        FOR twoRow IN EXECUTE query_r
          LOOP

          END LOOP;
      ELSE

      END IF;
    END LOOP;
END; $$
LANGUAGE PLPGSQL;

/*
SELECT all events in day that in interval
  get repeat type

  if single and day start == current day > insert into lessons
  if everyday >
      num_current_day % everyday == 0 and current day > insert into lessons
  if everyweek >
      parse bit, if day with this bit == 1 and num_current_week % everyweek == 0 and current day > insert into lessons
  if everymonth >
      if target day == repeatedat and current_month % everymonth > insert into lessons
*/

DROP FUNCTION insert_in_event_everyday();

CREATE OR REPLACE FUNCTION insert_in_event_everyday(data_event_date_start date, data_event_date_end date, data_event_time_start time, data_event_time_end time, data_event_type INTEGER, data_teacher_code INTEGER, data_subject_code integer, data_auditory_number integer, data_everyday small_int_not_null_domain)
    RETURNS void AS $$

BEGIN
  WITH events_event_code AS (
    INSERT INTO events (event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number)
    VALUES (data_event_date_start, data_event_date_end, data_event_time_start, data_event_time_end, data_event_type, data_teacher_code, data_subject_code, data_auditory_number) RETURNING event_code
  )
  UPDATE everyday SET everyday."everyday" = data_everyday
    FROM events_event_code
  WHERE everyday."event_code" = events_event_code.event_code;
END; $$
LANGUAGE PLPGSQL

