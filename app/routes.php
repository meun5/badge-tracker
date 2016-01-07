<?php

//Home Route
require INC_ROOT . "/app/routes/home.php";

//Authentication and Registation Routes
require INC_ROOT . "/app/routes/auth/login.php";
require INC_ROOT . "/app/routes/auth/logout.php";
require INC_ROOT . "/app/routes/auth/register.php";

//Adminastration Routes
require INC_ROOT . "/app/routes/admin/overview.php";

//Gear Display and Checkout
require INC_ROOT . "/app/routes/gear/list.php";
require INC_ROOT . "/app/routes/gear/checkout.php";

//Gear Managment
require INC_ROOT . "/app/routes/admin/gear/add.php";
require INC_ROOT . "/app/routes/admin/gear/export.php";

//Site Managment
require INC_ROOT . "/app/routes/admin/site/settings.php";

//Event Managment
require INC_ROOT . "/app/routes/admin/events/add.php";

//Event Display
require INC_ROOT . "/app/routes/events/event.php";
