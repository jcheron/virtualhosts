<?php
use Phalcon\Mvc\View;
use Ajax\semantic\html\collections\form\HtmlFormTextarea;
class ServeurVirtualHostController extends ControllerBase{

	public function indexAction(){
	$this->secondaryMenu($this->controller,$this->action);
	$this->tools($this->controller,$this->action);
	
	$this->jquery->compile($this->view);
	}
	
	public function hostsAction($user=NULL){
		$this->loadMenus();
		$virtualhosts=Virtualhost::find();
		$list=$this->semantic->htmlList("lst-hosts");
		foreach ($virtualhosts as $virtualhost){
			$item=$list->addItem(["icon"=>"add","header"=>$virtualhost->getName(),"description"=>$virtualhost->getConfig()]);
			$item->addToProperty("data-ajax", $virtualhost->getId());
		}
		$list->setHorizontal();
	
	
		$list->setSelection();
	
	
	
		$this->jquery->getOnClick("#lst-hosts .item","Serveur/servers","#servers",["attr"=>"data-ajax"]);
		$this->jquery->compile($this->view);
	
	}
	
}