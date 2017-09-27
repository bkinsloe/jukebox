<?php

setcookie('desktop-admin', '', time() - 3600, '/', null);
setcookie('mobile-admin', '', time() - 3600, '/', null);
setcookie('username', '', time() - 3600, '/', null);

header('location: /jukebox');
