<?php
/**
 * Game of Life in PHP
 *
 * Initial client for the modules
 *
 * @package webworker01\GameOfLife
 * @author webworker@live.com
 * @since PHP 5.4.x 1/21/14 5:17 PM
 * @copyright Copyright © ***REMOVED*** 2014
 */
session_start();

ini_set('display_errors', 'on');
error_reporting (E_ALL ^ E_NOTICE);

//Default autoload for my webworker01\GameOfLife modules
spl_autoload_register(function($class) {
    require_once getcwd().'\\library\\'.$class.'.php';
});

//Add composer autoloader
require 'vendor/autoload.php';

use webworker01\GameOfLife;

//See if we have a map stored already for the session
if (empty($_SESSION['map']) || $_GET['seed'] == 'true') {
    $map = new webworker01\GameOfLife\Map(100, 35);

    $map->seed();

    $_SESSION['map'] = serialize($map);
} else {
    $map = unserialize($_SESSION['map']);

    $map->tick();
}

//Temporary view
?>
<html>
<head>
    <style>
        body {
            background-color: #333;
            font-size: 14px;
            font-family: monospace, serif;
            margin: 0;
            padding: 0;
        }

        #menu {
            color: white;
            position:absolute;
            top:0;
            right:0;
        }

        #menu a, #menu a:visited {
            color: white;
        }

        #menu a:hover {
            color: #779FAA;
        }

        #map {
            margin: 30px auto;
            background-color: #CCC;
            border:1px solid black;
            width:800px;
        }
    </style>
</head>
<body>
    <div id="menu"><a href="./?seed=true">Seed</a> | <a href="./">Refresh</a></div>

    <div id="map">
        <?= $map; ?>
    </div>
</body>
</html>
