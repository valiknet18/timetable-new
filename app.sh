#!/usr/bin/env bash

psql timetable -f app/sql/drop.sql
psql timetable -f app/sql/create.sql
psql timetable -f app/sql/seed.sql
psql timetable -f app/sql/store_function.sql