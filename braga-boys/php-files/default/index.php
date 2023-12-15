<?php
// default.xss.bragaboys.ctfh2hc2023.win
$headers = getallheaders();
foreach ($_COOKIE as $key=>$val){
    if ($key != 'flag'){
        header("HTTP/1.1 403 Forbidden");
        echo "Somente o cookie flag é permitido\n";
        exit(1);
    }
}

foreach ($headers as $name => $value) {
    if (strlen($value) > 700) {
        header("HTTP/1.1 413 Request Entity Too Large");
        echo "The request header $name is too large to be processed: $name \n" . substr($value, 0, 16 ) . " ... " .  substr($value, floor(strlen($value) / 2), 10) . " ... "  . substr($value, -10).  "\n";
        exit(1);
    }
}

if (count($_GET) == 0) {
    show_source(__FILE__);
    exit(1);
}


if (isset($_GET['nome'])) {
    $nome = json_encode($_GET['nome']);
} else {
    $nome = 'sem nome';
}

# html encode <>
$nome = str_replace('<', '&lt;', $nome);
$nome = str_replace('>', '&gt;', $nome);

echo "ola $nome, bem vindo ao vuln";

echo "
<script> 
let dumb_console = {};
dumb_console.log = function(nome,idade){console.log(nome,idade)};
dumbb_console.log('".$nome."',18);
</script>";
?>
