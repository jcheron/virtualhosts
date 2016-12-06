<?php
use Phalcon\Mvc\View;
use Ajax\semantic\html\base\constants\icons\UserActions;
class InfoCompteController extends ControllerBase{
	public function indexAction(){
		
	$this->secondaryMenu($this->controller,$this->action);
	$this->tools($this->controller,$this->action);
	
	$this->jquery->compile($this->view);
	}
	public function ModifInfoAction(){ // Modifie les informations d'un compte user
		$semantic=$this->semantic;

		$user=User::findFirst();// Trouve le premier user de la table "Utilisateur"
		$this->loadMenus();
		$semantic->htmlMessage("messageInfo","<b> Bienvenue ".$user->getName());		
		$form=$semantic->htmlForm("frm4");// Forme du menu de modification 
		$fields=$form->addFields();
		$fields->addInput("id",NULL,"hidden",$user->getId());
		$fields->addInput("login","Login :","text",$user->getLogin(),"Entrez votre login")->setWidth(5);
		$fields->addInput("password","Mot de passe :","password")->setWidth(5);
		$fields->addInput("name","Nom :","text",$user->getName(),"Entrez votre nom")->setWidth(5);
		$fields->addInput("email","E-mail :","text",$user->getEmail(),"Entrez votre e-mail")->setWidth(5);
		
		$button=$semantic->htmlButton("btValider","Validez")->asSubmit()->setColor("green");//Envoi vers la bdd
		$button2=$semantic->htmlButton("btRetourner","Retour");//retourne l'index
		$button->postFormOnClick("InfoCompte/updateInfo", "frm4","#content-container");
		$this->jquery->compile($this->view);
			
	}
	
	public function updateInfoAction(){
		$user=User::findFirst($_POST["id"]);
		$toUpdate=["login","email"];
		$password=$_POST["password"];
		if(isset($password) && $password!==NULL && $password!==""){
			$toUpdate[]="password";
		}
		$user->save($_POST,$toUpdate);
		
		var_dump($_POST);

		
		
	}
}