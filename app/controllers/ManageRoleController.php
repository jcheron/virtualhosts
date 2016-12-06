<?php

class ManageRoleController extends ControllerBase
{

    public function indexAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	$semantic=$this->semantic;
    	$roles=Role::find();
    
		$table=$this->semantic->htmlTable("dd",0,4);
		$table->setHeaderValues(["Rôles","","",""]);
		foreach ($roles as $Role)
		{
			$table->addRow([$i=$Role->getName(),$semantic->htmlButton("editButton".$i."","Modifier","")->getOnClick("ManageRole/editRole/$i","#divRole"),
											 $semantic->htmlButton("addButton".$i."","Ajouter","")->getOnClick("ManageRole/addRole/$i","#divRole"),
											 $semantic->htmlButton("deleteButton".$i."","Supprimer","")->getOnClick("ManageRole/deleteRole/$i","#divRole")]);
			
		}
		
		$this->jquery->compile($this->view);
    }
    
    public function editRoleAction($a=NULL){
    	
			$role=Role::findFirst("name='$a'");
			
			$roleEdit=Role::findFirst($_POST["name='$a'"]);
			
			$semantic=$this->semantic;
			
			$form=$semantic->htmlForm("frmEdit");
			$form->addInput("id","ID","text",$role->getId());
			$form->addInput("name","Nom","text",$a);
			
			$toUpdate=["id","name"];
			
			$form->addButton("","Valider")->asSubmit();
			
			$roleEdit->save($_POST,$toUpdate);		
			
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

