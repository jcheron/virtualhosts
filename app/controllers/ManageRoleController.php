<?php

class ManageRoleController extends ControllerBase
{

    public function indexAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
    	$roles=Role::find();
    
		$table=$this->semantic->htmlTable("dd",0,4);
		$table->setHeaderValues(["Rôles","","",""]);
		foreach ($roles as $Role)
		{
			$roleName=$Role->getName();
			
			$table->addRow([$Role->getName(),$edit=$this->semantic->htmlButton("editButton","Modifier"),$add=$this->semantic->htmlButton("addButton","Ajouter"),$delete=$this->semantic->htmlButton("deleteButton","Supprimer")]);
			
		}
		
		$this->jquery->compile($this->view);
    }

}

