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
	}
	
}