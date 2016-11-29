<?php

class ManageRoleController extends ControllerBase
{

    public function indexAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
    	$roles=Role::find();
    
		$table=$this->semantic->htmlTable("dd",0,4);
		$table->setHeaderValues(["Rôles","Modifier","Ajouter","Supprimer"]);
		foreach ($roles as $Role)
		{
			$roleName=$Role->getName();
			
			$table->addRow([$Role->getName(),"","",""]);
			
		}
		
		$this->jquery->compile($this->view);
    }

}

