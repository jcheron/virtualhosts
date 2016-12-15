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

				$user = User::findFirst (); // Trouve le premier user de la table "Utilisateur"
		$this->loadMenus ();
		$semantic->htmlMessage ( "messageInfo", "<b> Bienvenue " . $user->getName () );
		$form = $semantic->htmlForm ( "frm4" ); // Forme du menu de modification
		$fields = $form->addFields ();
		$fields->addInput ( "id", NULL, "hidden", $user->getId () );
		$fields->addInput ( "login", "Login :", "text", $user->getLogin (), "Entrez votre login" )->setWidth ( 5 );
		$fields->addInput ( "password", "Mot de passe :", "password" )->setWidth ( 5 );
		$fields->addInput ( "Checkpassword", "Confirmation de mot de passe :", "password" )->setWidth ( 5 );
		$fields->addInput ( "name", "Nom :", "text", $user->getName (), "Entrez votre nom" )->setWidth ( 5 );
		$fields->addInput ( "email", "E-mail :", "text", $user->getEmail (), "Entrez votre e-mail" )->setWidth ( 5 );
		
		$button = $semantic->htmlButton ( "btValider", "Validez" )->asSubmit ()->setColor ( "green" ); // Envoi vers la bdd
		$button2 = $semantic->htmlButton ( "btRetourner", "Retour" ); // retourne l'index
		$button->postFormOnClick ( "InfoCompte/updateInfo", "frm4", "#content-container" );
		
		$this->jquery->postFormOn ( "change", "#Checkpassword", "InfoCompte/error", "frm4", "#messageInfo" );
		$this->jquery->compile ( $this->view );
	}
	public function updateInfoAction() {
		$semantic = $this->semantic;
		$user = User::findFirst( $_POST ["id"] );
		$toUpdate = [ 
				"login",
				"email",
				"name" 
		];
		$password = $_POST ["password"];
		$checkpassword = $_POST ["Checkpassword"];
		if ($checkpassword !== $password) {
			$mess = $semantic->htmlMessage ( "messageInfo", "<b>Mots de passe non identique" );
			echo $mess;
		} else {
			if (isset ( $password ) && $password !== NULL && $password !== "") {
				$toUpdate [] = "password";
			}
		}
		$user->save ( $_POST, $toUpdate );
		$ms2=$semantic->htmlMessage ( "okMsg", "Les informations ont bien été modifiées !!" );
		$ms2->addHeader ( "!! Succes !!");
		$ms2->setStyle ( "positive" );
		echo $ms2;
	}
	public function errorAction() {
		$semantic = $this->semantic;
		$password = $_POST ["password"];
		$checkpassword = $_POST ["Checkpassword"];
		if ($checkpassword !== $password) {
			$msg = $this->semantic->htmlMessage ( "errorMsg", "Les mots de passe ne sont pas identiques !" );
			$msg->addHeader ( "Confirmation mot de passe : " );
			$msg->setStyle ( "negative" );
			echo $msg;
		}else {
			$ms2=$semantic->htmlMessage ( "okMsg", "Les mots de passes sont identiques !" );
			$ms2->addHeader ( "Confirmation mot de passe : " );
			$ms2->setStyle ( "positive" );
			echo $ms2;
		}
	}
}