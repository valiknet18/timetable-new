#!/usr/bin/env bash

psql timetable -f app/sql/drop.sql
psql timetable -f app/sql/create.sql
psql timetable -f app/sql/store_function.sql
psql timetable -f app/sql/triggers.sql
psql timetable -f app/sql/seed.sql
