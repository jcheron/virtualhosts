<?php
class ListvirtualhostparservController extends ControllerBase{
	

	public function listServerAction($user=NULL){
		$this->loadMenus();
		$servers=Server::find();
	
		//$item->addPopup("Propriétés","test popup");
		$list=$this->semantic->htmlList("lst-servers");
		foreach ($servers as $server){
			$item=$list->addItem(["icon"=>"cloud","header"=>$server->getName()]);
			$item->addPopup("Propriétés","test popup");
			$item->addToProperty("data-ajax", $server->getId());
		}
		$list->setHorizontal();
		$this->jquery->compile($this->view);
}
}