<?php
class SignController extends ControllerBase{
	public function indexAction(){
	
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
	
		$this->jquery->compile($this->view);
	}
	public function signInAction(){
		$semantic=$this->semantic;
		$semantic->htmlMessage ( "messageInfo", "<b> Veuillez rentrer vos informations ");
		$form = $semantic->htmlForm("formInsc");
		$form->addInput("nom","Nom");
		$form->addInput("prenom","Prenom");
		$form->addInput("email","Email");
		$form->addInput("mdp","Mot de passe");
		$form->addInput("confMdp","Confirmation mot de passe");
		$form->addInput("login","Login");
		$form->addButton("","S'inscrire")->asSubmit();
		echo $form;
	}
	public function createAccAction(){
		$semantic = $this->semantic;
		$toCreate = [
				"nom",
				"prenom",
				"email",
				"mdp",
				"login"
		];
		$mdp = $_POST ["mdp"];
		$confMdp = $_POST ["confMdp"];
		if ($confMdp !== $mdp) {
			$mess = $semantic->htmlMessage ( "messageInfo", "<b>Mots de passe non identique" );
			echo $mess;
		} else {
			if (isset ( $mdp ) && $mdp !== NULL && $mdp !== "") {
				$toCreate [] = "mdp";
			}
		}
		User::create( $_POST, $toCreate );
		$ms2=$semantic->htmlMessage ( "okMsg", "Vous êtes bien inscrit !!" );
		$ms2->addHeader ( "!! Succes !!");
		$ms2->setStyle ( "positive" );
		echo $ms2;
	}
	
	public function errorAction() {
		$semantic = $this->semantic;
		$mdp= $_POST ["mdp"];
		$confMdp = $_POST ["confMdp"];
		if ($confMdp !== $mdp) {
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