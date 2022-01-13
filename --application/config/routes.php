<?php

defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'map';

$route['prousers'] = 'auth/prousers';

$route['normalusers'] = 'auth/get_by_userType/' . USER;

$route['view-parents'] = 'auth/get_by_userType/' . PARENT;

$route['view-schools'] = 'auth/get_by_userType/' . SCHOOL;

$route['superadmin'] = 'auth/login/';

$route['login'] = 'user/login';

$route['signup'] = 'user/signup';

$route['reportnest'] = 'home/reportnest';

$route['admin'] = 'auth/login';

$route['complete'] = 'map/complete';

$route['simple'] = 'map/simple';

$route['suive'] = 'map/suive';





$route['waseema'] = 'home/reportnest';

$route['contact-with-pro'] = 'map/contactpro';

$route['notifications'] = 'user/notifications';



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









$route['view_users'] = 'auth/view_users';

$route['view_users/(:num)'] = 'auth/view_users/$1';



$route['editprivacy'] = 'cms/edit/1';

$route['editaboutus'] = 'cms/edit/3';

$route['schools'] = 'auth/view_users/' . SCHOOL;

//$route['admins'] = 'auth/view_users/'.ADMIN;

$route['super-admins'] = 'auth/view_users/' . SUPER_ADMIN;

$route['add-user'] = 'auth/create_user';

$route['privacy'] = 'page/privacy';

$route['aboutus'] = 'page/aboutus';

$route['terms'] = 'page/terms';



$route['add-bus'] = 'bus/saveData';

//$route['add-rout/(:num)'] = 'bus/rout/saveData/$1';







$route['404_override'] = '';

$route['translate_uri_dashes'] = FALSE;



require_once(BASEPATH . 'database/DB' . EXT);



$db = &DB();



$query = $db->get('app_routes');



$result = $query->result();



foreach ($result as $row) {



    $route[$row->slug]                 = $row->controller;



    $route[$row->slug . '/:any']         = $row->controller;



    $route[$row->controller]           = 'error404';



    $route[$row->controller . '/:any']   = 'error404';
}
