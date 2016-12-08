<?php

use Ajax\Semantic;

class ConfigController extends ControllerBase
{

	public function indexAction()
	{
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$servers=Server::find();
		$this->view->setVars(["servers"=>$servers]);
		
		$hosts=Host::find();
		$this->view->setVars(["hosts"=>$hosts]);
		
		$user = $this->session->auth;
		$user = User::findFirst($user["id"]);
		
		$virtualhosts=Virtualhost::find();
		$this->view->setVars(["virtualhosts"=>$virtualhosts,"user"=>$user]);
		
		$semantic=$this->semantic;
		
		$btnValider = $semantic->htmlButton("btnValider","Valider","ui green button")->getOnClick("Config/liste","#liste");
		$btnValider->addIcon("checkmark icon");
		$this->jquery->compile($this->view);
		
	}
	public function listeAction(){
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$host   = $this->request->getPost("host");
		}
		
		
		
		
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$servers=Server::find();
		$this->view->setVars(["servers"=>$servers]);
		
		$hosts=Host::find();
		$this->view->setVars(["hosts"=>$hosts]);
		
		$user = $this->session->auth;
		$user = User::findFirst($user["id"]);
		
		$virtualhosts=Virtualhost::find();
		$this->view->setVars(["virtualhosts"=>$virtualhosts,"user"=>$user,"host"=>$host]);
		
		$this->jquery->compile($this->view);
		
		
	}
	public function rebootAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$id  = $this->request->getPost("virtualhost");
		}
			$virtualhost = Virtualhost::findFirst($id);
			$this->view->setVars(["virtualhost"=>$virtualhost]);
				
			$propertys=Virtualhostproperty::findFirst($id);		
			$this->view->setVars(["propertys"=>$propertys]);
			
			
		
			$this->jquery->compile($this->view);
	

	}
	public function finAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$id  = $this->request->getPost("virtualhost");
		}
		
		
		
		
		$this->jquery->compile($this->view);
		
		
		
	}
	
	
}