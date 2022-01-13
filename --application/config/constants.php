<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define('APP_NAME','Free Live Bees');
define('APPKEY','P@ssw0rd');


define('TBL_POST','post');
define('NOIMG','images/no-image.png');
define('TBL_SLIDER','slider');
/***************************/
define('SUPER_ADMIN',1);
define('ADMIN',2);
define('PRO_USER',3);
define('NORMAL_USER',4);
define('USER',4);
/*************************/
//define('USER_ID',user_id());

define('APP_EMAIL','noreply@free-livebees.org');
define('FROM_HEADING','FLB');
define('DEFAULT_CURRENCY_SYMBOL','$');
define('STRIPE_PUBLISH_KEY','pk_test_cWfGTcc1aNFIc8Tz3Mp3exL5');
define('STRIPE_SECRETE_KEY','sk_test_6pWhoJIxtluIsHSVt9NObsuN');

	

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
 define('SHOW_DEBUG_BACKTRACE', TRUE);

define('ALLOWED_TYPES', 'jpg|gif|PNG|png|jpeg|JPG|mp4|MP4'); // Allwoed Types


/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
 define('FILE_READ_MODE', 0644);
 define('FILE_WRITE_MODE', 0666);
 define('DIR_READ_MODE', 0755);
 define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                            ? null : define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                      ? null : define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')        ? null : define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')   ? null : define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                    ? null : define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')               ? null : define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')             ? null : define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')        ? null : define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');


defined('EXIT_SUCCESS')        ? null :define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          ? null :define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         ? null :define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   ? null :define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  ? null :define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') ? null :define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     ? null :define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       ? null :define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      ? null :define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      ? null :define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code






/************Status types*************/
define('ACTIVE', 1);
define('NOW',date('y-m-d H:i:s'));

/************user types*************/
define('ADMIN_USER', 1);
define('MEMBER_USER', 2);
/************DB TABLES types*************/

define('TBL_CAT', 'categories');
define('TBL_CAT_IMAGES', 'categories_images');


/************DB TABLES types*************/

define('TBL_USER', 'users');
define('TBL_USERS_LEVELS','users_rights');


