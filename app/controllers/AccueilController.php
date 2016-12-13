<?php
use Ajax\semantic\html\base\constants\State;
use Ajax\semantic\components\validation\Rule;


class AccueilController extends ControllerBase
{

	

	
	public function connectAction()
	{
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$semantic=$this->semantic;
		$semantic->setLanguage("fr");
		$form=$semantic->htmlForm("frm2");
		$form->addErrorMessage();
		$form->addHeader("Connexion Utilisateur :",3);
		$form->addInput("email","Adresse")->addRule("empty","Veuillez remplir le champ adresse...");
		$form->addInput("password","Mot de passe","password")->addRule("empty","Veuillez remplir le champ mot de passe ...");
		$icon=$semantic->htmlIcon("","checkmark");
		$form->addButton("btValider","Valider")->setColor("green")->asSubmit();
		$form->submitOn("click","btValider","Accueil/login","#suite");
	
		
		
		//echo $form;
		$this->jquery->compile($this->view);
		
	}
	
	private function _registerSession($user)
	{
		$this->session->set(
				"auth",
				[
						"id"   => $user->id,
						"name" => $user->name,
				]
				);
	}
	
	public function loginAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		
		
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$mail    = $this->request->getPost("email");
			$pwd = $this->request->getPost("password");
		
			//Cherche l'utilisateur dans la BDD
			$user = User::findFirst(
					[
							"email = :email: AND password = :password: ",
							"bind" => [
									"email"    => $mail,
									"password" => $pwd,
							]
					]
					);
				
		
			
			if ($user !== false) {
				$this->_registerSession($user);
		
				$this->flash->success(
						"Bienvenu  " . $user->email ." ! "
						);
		
				//Envois à la page d'acceuil si la connexion est réussis !
				
				return $this->dispatcher->forward(
						[
								"controller" => "Index",
								"action"     => "index",
						]
						);
			}
		
		
			$this->flash->error(
					"Mauvais mot de passe ou Email ...."
					);
			
			
		}
		
		// Retourne au formulaire si la connexion à échoué
	
		
		$this->jquery->compile($this->view);
	
	}
	
}