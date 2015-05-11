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
  query := 'SELECT * FROM events WHERE events.event_date_start <= NOW() AND events.event_date_end >= NOW()';

  FOR oneRow IN EXECUTE query
    LOOP
      IF (oneRow.repeat_type <> 'single') THEN
        query_r := 'SELECT * FROM ' || oneRow.repeat_type || ' WHERE events.event_code=' || oneRow.event_code;

        FOR twoRow IN EXECUTE query_r
          LOOP

          END LOOP;
      ELSE

      END IF;
    END LOOP;
END; $$
LANGUAGE PLPGSQL;