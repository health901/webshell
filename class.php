<?php
class App
{
	public $config;
	public $controllers = array();
	protected $controllerData;

	public function __construct($config = null){
		$this->config = $config;
		$this->loadControllers();
	}

	public function run(){
		$default = 'index';
		$c = isset($_GET['c']) ? $_GET['c'] : $default;
		if(isset($this->controllers[$c])){
			$this->controllerData = $this->controllers[$c]->run();
		}
		return $this;
	}

	public function index(){
		if(isset($_GET['json'])){
			require(__DIR__.'/html/json.php');
			return;
		}
		require(__DIR__.'/html/index.php');
	}

	public function getPages(){
		$pages = array();
		foreach ($this->controllers as $c => $controllers) {
			if($controllers->pages)
				$pages[$c] = $controllers->pages;
		}
		return $pages;
	}

	protected function loadControllers(){
		$dir = __DIR__.'/controller/';
		$files = scandir($dir);
		foreach ($files as $file) {
			if($file == '.' || $file == '..')
				continue;
			if(preg_match('/(\w+)\.php$/', $file,$match)){
				require_once($dir.$file);
				$class = $match[1]."Controller";
				$this->controllers[strtolower($match[1])] = new $class();
			}
		}
	}

}
class Controller
{
	public $pages = array();

	public function run(){
		$a = isset($_GET['a']) ? $_GET['a'] : '';
		$method = $a.'Action';
		if(method_exists($this, $a.'Action')){
			ob_start();
			$this->$method();
			$data = ob_get_clean();
			return $data;
		}
	}
}