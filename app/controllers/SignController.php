<?php
class SignController extends ControllerBase{
	public function indexAction(){
	
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
	
		$this->jquery->compile($this->view);
	}
	public function signInAction(){
		$semantic=$this->semantic;
		$semantic->setLanguage("fr");
		$semantic->htmlMessage ( "messageInfo", "<b> Veuillez rentrer vos informations ");
		$form = $semantic->htmlForm("formInsc");
		$form->setValidationParams(["on"=>"blur","inline"=>true]);
		$fields=$form->addFields();
		$fields->addInput("name","Nom(*)","text","","Entrez votre nom")->addRule("empty");
		$fields->addInput("firstname","Prenom(*)","text","","Entrez votre prenom")->addRule("empty");
		$form->addInput("email","Email(*)","email","","Entrez votre Email")->addRule("empty");
		$form->addInput("password","Mot de passe(*)","password","","Veuillez entrer un mot de passe")->addRules(["empty","minLength[8]"]);
		$form->addInput("checkpassword","Confirmation mot de passe(*)","password","","Veuillez confirmer votre mot de passe")->addRules(["empty","minLength[8]","match[password]"]);
		$form->addInput("login","Login(*)","text","","Entrez votre identifiant" )->addRule("empty");
		$form->addButton("btSub1","S'inscrire")->asSubmit();
		$form->submitOnClick("btSub1", "Sign/test", "#content-container");
		$this->jquery->compile($this->view);
	}
	public function createAccAction(){
		$semantic = $this->semantic;
		
		$toCreate = [
				"name",
				"firstname",
				"email",
				"password",
				"login"
		];
		$password = $_POST ["password"];
		$checkpassword = $_POST ["checkpassword"];
		if ($checkpassword !== $password) {
			$mess = $semantic->htmlMessage ( "messageInfo", "<b>Mots de passe non identique" );
			echo $mess;
		} else {
			if (isset ( $password ) && $password !== NULL && $password !== "") {
				$toCreate [] = "password";
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
		$password= $_POST ["password"];
		$checkpassword = $_POST ["checkpassword"];
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
	
	public function testAction(){
		$user=new User();
		$user->setIdrole(2);
		$user->save($_POST);
	}
}