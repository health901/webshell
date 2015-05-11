<?php
$dir = $VAR['dir'];
$f = scandir($dir);
$d = array();
foreach ($f as $a) {
    if (is_dir(preg_replace('/\/+/', '/', $dir . '/') . $a)) {
        $d[$a] = 'd';
    } else {
        $d[$a] = 'f';
    }
}
echo serialize($d);
