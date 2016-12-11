<?php


use Ajax\semantic\html\elements\HtmlList;
use Ajax\semantic\html\modules\checkbox\HtmlCheckbox;
use Ajax\semantic\html\elements\HtmlButton;
use Ajax\semantic\html\elements\HtmlInput;
use Ajax\Semantic;
class ManageRoleController extends ControllerBase
{

    public function indexAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	$semantic=$this->semantic;
    	$semantic->htmlButton("addButton","Ajouter","fluid ui button green")->getOnClick("ManageRole/addRole","#divRole");   	 
    	$roles=Role::find();
    
		$table=$this->semantic->htmlTable("dd",0,3);
		$table->setHeaderValues(["Rôles","Nombre d'utilisateur",""]);
		foreach ($roles as $Role)
		{
			$table->addRow([$i=$Role->getName(),"PlaceHolder",$semantic->htmlButton("editButton".$i."","Modifier","small green basic")->asIcon("edit")->getOnClick("ManageRole/editRole/$i","#divRole").									
											 $semantic->htmlButton("deleteButton".$i."","Supprimer","small red")->asIcon("remove")->getOnClick("ManageRole/deleteRole/$i","#divRole")]);
			
		}
		$this->jquery->compile($this->view);
    }
    
    public function editRoleAction($a=NULL){		
    	$semantic=$this->semantic;	
    		
			$roleEdit=Role::findFirst(["name='$a'"]);
	
			$form=$semantic->htmlForm("frmEdit");
			$form->addInput("id","ID","text",$roleEdit->getId()	);
			$form->addInput("name","Nom","text",$a);
			$form->addButton("submit","envoyer")->postFormOnClick("ManageRole/majRole","frmEdit","#result");
			$this->jquery->compile($this->view);
    }

    public function majRoleAction(){    	
    	$nom=$_POST["name"];
    	$id=$_POST["id"];
    	
    	$roleEdit=Role::findFirst(["id=$id"]);
    	

    	$roleEdit->setName($nom);
   // 	$roleEdit->setId($id);
    	$roleEdit->save();
    		
    	$this->jquery->compile($this->view);
    }
    
    public function addRoleAction($a=NULL){
	    	$semantic=$this->semantic;
	    	$form=$semantic->htmlForm("frmAdd");
	    	$form->addInput("idRole","ID","text");
	    	$form->addInput("nameRole","Nom","text");
	    	$form->addButton("","Ajouter le rôle")->asSubmit();
	    	$this->jquery->compile($this->view);
    }
    
    public function deleteRoleAction($a=NULL){
	    	$role=Role::findFirst("name='$a'");
	    		
	    	$semantic=$this->semantic;
	    	
	    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
	    	$btnCancel->getOnClick("TypeServers","#divAction");
	    	
	    	$form=$semantic->htmlForm("frmDelete");
	    		
	    	$form->addHeader("Voulez-vous vraiment supprimer le rôle : ". $role->getName()."?",3);
	    	$form->addInput("id",NULL,"hidden",$role->getId());
	    	$form->addInput("name","Nom","text",NULL,"Entrez le nom du rôle pour confirmer la suppression");
	    	$form->addButton("submit", "Supprimer")->postFormOnClick("TypeServers/confirmDelete", "frmDelete","#divAction");
	    		
	    	
	    	$this->view->setVars(["element"=>$role]);
	    	
	    	$this->jquery->compile($this->view);
    }

}

