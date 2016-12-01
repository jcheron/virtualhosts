<?php



class AccueilController extends ControllerBase
{

	

	
	public function connectAction()
	{
		
		
		
		
		
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
		return $this->dispatcher->forward(
				[
						"controller" => "Accueil",
						"action"     => "connect",
				]
				);
	}
	
}