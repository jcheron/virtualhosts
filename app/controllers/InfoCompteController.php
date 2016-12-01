<?php
class InfoCompteController extends ControllerBase{
	public function indexAction(){
		
	$this->secondaryMenu($this->controller,$this->action);
	$this->tools($this->controller,$this->action);
	
	$this->jquery->compile($this->view);
	}
	public function ModifInfoAction(){
		$semantic=$this->semantic;
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$this->jquery->compile($this->view);
		
		
	}
}