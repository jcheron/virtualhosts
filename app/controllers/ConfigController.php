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
		$host=$this->request->getPost("#host");
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
		
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$idVH  = $this->request->getPost("virtualhost");

		}
		
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		

			$virtualhost = Virtualhost::findFirst("id = ".$idVH);
			$this->view->setVars(["virtualhost"=>$virtualhost]);
			

			$this->jquery->compile($this->view); 
			
	

	}
	public function rebootServAction(){
	
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$idServ  = $this->request->getPost("server");
	
		}
	
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
	
	
	
		$server = Server::findFirst("id = ".$idServ);
		$this->view->setVars(["server"=>$server]);
			
	
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
	public function finServAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$id  = $this->request->getPost("server");
		}
	
	
	
	
		$this->jquery->compile($this->view);
	
	
	
	}
	
	
}