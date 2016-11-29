<?php

class ServeurController extends ControllerBase{
	
	public function indexAction(){
		$this->secondaryMenu($this->controller, $this->action);
		$this->tools($this->controller, $this->action);
		
		
		$dd=$this->semantic->htmlDropdown("dd");
		$dd->asSelect("vh")->asSearch("vh");
		$virtualhosts=Virtualhost::find();
		
		

		
		$dd->fromDatabaseObjects($virtualhosts, function($vh){
			return $vh->getName();
		});
	
			$table=$this->semantic->htmlTable("infos",0,3);
			$table->setHeaderValues(["Serveur","Configuration","Configuration file"]);
			foreach ($virtualhosts as $vh){
				$server=$vh->getServer();
				$table->addRow([$server->getName(),$server->getConfig(),$server->getConfigFile()]);
			}
			
		$this->jquery->compile($this->view);
		
	}

}