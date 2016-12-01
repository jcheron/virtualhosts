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
			$table->addRow([$Role->getName(),$semantic->htmlButton("editButton","Modifier","black")->getOnClick("ManageRole/editRole","#editRole"),
											 $semantic->htmlButton("addButton","Ajouter","black")->getOnClick("ManageRole/addRole","#addRole"),
											 $semantic->htmlButton("deleteButton","Supprimer","black")->getOnClick("ManageRole/deleteRole","#deleteRole")]);	
			
		}
		
		$this->jquery->compile($this->view);
    }
    
    public function editRoleAction(){
			//$semantic=$this->semantic;
			
    }
    
    public function addRoleAction(){
    	
    }
    
    public function deleteRoleAction(){
    	
    }

}

