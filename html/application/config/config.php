 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| WARNING: You MUST set this value!
|
| If it is not set, then CodeIgniter will try guess the protocol and path
| your installation, but due to security concerns the hostname will be set
| to $_SERVER['SERVER_ADDR'] if available, or localhost otherwise.
| The auto-detection mechanism exists only for convenience during
| development and MUST NOT be used in production!
|
| If you need to allow multiple domains, remember that this file is still
| a PHP script and you can easily do that on your own.
|
*/
$config['base_url'] = 'https://iohub.tv/';

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
$config['index_page'] = '';

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of 'REQUEST_URI' works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
| 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
| 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
|
| WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
*/
$config['uri_protocol']	= 'PATH_INFO';

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| https://codeigniter.com/user_guide/general/urls.html
*/
$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'english';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
| See http://php.net/htmlspecialchars for a list of supported charsets.
|
*/
$config['charset'] = 'UTF-8';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = FALSE;

/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| https://codeigniter.com/user_guide/general/core_classes.html
| https://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MY_';

/*
|--------------------------------------------------------------------------
| Composer auto-loading
|--------------------------------------------------------------------------
|
| Enabling this setting will tell CodeIgniter to look for a Composer
| package auto-loader script in application/vendor/autoload.php.
|
|	$config['composer_autoload'] = TRUE;
|
| Or if you have your vendor/ directory located somewhere else, you
| can opt to set a specific path as well:
|
|	$config['composer_autoload'] = '/path/to/vendor/autoload.php';
|
| For more information about Composer, please visit http://getcomposer.org/
|
| Note: This will NOT disable or override the CodeIgniter-specific
|	autoloading (application/config/autoload.php)
*/
$config['composer_autoload'] = FALSE;

