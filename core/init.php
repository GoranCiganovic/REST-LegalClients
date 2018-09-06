<?php

define("DB_NAME", "database_name");
define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");

spl_autoload_register(function ($className) {
    require_once "library/{$className}.php";
});
