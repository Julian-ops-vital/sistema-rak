<?php
session_start();
session_unset();
session_destroy();
header("Location: /rak/sistema-rak/frontend/pages/login.html");
exit();