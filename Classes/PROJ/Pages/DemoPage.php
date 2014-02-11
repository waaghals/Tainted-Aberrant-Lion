<?php
namespace PROJ\Pages;

class DemoPage extends MainPage {
	public function getContent() {
		$v = new \PROJ\View\DemoView();
		$r = $v->getContent();

		$DC = \PROJ\Controller\DemoController::instance();
		$r .= $DC->DoDemo();

		return $r;
	}
}
?>