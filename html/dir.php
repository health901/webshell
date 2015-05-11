<?php

$dir = isset($_GET['dir']) ? $_GET['dir'] : '';
foreach ($data as $line => $type) {
    if ($line == '.') {
        continue;
    }
    if ($dir) {
        $link = preg_replace('/\/+/', '/', $dir . '/') . $line;
    } else {
        $link = $line;
    }
    if ($type == 'f') {
        $url = url('dir', 'download', array('f' => $link));
    } else {
        $url = url('dir', '', array('dir' => $link));
    }
    echo "<p><a href='{$url}'>{$line}</a></p>";
}
