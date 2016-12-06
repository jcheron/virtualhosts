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
		
		$virtualhosts=Virtualhost::find();
		$list=$this->semantic->htmlList("lst-virtualhosts");
		foreach ($virtualhosts as $virtualhost){
			$item=$list->addItem(["icon"=>"add","header"=>$virtualhost->getName(),"description"=>$virtualhost->getServer()->getName()]);
			$item->addToProperty("data-ajax", $virtualhost->getId());
		}
		
		$this->jquery->compile($this->view);
	}

}
