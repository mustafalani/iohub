<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'home';
$route['dashboard'] = "admin/dashboard";
$route['extra'] = "admin/extra";
$route['help'] = "admin/help";
$route['streamviewer'] = "admin/streamviewer";
$route['configuration'] = "admin/configuration";
$route['createwowza'] = "admin/createwowza";
$route['addEncoderes'] = "admin/addEncoderes";
$route['createtemplate'] = "admin/createtemplate";
$route['clients'] = "admin/clients";
$route['creategroup'] = "admin/creategroup";
$route['createuser'] = "admin/createuser";
$route['createuser/:num'] = "admin/createuser/:num";
$route['createuser/:num/:num'] = "admin/createuser/:num/:num";
$route['applications'] = "admin/applications";
$route['createapplication'] = "admin/createapplication";
$route['createtarget'] = "admin/createtarget";
$route['channels'] = "admin/channels";
$route['createchannel'] = "admin/createchannel";
$route['updategroup/:num'] = "admin/updategroup/:num";
$route['updateuser/:num'] = "admin/updateuser/:num";
$route['updatewowzaengin/:num'] = "admin/updatewowzaengin/:num";
$route['editEncoder/:num'] = "admin/editEncoder/:num";
$route['updateencodingtemplate/:num'] = "admin/updateencodingtemplate/:num";
$route['updateapp/:num'] = "admin/updateapp/:num";
$route['editTarget/:num'] = "admin/editTarget/:num";
$route['updatechannel/:num/(.*)'] = "admin/updatechannel/:num/(.*)";
$route['allgroupuser/:num'] = "admin/allgroupuser/:num";
$route['internalServerError'] = "admin/internalServerError";
$route['notFound'] = "admin/notFound";
$route['privacy'] = "admin/privacy";
$route['terms'] = "admin/terms";
$route['report/dblog'] = "admin/logs";
$route['404_override'] = 'admin/notFound';
$route['archive'] = 'admin/archive';
$route['500_override'] = 'admin/internalServerError';
$route['translate_uri_dashes'] = FALSE;
$route['seo/sitemap\.xml'] = "seo/sitemap";
$route['createtarget/:num'] = "admin/createtarget/:num";
$route['periscope'] = "admin/periscope";
$route['twitchcasting'] = "admin/twitchcasting";
//$route['gateway'] = "admin/gateway";
$route['twitch'] = "admin/twitch";
$route['addgateways'] = "admin/addgateways";
$route['schedule'] = "admin/schedule";
$route['workflows'] = "admin/workflows";
$route['workflowlist'] = "admin/workflowlist";
$route['workflows/(.*)'] = "admin/workflows";

$route['editGateway/:num'] = "admin/editGateway/:num";
$route['editnebula/:num'] = "admin/editnebula/:num";

$route['addasset/:num'] = "admin/createassets";
$route['jobs'] = "nebula/jobs";
$route['assets'] = "admin/asset";
$route['assets/:num'] = "admin/asset";
$route['editasset/:num/:num'] = "nebula/editasset/:num/:num";

$route['rundowns'] = "admin/rundowns";
$route['createnebula'] = 'admin/createnebula';
$route['createrundown'] = 'nebula/createrundown';
$route['editrundown'] = 'nebula/editrundown';
$route['editrundown/:num'] = 'nebula/editrundown/:num';
$route['temp'] = 'nebula/temp';
$route['iotstream'] = 'extras/iotstream';
$route['createIoTStream'] = 'extras/createIoTStream';
$route['editiotstream/:num'] = 'extras/editiotstream/:num';