/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify which characters are permitted within your URLs.
| When someone tries to submit a URL with disallowed characters they will
| get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| The configured value is actually a regular expression character group
| and it will be executed as: ! preg_match('/^[<permitted_uri_chars>]+$/i
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| By default CodeIgniter enables access to the $_GET array.  If for some
| reason you would like to disable it, set 'allow_get_array' to FALSE.
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string 'words' that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| You can also pass an array with threshold levels to show individual error types
|
| 	array(2) = Debug Messages, without Error Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 4;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ directory. Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Log File Extension
|--------------------------------------------------------------------------
|
| The default filename extension for log files. The default 'php' allows for
| protecting the log files via basic scripting, when they are to be stored
| under a publicly accessible directory.
|
| Note: Leaving it blank will default to 'php'.
|
*/
$config['log_file_extension'] = '';

/*
|--------------------------------------------------------------------------
| Log File Permissions
|--------------------------------------------------------------------------
|
| The file system permissions to be applied on newly created log files.
|
| IMPORTANT: This MUST be an integer (no quotes) and you MUST use octal
|            integer notation (i.e. 0700, 0644, etc.)
*/
$config['log_file_permissions'] = 0644;

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Error Views Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/views/errors/ directory.  Use a full server path with trailing slash.
|
*/
$config['error_views_path'] = '';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/cache/ directory.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Cache Include Query String
|--------------------------------------------------------------------------
|
| Whether to take the URL query string into consideration when generating
| output cache files. Valid options are:
|
|	FALSE      = Disabled
|	TRUE       = Enabled, take all query parameters into account.
|	             Please be aware that this may result in numerous cache
|	             files generated for the same page over and over again.
|	array('q') = Enabled, but only take into account the specified list
|	             of query parameters.
|
*/
$config['cache_query_string'] = FALSE;

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class, you must set an encryption key.
| See the user guide for more info.
|
| https://codeigniter.com/user_guide/libraries/encryption.html
|
*/
$config['encryption_key'] = 'EDCV^FR5tgb7u8%';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_driver'
|
|	The storage driver to use: files, database, redis, memcached
|
| 'sess_cookie_name'
|
|	The session cookie name, must contain only [0-9a-z_-] characters
|
| 'sess_expiration'
|
|	The number of SECONDS you want the session to last.
|	Setting to 0 (zero) means expire when the browser is closed.
|
| 'sess_save_path'
|
|	The location to save sessions to, driver dependent.
|
|	For the 'files' driver, it's a path to a writable directory.
|	WARNING: Only absolute paths are supported!
|
|	For the 'database' driver, it's a table name.
|	Please read up the manual for the format with other session drivers.
|
|	IMPORTANT: You are REQUIRED to set a valid save path!
|
| 'sess_match_ip'
|
|	Whether to match the user's IP address when reading the session data.
|
|	WARNING: If you're using the database driver, don't forget to update
|	         your session table's PRIMARY KEY when changing this setting.
|
| 'sess_time_to_update'
|
|	How many seconds between CI regenerating the session ID.
|
| 'sess_regenerate_destroy'
|
|	Whether to destroy session data associated with the old session ID
|	when auto-regenerating the session ID. When set to FALSE, the data
|	will be later deleted by the garbage collector.
|
| Other session cookie settings are shared with the rest of the application,
| except for 'cookie_prefix' and 'cookie_httponly', which are ignored here.
|
*/
$config['sess_driver'] = 'files';

$config['sess_cookie_name'] = 'ks_sessions';
$config['sess_expiration'] = 72000;
$config['sess_save_path'] = FCPATH.'application/ci_sessions/';
$config['sess_match_ip'] = FALSE;
$config['sess_use_database'] = TRUE;
$config['sess_table_name'] = 'ks_sessions';
$config['sess_match_useragent'] = TRUE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix'   = Set a cookie name prefix if you need to avoid collisions
| 'cookie_domain'   = Set to .your-domain.com for site-wide cookies
| 'cookie_path'     = Typically will be a forward slash
| 'cookie_secure'   = Cookie will only be set if a secure HTTPS connection exists.
| 'cookie_httponly' = Cookie will only be accessible via HTTP(S) (no javascript)
|
| Note: These settings (with the exception of 'cookie_prefix' and
|       'cookie_httponly') will also affect sessions.
|
*/
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= TRUE;

/*
|--------------------------------------------------------------------------
| Standardize newlines
|--------------------------------------------------------------------------
|
| Determines whether to standardize newline characters in input data,
| meaning to replace \r\n, \r, \n occurrences with the PHP_EOL value.
|
| This is particularly useful for portability between UNIX-based OSes,
| (usually \n) and Windows (\r\n).
|
*/
$config['standardize_newlines'] = FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
| 'csrf_regenerate' = Regenerate token on every submission
| 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
*/
$config['csrf_protection'] = false;
$config['csrf_token_name'] = 'csrftestname';
$config['csrf_cookie_name'] = 'csrfcookiename';
$config['csrf_expire'] = 720000;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();
$config['csrf_exclude_uris'] = array('user/logout','admin/uploadGroupPic','admin/getIPAdressByWowaz','admin/getApplicationStreams','Groupadmin/getIPAdressByWowaz','Groupadmin/getApplicationStreams','Groupadmin/targetdelete','Groupadmin/groupadmintargetdelete','Groupuser/getApplicationStreams','Groupadmin/getApplicationStreams','admin/wowzastatus','admin/deleteUser','admin/deleteGroup','admin/wowzauptime','admin/wowzadelete','admin/wowzareboot','Groupuser/wowzadelete','Groupuser/wowzadelete1','groupadmin/wowzadelete','groupadmin/wowzadelete1','groupadmin/wowzadelete5','admin/wowzadelete5','admin/activateUser','Groupuser/wowzadelete5','groupadmin/userDelete','groupadmin/deleteUser','Groupuser/getIPAdressByWowaz','Groupuser/applicationdelete','Groupadmin/deleteGroup','Groupuser/applicationdelete1','groupadmin/applicationdelete','Groupadmin/applicationdelete1','admin/lockscreen','admin/unlock','admin/copyApplication','admin/deleteApplication','admin/deleteTarget','admin/copyTarget','Groupuser/targetdelete','Groupuser/targetdelete1','Groupadmin/createtarget','admin/wowzarefresh','admin/wowzadisable','admin/wowzaActions','admin/groupActions','admin/userActions','admin/appActions','admin/targetActions','admin/getStreamURL','admin/targetStartStop','admin/targetStatus','admin/encodersdelete','admin/encoderActions','admin/channelStartStop','admin/getNDISource','admin/templateDelete','admin/templateEnableDisable','groupadmin/lockscreen','groupadmin/unlock','admin/encoderTemplateActions','admin/encoderRefresh','admin/encoderReboot','admin/encoderUptime','admin/channelActions','admin/applicaitonRestart','admin/getCharts','admin/getChartData','admin/channelDelete','admin/applicationStatus','admin/copyChannel','admin/channelsLockUnlock','admin/appsLockUnlock','admin/getTwitchGames','admin/getlogs','admin/clearlogs','admin/restoreArchiveApp','admin/restoreArchiveTarget','admin/restoreArchiveChannel','admin/getGatewayNDISource','admin/createBank','admin/updateBankName','admin/createGatewayChannel','admin/deletGatewayChannel','admin/deletBank','admin/updateGatewayChannel','admin/gatewayStartStop','admin/updateGatewayRTMPChannel','admin/updateGatewaySRTChannel','admin/updateGatewaySDIChannel','admin/lockUnlockBank','admin/extractSources','home/test','admin/updateBankNameOnly','api/saveChannelSchedule','api/saveTargetSchedule','channels/updateChannel');
$config['sess_match_useragent'] = FALSE;
/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| Only used if zlib.output_compression is turned off in your php.ini.
| Please do not use it together with httpd-level output compression.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or any PHP supported timezone. This preference tells
| the system whether to use your server's local time as the master 'now'
| reference, or convert it to the configured one timezone. See the 'date
| helper' page of the user guide for information regarding date handling.
|
*/
$config['time_reference'] = 'gmt';

/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
| Note: You need to have eval() enabled for this to work.
|
*/
$config['rewrite_short_tags'] = FALSE;

/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy
| IP addresses from which CodeIgniter should trust headers such as
| HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify
| the visitor's IP address.
|
| You can use both an array or a comma-separated list of proxy addresses,
| as well as specifying whole subnets. Here are a few examples:
|
| Comma-separated:	'10.0.1.200,192.168.5.0/24'
| Array:		array('10.0.1.200', '192.168.5.0/24')
*/
$config['startChannelPath'] = 'https://iohub.tv/api/startchannels';
$config['stopChannelPath'] = 'https://iohub.tv/api/stopchannels';
$config['proxy_ips'] = '';
$config['financial_year_last'] = '5';

$config['roles_id'] = array('1'=>'Admin','2'=>'GroupAdmin','3'=>'User');
$config['roles'] = array('admin'=>1,'groupadmin'=>2,'user'=>3);
$config['rol'] = array('Admin'=>1,'GroupAdmin'=>2,'User'=>3);
$config['status'] = array('0', '1');
$config['isProduction'] = FALSE;
$config['ServerIP'] = '152.115.45.143';
$config['ServerUser'] = 'ksm';
$config['ServerPassword'] = 'purse968*bites';


$config['SDITONDI']['input_type'] = "-f decklink";
$config['SDITONDI']['output_options'] = "";
$config['SDITONDI']['format_code'] = "";
$config['SDITONDI']['output_type'] = "-f libndi_newtek";

$config['SDITORTMP']['input_type'] = "-f decklink";
$config['SDITORTMP']['output_options'] = "";
$config['SDITORTMP']['format_code'] = "";
$config['SDITORTMP']['output_type'] = "-f flv";

$config['SDITOMPEGRTP']['input_type'] = "-f decklink";
$config['SDITOMPEGRTP']['output_options'] = "";
$config['SDITOMPEGRTP']['format_code'] = "";
$config['SDITOMPEGRTP']['output_type'] = "-f mpegts";

$config['SDITOMPEGUDP']['input_type'] = "-f decklink";
$config['SDITOMPEGUDP']['output_options'] = "";
$config['SDITOMPEGUDP']['format_code'] = "";
$config['SDITOMPEGUDP']['output_type'] = "-f mpegts";

$config['SDITOMPEGSRT']['input_type'] = "-f decklink";
$config['SDITOMPEGSRT']['output_options'] = "";
$config['SDITOMPEGSRT']['format_code'] = "";
$config['SDITOMPEGSRT']['output_type'] = "-f mpegts";

$config['NDITOSDI']['input_type'] = "-f libndi_newtek";
$config['NDITOSDI']['output_options'] = "";
$config['NDITOSDI']['format_code'] = "";
$config['NDITOSDI']['output_type'] = "-f decklink";

$config['NDITONDI']['input_type'] = "-f libndi_newtek";
$config['NDITONDI']['output_options'] = "";
$config['NDITONDI']['format_code'] = "";
$config['NDITONDI']['output_type'] = "-f libndi_newtek";

$config['NDITORTMP']['input_type'] = "-f libndi_newtek";
$config['NDITORTMP']['output_options'] = "";
$config['NDITORTMP']['format_code'] = "";
$config['NDITORTMP']['output_type'] = "-f flv";

$config['NDITOMPEGRTP']['input_type'] = "-f libndi_newtek";
$config['NDITOMPEGRTP']['output_options'] = "";
$config['NDITOMPEGRTP']['format_code'] = "";
$config['NDITOMPEGRTP']['output_type'] = "-f mpegts";

$config['NDITOMPEGUDP']['input_type'] = "-f libndi_newtek";
$config['NDITOMPEGUDP']['output_options'] = "";
$config['NDITOMPEGUDP']['format_code'] = "";
$config['NDITOMPEGUDP']['output_type'] = "-f mpegts";

$config['NDITOMPEGSRT']['input_type'] = "-f libndi_newtek";
$config['NDITOMPEGSRT']['output_options'] = "";
$config['NDITOMPEGSRT']['format_code'] = "";
$config['NDITOMPEGSRT']['output_type'] = "-f mpegts";

$config['RTMPTOSDI']['input_type'] = "-f flv";
$config['RTMPTOSDI']['output_options'] = "";
$config['RTMPTOSDI']['format_code'] = "";
$config['RTMPTOSDI']['output_type'] = "-f decklink";

$config['RTMPTONDI']['input_type'] = "-f flv";
$config['RTMPTONDI']['output_options'] = "";
$config['RTMPTONDI']['format_code'] = "";
$config['RTMPTONDI']['output_type'] = "-f libndi_newtek";

$config['RTMPTORTMP']['input_type'] = "-f flv";
$config['RTMPTORTMP']['output_options'] = "";
$config['RTMPTORTMP']['format_code'] = "";
$config['RTMPTORTMP']['output_type'] = "-f flv";

$config['RTMPTOMPEGRTP']['input_type'] = "-f flv";
$config['RTMPTOMPEGRTP']['output_options'] = "";
$config['RTMPTOMPEGRTP']['format_code'] = "";
$config['RTMPTOMPEGRTP']['output_type'] = "-f mpegts";

$config['RTMPTOMPEGUDP']['input_type'] = "-f flv";
$config['RTMPTOMPEGUDP']['output_options'] = "";
$config['RTMPTOMPEGUDP']['format_code'] = "";
$config['RTMPTOMPEGUDP']['output_type'] = "-f mpegts";

$config['RTMPTOMPEGSRT']['input_type'] = "-f flv";
$config['RTMPTOMPEGSRT']['output_options'] = "";
$config['RTMPTOMPEGSRT']['format_code'] = "";
$config['RTMPTOMPEGSRT']['output_type'] = "-f mpegts";

$config['MPEGRTPTOSDI']['input_type'] = "-f mpegts";
$config['MPEGRTPTOSDI']['output_options'] = "";
$config['MPEGRTPTOSDI']['format_code'] = "";
$config['MPEGRTPTOSDI']['output_type'] = "-f decklink";

$config['MPEGRTPTONDI']['input_type'] = "-f mpegts";
$config['MPEGRTPTONDI']['output_options'] = "";
$config['MPEGRTPTONDI']['format_code'] = "";
$config['MPEGRTPTONDI']['output_type'] = "-f libndi_newtek";

$config['MPEGRTPTORTMP']['input_type'] = "-f mpegts";
$config['MPEGRTPTORTMP']['output_options'] = "";
$config['MPEGRTPTORTMP']['format_code'] = "";
$config['MPEGRTPTORTMP']['output_type'] = "-f flv";

$config['MPEGRTPTOMPEGRTP']['input_type'] = "-f mpegts";
$config['MPEGRTPTOMPEGRTP']['output_options'] = "";
$config['MPEGRTPTOMPEGRTP']['format_code'] = "";
$config['MPEGRTPTOMPEGRTP']['output_type'] = "-f mpegts";

$config['MPEGUDPTOSDI']['input_type'] = "-f mpegts";
$config['MPEGUDPTOSDI']['output_options'] = "";
$config['MPEGUDPTOSDI']['format_code'] = "";
$config['MPEGUDPTOSDI']['output_type'] = "-f decklink";

$config['MPEGUDPTONDI']['input_type'] = "-f mpegts";
$config['MPEGUDPTONDI']['output_options'] = "";
$config['MPEGUDPTONDI']['format_code'] = "";
$config['MPEGUDPTONDI']['output_type'] = "-f libndi_newtek";

$config['MPEGUDPTORTMP']['input_type'] = "-f mpegts";
$config['MPEGUDPTORTMP']['output_options'] = "";
$config['MPEGUDPTORTMP']['format_code'] = "";
$config['MPEGUDPTORTMP']['output_type'] = "-f flv";

$config['MPEGUDPTOMPEGUDP']['input_type'] = "-f mpegts";
$config['MPEGUDPTOMPEGUDP']['output_options'] = "";
$config['MPEGUDPTOMPEGUDP']['format_code'] = "";
$config['MPEGUDPTOMPEGUDP']['output_type'] = "-f mpegts";

$config['MPEGSRTTOSDI']['input_type'] = "-f mpegts";
$config['MPEGSRTTOSDI']['output_options'] = "";
$config['MPEGSRTTOSDI']['format_code'] = "";
$config['MPEGSRTTOSDI']['output_type'] = "-f decklink";

$config['MPEGSRTTONDI']['input_type'] = "-f mpegts";
$config['MPEGSRTTONDI']['output_options'] = "";
$config['MPEGSRTTONDI']['format_code'] = "";
$config['MPEGSRTTONDI']['output_type'] = "-f libndi_newtek";

$config['MPEGSRTTORTMP']['input_type'] = "-f mpegts";
$config['MPEGSRTTORTMP']['output_options'] = "";
$config['MPEGSRTTORTMP']['format_code'] = "";
$config['MPEGSRTTORTMP']['output_type'] = "-f flv";

$config['MPEGSRTTOMPEGSRT']['input_type'] = "-f mpegts";
$config['MPEGSRTTOMPEGSRT']['output_options'] = "";
$config['MPEGSRTTOMPEGSRT']['format_code'] = "";
$config['MPEGSRTTOMPEGSRT']['output_type'] = "-f mpegts";


$config['HTTPLIVETOSDI']['input_type'] = "";
$config['HTTPLIVETOSDI']['output_options'] = "";
$config['HTTPLIVETOSDI']['format_code'] = "";
$config['HTTPLIVETOSDI']['output_type'] = "-f decklink";

$config['HTTPLIVETONDI']['input_type'] = "";
$config['HTTPLIVETONDI']['output_options'] = "";
$config['HTTPLIVETONDI']['format_code'] = "";
$config['HTTPLIVETONDI']['output_type'] = "-f libndi_newtek";

$config['HTTPLIVETORTMP']['input_type'] = "";
$config['HTTPLIVETORTMP']['output_options'] = "";
$config['HTTPLIVETORTMP']['format_code'] = "";
$config['HTTPLIVETORTMP']['output_type'] = "-f flv";

$config['HTTPLIVETOMPEGRTP']['input_type'] = "";
$config['HTTPLIVETOMPEGRTP']['output_options'] = "";
$config['HTTPLIVETOMPEGRTP']['format_code'] = "";
$config['HTTPLIVETOMPEGRTP']['output_type'] = "-f mpegts";

$config['HTTPLIVETOMPEGUDP']['input_type'] = "";
$config['HTTPLIVETOMPEGUDP']['output_options'] = "";
$config['HTTPLIVETOMPEGUDP']['format_code'] = "";
$config['HTTPLIVETOMPEGUDP']['output_type'] = "-f mpegts";

$config['HTTPLIVETOMPEGSRT']['input_type'] = "";
$config['HTTPLIVETOMPEGSRT']['output_options'] = "";
$config['HTTPLIVETOMPEGSRT']['format_code'] = "";
$config['HTTPLIVETOMPEGSRT']['output_type'] = "-f mpegts";
