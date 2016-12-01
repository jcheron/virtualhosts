<?php
use Phalcon\Mvc\View;
class InfoCompteController extends ControllerBase{
	public function indexAction(){
		
	$this->secondaryMenu($this->controller,$this->action);
	$this->tools($this->controller,$this->action);
	
	$this->jquery->compile($this->view);
	}
	public function ModifInfoAction(){
		$semantic=$this->semantic;
		$user=User::findFirst();
		$this->loadMenus();
		$message=$semantic->htmlMessage("messageInfo","<b> Bienvenue ".$user->getName());
		$message2=$semantic->htmlMessage("messageInfomodif","Votre Login :   <input type='text' placeholder='".$user->getLogin()."'><br></br> Votre mot de passe :  <input type='password' placeholder='".$user->getPassword()."'><br></br> Votre nom :  <input type='text' placeholder='".$user->getName()."'><br></br> Votre e-mail :  <input type='text' placeholder='".$user->getEmail()."'");
		$button=$semantic->htmlButton("btValider","Validez")->setColor("green");
		$button->onClick();
		$this->jquery->compile($this->view);
		
		
		
	}
}