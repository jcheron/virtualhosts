<?php
use Phalcon\Mvc\View;
class ListhostvirtualController extends ControllerBase {
	
	public function listhvAction($user=NULL){
		$this->loadMenus();
		$hosts=Host::find();
		$list=$this->semantic->htmlList("lst-hosts");
		foreach ($hosts as $host){
			$item=$list->addItem(["icon"=>"add","header"=>$host->getName(),"description"=>$host->getIpv4()]);
			$item->addToProperty("data-ajax", $host->getId());
		}
		$list->setHorizontal();
		$this->jquery->compile($this->view);
}
}