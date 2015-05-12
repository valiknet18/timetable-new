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
  target_date := '2015-05-03';
--   query := 'SELECT * FROM events WHERE events.event_date_start <= NOW() AND events.event_date_end >= NOW()';

  FOR oneRow IN SELECT * FROM events WHERE events.event_date_start <= NOW() AND events.event_date_end >= NOW()
    LOOP
      IF (oneRow.repeat_type <> 'single') THEN

        CASE oneRow.repeat_type
          WHEN 'everyday' then
            query_r := 'SELECT * FROM everyday WHERE events."event_code"= ' || oneRow.event_code;
          WHEN 'everyweek' then
            query_r := '';
          WHEN 'everymonth' then
            query_r := '';
        END CASE;

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

