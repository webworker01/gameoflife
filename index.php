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
$runTimeStart = microtime();
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
    $map = new webworker01\GameOfLife\Map(267, 100);

    $map->seed();
} else {
    $map = unserialize($_SESSION['map']);

    $map->tick();
}

//Save the state of the map
$_SESSION['map'] = serialize($map);

/**
 * Function used to calc the scripts running time from the recorded microseconds
 * @param int $mt_old First time
 * @param int $mt_new Second time
 * @return int Difference between times in seconds
 */
function diff_microtime($mt_old,$mt_new) {
    list($old_usec, $old_sec) = explode(' ',$mt_old);
    list($new_usec, $new_sec) = explode(' ',$mt_new);
    $old_mt = ((float)$old_usec + (float)$old_sec);
    $new_mt = ((float)$new_usec + (float)$new_sec);
    return $new_mt - $old_mt;
}



//Temporary view
?>
<html>
<head>
    <title>Game of Life in PHP</title>
    <style>
        body {
            background-color: #333;
            font-size: 14px;
            font-family: monospace, serif;
            color: #FFF;
            margin: 0;
            padding: 0;
        }

        #menu {
            position:absolute;
            top:0;
            right:0;
        }

        #menu a, #menu a:visited {
            color: #FFF;
            text-decoration: underline;
            cursor: pointer;
        }

        #menu a:hover {
            color: #779FAA;
        }

        #map {
            color: #000;
            font-size: 5px;
            margin: 30px auto;
            background-color: #CCC;
            border:1px solid black;
            width:800px;
        }

        #runtime {
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
    <div id="menu"><a id="seedLink" href="./?seed=true">Seed</a> | <a id="pause">Pause <span id="timeLeft"></span></a></div>

    <div id="map">
        <?= $map; ?>
    </div>

<script>
    var autoReload = true;
    var reloadInterval = 500;

    $(function() {
        $('#timeLeft').html(reloadInterval/100);

        $('#seedLink').click(function() {
            autoReload = false;
        })

        $('#pause').click(function() {
            autoReload = false;
            $('#pause').replaceWith('<a id="reload" href="./">Start</a>');
        })

        //Timer to reload the page
        var i = setInterval(function() {
            reloadInterval -= 100;

            if (reloadInterval < 1 && autoReload) {
                location.reload();
                clearInterval(i);

                $('#menu').replaceWith('<div id="menu">Loading...</div>');
            } else {
                $('#timeLeft').html(reloadInterval/100);
            }
        }, 100);
    });
</script>

    <div id="runtime"><?= (1000 * number_format(diff_microtime($runTimeStart, microtime()), 3)); ?>ms</div>
</body>
</html>
