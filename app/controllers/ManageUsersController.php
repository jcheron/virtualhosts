<?php
use Ajax\semantic\html\elements\HtmlHeader;
class ManageUsersController extends ControllerBase
{

    public function indexAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
    	$semantic=$this->semantic;

    	$users=User::find();    		
    	
    	$table=$semantic->htmlTable("users",0,2);
    	$table->setBasic(true)->setCollapsing()->setCelled();
    	$table->getHeader()->setValues(["Utilisateur","Actions"]);
    	
    	foreach($users as $user){
    		$id=$user->getId();
    		$table->addRow([HtmlHeader::image("","http://semantic-ui.com/images/avatar2/small/matthew.png",4,$user->getName(),$user->getEmail()),
    				$buttons=$this->semantic->htmlButtonGroups("editOrDelete",array("Modifier","Supprimer"))]);
    				$buttons->insertOr(0,"ou");
    				$buttons->getElement(0)->getOnClick("ManageUsers/editUser/$id","#divRole");
    				$buttons->getElement(2)->getOnClick("ManageUsers/deleteUser/$id","#divRole");    				
    	}

		$this->jquery->compile($this->view);
    }
    
    public function editUserAction($id=NULL){
    	$semantic=$this->semantic;
    	
    	$this->view->setVar("id", $id);

    	
    	$this->jquery->compile($this->view);
    }
    
    public function deleteUserAction($id=NULL){
    	$semantic=$this->semantic;
    	
    	$this->view->setVar("id",$id);
    	
    	$this->jquery->compile($this->view);
    }

}

