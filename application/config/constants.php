<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('HASH_COST_LOG2', 		8);
define('HASH_PORTABLE', 		FALSE);

define('COOKIE_TTL_HOUR',		24);

define('VISA_VALIDITY',			30);
define('MAX_STAY_DAYS',			90);

define('VISA_TEMPLATE',			'/data/file/visa_file/template/visa_template.docx');

define('VISA_PATH',				'/data/file/visa_file/');
define('SCAN_PATH',				'/data/file/scan_file/');
define('CAPTCHA_PATH',			'/data/file/captcha/');

define('REDIS_DEFAULT', 		'/tmp/redis_6379.sock');

define('SCAN_DOMAIN',			'http://file.vanuatuvisa.cn/scan_file/');
define('VISA_DOMAIN',			'http://file.vanuatuvisa.cn/visa_file/');
define('CAPTCHA_DOMAIN',		'http://file.vanuatuvisa.cn/captcha/');

define('VISA_BACKGROUND', 		'/data/file/resource/visa_background.jpg');
define('VISA_FONT_TYPE', 		'/data/file/resource/arialuni.ttf');

define('ILLEGAL_USER',			0);
define('SYSTEM_ADMIN',			1);
define('EMBASSY_ADMIN',			128);
define('AGENCY_ADMIN',			256);
define('ORDINARY_USER',			1024);

define('ACCOUNT_CANCELLED',		-1);
define('ACCOUNT_INACTIVE',		0);
define('ACCOUNT_NORMAL',		1);

define('NEGATIVE_OVERFLOW',		-128);
define('APPLY_TRASHED',			-1);
define('APPLY_NOTFINISHED',		0);
define('AGENCY_SELECTED',		1);
define('BASIC_UPDATED',			2);
define('PASSPORT_UPDATED',		3);
define('TRAVEL_UPDATED',		4);
define('COMPLEMENT_UPDATED',	5);
define('PICTURE_UPLOADED',		6);
define('PAYMENT_UPDATED',		7);
define('APPLY_WAITING',			11);
define('APPLY_NOTPASSED',		21);
define('APPLY_PASSED',			31);
define('APPLY_PAID',			41);
define('APPLY_REJECTED',		91);
define('APPLY_ACCEPTED',		101);
define('APPLY_EXPIRED',			125);
define('VISA_EXPIRED',			126);
define('POSITIVE_OVERFLOW',		127);

/* End of file constants.php */
/* Location: ./application/config/constants.php */