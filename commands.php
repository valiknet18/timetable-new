#!/usr/bin/php
<?php
    shell_exec('su postgres');

    switch($argv) {
        case 'load-db':
            break;

        case 'load-functions':
            break;

        case 'load-triggers':
            break;

        case 'load-fixtures':
            break;
    }
exit(0);