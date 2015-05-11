<?php
function url($c, $a = null, $p = array()) {
    $params['c'] = $c;
    if ($a) {
        $params['a'] = $a;
    }
    $params['shell'] = $_GET['shell'];
    $params = array_merge($params,$p);
    return 'index.php?' . http_build_query($params);
}

