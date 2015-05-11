<?php

class DirController extends Controller
{
	public $pages = array(
		"目录"=>'',
		);

	public function action(){
		$this->render('dir');
	}
}