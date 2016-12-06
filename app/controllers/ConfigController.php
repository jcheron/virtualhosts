<?php

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
		
		
		
		$this->jquery->compile($this->view);
		
		//
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
			$virtualhost = Virtualhost::findFirst($id);
			
		}
		
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$propertys=Virtualhostproperty::find();
		
		$attente=0;
		
		if($attente ==0){
		$this->view->setVars(["virtualhost"=>$virtualhost,"propertys"=>$propertys,"attente"=>$attente]);
		$attente=1;
		$this->jquery->compile($this->view);
		}
		
		
		if($attente ==1){
			sleep(10);
		$this->view->setVars(["attente"=>$attente]);
		$this->jquery->compile($this->view);
		}
			
		
		
	}
	
	
}