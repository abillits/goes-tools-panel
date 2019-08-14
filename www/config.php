<?php
/* (very basic) Security */
define('AJAX_KEY_SALT', 'M)(@#*M_@IE_@)(IKF2-[foi-203mic-fie2[fi]])'); //Change to something unique
/* Start Page */
define('HOME', 'product-viewer'); //DEFAUlT: product-viewer - product-viewer, nws-viewer, server, OR signal
/* Settings for Signal Status page */
define('SIGNAL_STATUS_CHART_MINUTES', 10); //DEFAULT: 10
define('SIGNAL_STATUS_FILES_NUM', 10); //DEFAULT: 10
/* Animation Generating Method
Notes:
1) client animation generation method generates animations via javascript in the browser. Requires a decent client machine (ie: some phones may not work) and produces inferior quality animations but puts less strain on the server. Recommended for anything less than a PI.
2) server animation generation method generates animations via ffmpeg (see installation instructions). Works with any client machine and roduces better quality animations but puts a strain on server cpu/memory. Recommended for PI 4 (1GB works, 2GB is better, 4GB not really needed).
3) Using the server animation generation method on anything less than a PI 4 will likely result in dropped GOES packets.
*/
define('ANIMATION_GEN', 'client'); //DEFAULT: client - client OR server
/* Max size of animations in pixels */
define('ANIMATION_MAX_HEIGHT', 720); //DEFAULT: 720 - Keep to 720 or lower for client animation generation, 1000 for server generation on anything less than a PI 4 - set to false to disable
define('ANIMATION_MAX_WIDTH', 720); //DEFAULT: 720 - Keep to 720 or lower for client animation generation, 1000 for server generation on anything less than a PI 4 - set to false to disable
/* ffmpeg threads */
define('FFMPEG_THREADS', 1); //DEFAULT 1 - Set this to 2 for a PI 4 - leave at 1 for anything else
/* Old File Cleanup */
define('CLEAN_OLDER_THAN_X_HOURS', 24); //DEFAULT 24 - Set to whatever you wish/have disk space for - set to false to disable
?>
