<?php
define('SITE_NAME','Easy Meal Admin');
define('FRONT_SITE_NAME','Easy Meal');
define('FRONT_SITE_PATH','http://localhost/easymeal/');
define('ADMIN_SITE_PATH','http://localhost/easymeal/admin/');
define('DELIVERY_SITE_PATH','http://localhost/easymeal/delivery_person/');

//define('FRONT_SITE_PATH_USER','http://localhost/easymeal/user/');
define('SERVER_IMAGE',$_SERVER['DOCUMENT_ROOT']."/easymeal/");
define('SERVER_DISH_IMAGE',SERVER_IMAGE."media/dish/");
define('SITE_DISH_IMAGE',FRONT_SITE_PATH."media/dish/");
define('SERVER_BANNER_IMAGE',SERVER_IMAGE."media/banner/");
define('SITE_BANNER_IMAGE',FRONT_SITE_PATH."media/banner/");
define('USER_PROFILE_IMAGE',SERVER_IMAGE."media/profile/");

?>