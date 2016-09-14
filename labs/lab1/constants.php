<?php
//git test
define("CSV_FILE_NAME", "curr_enroll_fall.csv");

define("CURRENT_TIME", time());

define("DATABASE_NAME", strtoupper(get_current_user()) . '_Courses');

define("DEBUG", false);

define("LINE_BREAK", "\n");

define("SPACE"," ");

define("TODAY", date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))));

define("WEB_MASTER", 'ltrinity@uvm.edu');

// path setup constants
$_SERVER = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);

define ("SERVER", htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8"));

define ("PHP_SELF", htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8"));

$PATH_PARTS = pathinfo(PHP_SELF);

//define ("BASE_PATH", DOMAIN . $PATH_PARTS['dirname'] . "/");

?>
