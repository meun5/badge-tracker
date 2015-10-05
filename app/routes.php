<?php

//Home Route
require INC_ROOT . '/app/routes/home.php';

//Authentication and Registation Routes
require INC_ROOT . '/app/routes/auth/login.php';
require INC_ROOT . '/app/routes/auth/logout.php';
require INC_ROOT . '/app/routes/auth/register.php';

//Adminastration Routes
require INC_ROOT . '/app/routes/admin/overview.php';

//Scout Administration
require INC_ROOT . '/app/routes/admin/scouts/add.php';

//Badge Management
require INC_ROOT . '/app/routes/admin/badges/add.php';

//Gear Display and Checkout
require INC_ROOT . '/app/routes/gear/list.php';
require INC_ROOT . '/app/routes/gear/checkout.php';

//Gear Managment
require INC_ROOT . '/app/routes/admin/gear/add.php';

//Site Managment
require INC_ROOT . '/app/routes/admin/site/settings.php';
