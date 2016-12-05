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
			$table->addRow([$i=$Role->getName(),$semantic->htmlButton("editButton".$i."","Modifier","")->getOnClick("ManageRole/editRole/$i","#editRole"),
											 $semantic->htmlButton("addButton","Ajouter","")->getOnClick("ManageRole/addRole","#addRole"),
											 $semantic->htmlButton("deleteButton","Supprimer","")->getOnClick("ManageRole/deleteRole","#deleteRole")]);
			
		}
		
		$this->jquery->compile($this->view);
    }
    
    public function editRoleAction($a=NULL){


 //$this->view->disable();
 //$a="user";
   // 	var_dump($a);
			$role=Role::findFirst("name='$a'");
			$semantic=$this->semantic;
			$form=$semantic->htmlForm("frm1");
			$form->addInput("idRole","ID","",$role->getId());
			$form->addInput("nameRole","Nom","",$a);
			$form->addButton("","Valider")->asSubmit();
			$this->jquery->compile($this->view);
    }
    
    public function addRoleAction(){
    	
    }
    
    public function deleteRoleAction(){
    	
    }

}

