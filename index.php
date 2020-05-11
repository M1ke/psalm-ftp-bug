<?php

require __DIR__.'/vendor/autoload.php';

$user = 'test';
$pass = 'abc123';
$host = 'ftp.example.com';

$ftp = new \Ftp("ftp://$user:$pass@$host");
$file = 'some-file.txt';
$save_file = __DIR__."/$file";
$ftp->get($save_file, $file, \Ftp::ASCII);

