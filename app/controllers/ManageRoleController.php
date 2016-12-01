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
			$table->addRow([$Role->getName(),$semantic->htmlButton("editButton","Modifier","")->getOnClick("ManageRole/editRole/2","#editRole"),
											 $semantic->htmlButton("addButton","Ajouter","")->getOnClick("ManageRole/addRole","#addRole"),
											 $semantic->htmlButton("deleteButton","Supprimer","")->getOnClick("ManageRole/deleteRole","#deleteRole")]);	
			
		}
		
		$this->jquery->compile($this->view);
    }
    
    public function editRoleAction($a=NULL){


 $this->view->disable();
    	var_dump($a) ;

			$semantic=$this->semantic;
			$form=$semantic->htmlForm("frm1");
			$form->addInput("idRole","ID");
			$form->addInput("nameRole","Role");
			$form->addButton("","Valider")->asSubmit();
			echo $form;
			$this->jquery->compile($this->view);
			
    }
    
    public function addRoleAction(){
    	
    }
    
    public function deleteRoleAction(){
    	
    }

}

