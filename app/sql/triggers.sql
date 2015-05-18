CREATE TRIGGER insert_in_event_everyday AFTER INSERT ON everyday
    FOR each row EXECUTE PROCEDURE insert_in_event_everyday();

