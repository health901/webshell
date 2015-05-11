<?php

class ShellController extends Controller {

    public $pages = array(
        "执行命令" => '',
    );

    public function action() {
        $this->render('shell');
    }

    public function execAction() {
        if (!isset($_POST['shell'])) {
            return;
        }
        $this->var['shell'] = $_POST['shell'];
        $script = $this->loadScript('shell_shell');
        $data = $this->runShell($script);
        if ($this->config['shellEncode'] != 'UTF-8') {
            $data = mb_convert_encoding($data, 'UTF-8', $this->config['shellEncode']);
        }

        echo $data;
    }

}
