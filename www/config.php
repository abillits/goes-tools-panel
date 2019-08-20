<?php
/* (very basic) Security */
define('AJAX_KEY_SALT', 'M)(@#*M_@IE_@)(IKF2-[foi-203mic-fie2[fi]])'); //Change to something unique
/* Start Page */
define('HOME', 'product-viewer'); //DEFAUlT: product-viewer - product-viewer, nws-viewer, server, OR signal
/* Settings for Signal Status page */
define('SIGNAL_STATUS_CHART_MINUTES', 10); //DEFAULT: 10
define('SIGNAL_STATUS_FILES_NUM', 10); //DEFAULT: 10
/* Max size of animations in pixels */
define('ANIMATION_MAX_HEIGHT', 2000); //DEFAULT: 2000 - set to false to disable
define('ANIMATION_MAX_WIDTH', 2000); //DEFAULT: 2000 - set to false to disable
/* ffmpeg threads */
define('FFMPEG_THREADS', 2); //DEFAULT 2 - Set this to 1 if you generate a lot of 4+ hour full disk images.
/* Old File Cleanup */
define('CLEAN_OLDER_THAN_X_HOURS', 24); //DEFAULT 24 - Set to whatever you wish/have disk space for - set to false to disable
/* Custom products */
//custom_product($src_dir,$dst_dir,$crop_x,$crop_y,$crop_w,$crop_h,$dst_w,$dst_h);
/* Custom product examples (comment out, edit, or remove) */
custom_product("data/goes16/fd/ch13_enhanced","data/goes16/se/ch13_enhanced",1422,718,1600,900,1920,1080); //takea a crop from full disk image
custom_product("data/goes16/fd/ch13_enhanced","data/goes16/al/ch13_enhanced",1799,879,800,450,1920,1080); //takea a smaller crop from full disk image and enlarges it

?>
