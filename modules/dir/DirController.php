<?php

class DirController extends Controller {

    public $pages = array(
        "目录" => '',
    );

    public function action() {
        $dir = isset($_GET['dir']) ? $this->qvar($_GET['dir']) : '__DIR__';
        $this->var['dir'] = $dir;
        $script = $this->loadScript();
        $_data = $this->runShell($script);
        if (!$_data) {
            return;
        }
        $_data = unserialize($_data);
        $data = array();
        if ($this->config['shellEncode'] != 'UTF-8') {

            foreach ($_data as $k => $v) {
                $data[mb_convert_encoding($k, 'UTF-8', $this->config['shellEncode'])] = $v;
            }
        }
        $this->render(null, $data);
    }

}
