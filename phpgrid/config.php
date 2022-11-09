<?php

// PHP Grid database connection settings, Only need to update these in new project

define("PHPGRID_DBTYPE","mysqli"); // mysql,oci8(for oracle),mssql,postgres,sybase
define("PHPGRID_DBHOST","ec2-52-90-113-228.compute-1.amazonaws.com");
define("PHPGRID_DBUSER","zazudb2");
define("PHPGRID_DBPASS","zazu2023");
define("PHPGRID_DBNAME","bd_andree");

// database charset
define("PHPGRID_DBCHARSET","utf8");

// Basepath for lib
define("PHPGRID_LIBPATH",dirname(__FILE__).DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR);