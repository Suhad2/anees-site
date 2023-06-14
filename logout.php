<?php

unset($_COOKIE['tokenUser']);
setcookie('tokenUser', null , -1 , '/');

unset($_COOKIE['loginCookies']);
setcookie('loginCookies', null , -1 , '/');

unset($_COOKIE['nameuser']);
setcookie('nameuser', null , -1 , '/');

echo'<meta http-equiv="refresh" content="0; url=index.php"/>';
?>