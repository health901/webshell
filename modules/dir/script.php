<?php
$dir = str_replace('\\','/',realpath($VAR['dir']));
$f = scandir($dir);
$d = array('path' => $dir);
foreach ($f as $a) {
    if (is_dir(preg_replace('/\/+/', '/', $dir . '/') . $a)) {
        $d['files'][$a] = array('type'=>'folder');
    } else {
        $d['files'][$a] = array('type'=>'file');
    }
}
echo serialize($d);
