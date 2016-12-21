<?php

use Ajax\semantic\html\elements\HtmlButton;
use Ajax\Semantic;
use Phalcon\Forms\Element\Submit;

class ManageUsersController extends ControllerBase
{

    public function indexAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	$semantic=$this->semantic;
    	$semantic->htmlButton("addButton","Ajouter","button green")->getOnClick("ManageUsers/addUser","#divUser");   	 
    	$users=User::find();
    
		$table=$this->semantic->htmlTable("dd",0,3);
		$table->setHeaderValues(["Utilisateurs","Rôle de l'utilisateur",""]);
		foreach ($users as $User)
		{
			$i= $User->getId();
			$Idrole= $User->getIdrole();
			$roleUser=Role::findFirst("id='$Idrole'");
			$p= $semantic->htmlLabel("",$roleUser->getName(),"user")->setColor("green");
			$table->addRow([$User->getFirstname()." ".$User->getName(),
			$p,
							$semantic->htmlButton("editButton".$i."","Modifier","small green basic")->asIcon("edit")->getOnClick("ManageUsers/editUser/$i","#divUser").									
							$semantic->htmlButton("deleteButton".$i."","Supprimer","small red")->asIcon("remove")->getOnClick("ManageUsers/deleteUser/$i","#divUser")]);
		}
		$this->jquery->compile($this->view);
    }
    
    public function editUserAction($a=NULL){		
    		$semantic=$this->semantic;	
    		
    		$roles=Role::find();
    		$itemsrole = array();
    		foreach($roles as $role) {
    			$itemsrole[] = $role->getName();
    		}
    		
			$userEdit=User::findFirst(["id='$a'"]);
			
			$actualIdRole= $userEdit->getIdrole();
			$actualRole=Role::findFirst("id='$actualIdRole'");
			$nameRole=$actualRole->getName();
	
			$form=$semantic->htmlForm("frmEdit");
			$form->addInput("id","","hidden",$a);
			$form->addInput("login","Identifiant","text",$userEdit->getLogin());
			$form->addInput("password","Mot de Passe","text",$userEdit->getPassword());
			$form->addInput("firstname","Prenom","text",$userEdit->getFirstname());
			$form->addInput("name","Nom","text",$userEdit->getName());
			$form->addInput("email","Adresse Mail","text",$userEdit->getEmail());
			$form->addInput("idrole","Rôle","text",$userEdit->getIdrole());
			$form->addDropdown("nameRole",$itemsrole,"Rôle",$nameRole,false);
			
			$form->addButton("submit","envoyer","button green")->postFormOnClick("ManageUsers/majUser","frmEdit","#result");
			$this->jquery->compile($this->view);
    }

    public function majUserAction(){ 
    	$id=$_POST["id"];
    	$login=$_POST["login"];
    	$password=$_POST["password"];
    	$firstname=$_POST["firstname"];
    	$name=$_POST["name"];
    	$email=$_POST["email"];

    	$nameRole=$_POST["nameRole"];
    	
    	$role=Role::findFirst("name='$nameRole'");
    	$idrole=$role->getId();
    	
    	$userEdit=User::findFirst(["id=$id"]);

    	$userEdit->setLogin($login);
    	$userEdit->setPassword($password);
    	$userEdit->setFirstname($firstname);
    	$userEdit->setName($name);
    	$userEdit->setEmail($email);
    	$userEdit->setIdrole($idrole);
    	$userEdit->update();
    		
    	$this->jquery->compile($this->view);
    }
    
    public function addUserAction(){
	    	$semantic=$this->semantic;
	    	
	    	$roles=Role::find();
	    	$itemsrole = array();
	    	foreach($roles as $role) {
	    		$itemsrole[] = $role->getName();
	    	}
	    	
	    	$form=$semantic->htmlForm("frmAdd");
	    	$form->addInput("login","Identifiant","text");
			$form->addInput("password","Mot de Passe","text");
			$form->addInput("firstname","Prenom","text");
			$form->addInput("name","Nom","text");
			$form->addInput("email","Adresse Mail","text");
			$form->addDropdown("nameRole",$itemsrole,"Rôle","Selectionnez un Rôle :",false);
	    	
	    	$form->addButton("submit","Ajouter l'utilisateur","button green")->postFormOnClick("ManageUsers/newUser","frmAdd","#result");
	    	$this->jquery->compile($this->view);
    }
    
    public function newUserAction(){
	    	$login=$_POST["login"];
	    	$password=$_POST["password"];
	    	$firstname=$_POST["firstname"];
	    	$name=$_POST["name"];
	    	$email=$_POST["email"];
	    	$nameRole=$_POST["nameRole"];

	    	$role=Role::findFirst("name='$nameRole'");
	    	$idrole=$role->getId();
	    	
	    	$newUser = new User();
	    	$newUser->setLogin($login);
	    	$newUser->setPassword($password);
	    	$newUser->setFirstname($firstname);
	    	$newUser->setName($name);
	    	$newUser->setEmail($email);
	    	$newUser->setIdrole($idrole);
	    	$newUser->create();
	    	
	    	$this->jquery->compile($this->view);
    }
    
    public function deleteUserAction($a=NULL){
    		$semantic=$this->semantic;
    	
	    	$user=User::findFirst("id='$a'");
	    	
	    	$form=$semantic->htmlForm("frmDelete");
	    		
	    	$form->addHeader("Voulez-vous vraiment supprimer l'utilisateur : ". $user->getFirstname()." ".$user->getName()."?",3);
	    	$form->addInput("id",NULL,"hidden",$a);
	    	$form->addInput("name","Nom","text",NULL,"Entrez le nom de l'utilisateur pour confirmer la suppression");
	    	$form->addButton("submit", "Supprimer","button red")->postFormOnClick("manageUsers/confirmDelete", "frmDelete","#result");
	    		
	    	
	    	$this->view->setVars(["element"=>$user]);
	    	
	    	$this->jquery->compile($this->view);
    }
    
    public function confirmDeleteAction(){
    	$deleteUser = User::findFirst($_POST['id']);
    		
    	if($deleteUser->getFirstname()." ".$deleteUser->getName() == $_POST['name']){
    		$deleteUser->delete();
    		$this->jquery->compile($this->view);
    	}
    }

}
    
