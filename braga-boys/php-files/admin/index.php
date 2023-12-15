<?php
// admin.xss.bragaboys.ctfh2hc2023.win
$FLAG = getenv('FLAG');
$SECRET = getenv('SECRET');

if (isset($_GET['secret']) && $_GET['secret'] == $SECRET) {
    header("Set-Cookie: flag=$FLAG; path=/; domain=.xss.bragaboys.ctfh2hc2023.win; HttpOnly; SameSite=Lax");
    echo 'cookie set for admin';
    exit(0);
}

echo 'Voce não é o admin';

?>