<?php
/* Data base details */
$dsn='mysql:host=localhost;dbname=playat'; //DSN
$db_user='playat'; //DB username 
$db_pass='playat@123'; //DB password 
$driver='Custom'; //Integration driver
$db_prefix=''; //prefix used for tables in database
$uid='569b4fb8e09c0'; //Any random unique number

$connected='YES'; //only for custom installation

$PATH = 'chat/'; // Use this only if you have placed the freichat folder somewhere else
$installed=true; //make it false if you want to reinstall freichat
$admin_pswd='playatchat'; //backend password 

$debug = false;
$custom_error_handling='YES'; // used during custom installation

$use_cookie='false';

/* email plugin */
$smtp_username = 'test.pbtvm@gmail.com';
$smtp_password = 'biju9895661';

$force_load_jquery = 'NO';

/* Custom driver */
$usertable='playat_user'; //specifies the name of the table in which your user information is stored.
$row_username='firstname'; //specifies the name of the field in which the user's name/display name is stored.
$row_userid='id'; //specifies the name of the field in which the user's id is stored (usually id or userid)


$avatar_table_name='members'; //specifies the table where avatar information is stored
$avatar_column_name='avatar'; //specifies the column name where the avatar url is stored
$avatar_userid='id'; //specifies the userid  to the user to get the user's avatar
$avatar_reference_user='id'; //specifies the reference to the user to get the user's avatar in user table 
$avatar_reference_avatar='id'; //specifies the reference to the user to get the user's avatar in avatar
$avatar_field_name=$avatar_column_name; //to avoid unnecessary file changes , *do not change
