<?php

use Ajax\semantic\html\collections\form\HtmlFormTextarea;

class TypePropertyController extends ControllerBase
{
	
    public function indexAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	$semantic=$this->semantic;
    	 
    	$table = $semantic->htmlTable("table",0,3);
    	$table->setHeaderValues(["id","nom","Action"]);
    	 
    	$btnAdd = $semantic->htmlButton("btnAdd","Ajouter","fluid ui button blue");
    	$btnAdd->getOnClick($this->controller."/vAdd","#divAction");
    	 
    	$typeProperties = Stypeproperty::find();
    	 
    	$i=0;
    	foreach ($typeProperties as $Stypeproperty){
    		$btnUpdate = $semantic->htmlButton("btnUpdate-".$i,"Modifier","small green basic")->asIcon("edit")->getOnClick($this->controller."/vUpdate/".$Stypeproperty->getIdStype()."/".$Stypeproperty->getIdProperty(),"#divAction");
    		$btnDelete = $semantic->htmlButton("btnDelete-".$i,"Supprimer","small red")->asIcon("remove")->getOnClick($this->controller."/vDelete/".$Stypeproperty->getIdStype()."/".$Stypeproperty->getIdProperty(),"#divAction");
    		$table->addRow([$i+1,$Stypeproperty->getName(),$btnUpdate.$btnDelete]);
    		$i++;
    	}
    	 
    	$this->view->setVars(["typeProperty"=>$Stypeproperty]);
    	$this->jquery->compile($this->view);
    }
    public function vAddAction(){
    	$this->tools($this->controller,$this->action);
    
    	$semantic=$this->semantic;
    	
    	$stypes = Stype::find();
    	$itemsStypes = array();
    	foreach($stypes as $stype) {
    		$itemsStypes[] = $stype->getName();
    	}
    	
    	$properties = Property::find();
    	$itemsProperties = array();
    	foreach($properties as $property) {
    		$itemsProperties[] = $property->getName();
    	}
    	
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick($this->controller."/index","#index");
    	 
    	$form=$semantic->htmlForm("frmAdd");
    	$fields=$form->addFields();
  
    	$fields->addDropdown("stype",$itemsStypes,"Type Serveurs","Selectionner un type de serveur ...",false)->setWidth(8).
    	$fields->addDropdown("property",$itemsProperties,"Propriétés","Selectionner une propriétés ...",false)->setWidth(8);
    	
    	$form->addInput("name","Nom * :","text",false,"Nom de la propriété");
    	$form->addItem(new HtmlFormTextarea("template","Template * :",false,"Template"))->setRows(10);

    	$form->addButton("submit", "Valider","ui blue button")->postFormOnClick($this->controller."/vAddSubmit", "frmAdd","#divAction");
    	$form->addButton("btnCancel", "Annuler","ui red button");
    	 
    	 
    	 
    	$this->jquery->compile($this->view);
    }
    
    public function vAddSubmitAction(){
    	var_dump($_POST);
    	if(!empty($_POST['name'] && $_POST['template'] && $_POST['stype'] && $_POST['property'])){
    		
    		$stype = Stype::findFirst("name = '".$_POST['stype']."'");
    		$property = Property::findFirst("name = '".$_POST['property']."'");
    		
    		$StypeProperty = new Stypeproperty();
    		
    		$StypeProperty->setIdStype($stype->getId());
    		$StypeProperty->setIdProperty($property->getId());
    		
    		$StypeProperty->save(
    				$this->request->getPost(),
    				[
    						"name",
    						"template",
    				]
    				);
    
    		$this->flash->message("success", "Le type de propriété '".$_POST['name']."' a été inseré avec succès");
    		$this->jquery->get($this->controller,"#refresh");
    		 
    	}else{
    		$this->flash->message("error", "Veuillez remplir tous les champs");
    	}
    	echo $this->jquery->compile();
    }
    
    public function vUpdateAction($idStype,$idProperty){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
    	$semantic=$this->semantic;
    	
    	$typeProperty = Stypeproperty::findFirst("idStype = ".$idStype." and idProperty = ".$idProperty);
    	
    	$stypes = Stype::find();
    	$itemsStypes = array();
    	foreach($stypes as $stype) {
    		$itemsStypes[] = $stype->getName();
    	}
    	 
    	$properties = Property::find();
    	$itemsProperties = array();
    	foreach($properties as $property) {
    		$itemsProperties[] = $property->getName();
    	}
    	
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick($this->controller."/index","#index");
    
    	$form=$semantic->htmlForm("frmUpdate");
    	$fields=$form->addFields();
    	
    	$fields->addDropdown("stype",$itemsStypes,"Type Serveurs",$typeProperty->getStype()->getName(),false)->setWidth(8).
    	$fields->addDropdown("property",$itemsProperties,"Propriétés",$typeProperty->getProperty()->getName(),false)->setWidth(8);
    	
    	$form->addInput("idProperty",NULL,"hidden",$typeProperty->getIdProperty());
    	$form->addInput("idStype",NULL,"hidden",$typeProperty->getIdStype());
    	$form->addInput("name","Nom *:")->setValue($typeProperty->getName());
    	$form->addItem(new HtmlFormTextarea("template","Template *:"))->setValue($typeProperty->getTemplate())->setRows(10);
    
    	$form->addButton("submit", "Valider","ui positive button")->postFormOnClick($this->controller."/vUpdateSubmit", "frmUpdate","#divAction");
    	$form->addButton("btnCancel", "Annuler","ui red button");
    	 
    	
    	$this->view->setVars(["typeProperty"=>$typeProperty]);
    
    	$this->jquery->compile($this->view);
    }
    
    public function vUpdateSubmitAction(){
    	
    	$StypeProperty = Stypeproperty::findFirst("idStype = ".$_POST['idStype']." and idProperty = ".$_POST['idProperty']);

    	if(!empty($_POST['stype'])){
    		$stype = Stype::findFirst("name = '".$_POST['stype']."'");
    		$StypeProperty->setIdStype($stype->getId());
    	}
    	if(!empty($_POST['property'])){
    		$property = Property::findFirst("name = '".$_POST['property']."'");
    		$StypeProperty->setIdProperty($property->getId());
    	}
    	var_dump($stype->getId());
    	var_dump($property->getId());
    	// Stocke et vérifie les erreurs
    	$success = $StypeProperty->update(
    			$this->request->getPost(),
    			[
    					"name",
    					"template",
    			]
    			);
    
    	
    	if ($success) {
    		$this->flash->message("success","Le type de propriété '".$StypeProperty->getName()."' a été modifié avec succès");
    		$this->jquery->get($this->controller,"#refresh");
    	}
    	 
    	echo $this->jquery->compile();
    }
    public function vDeleteAction($idStype,$idProperty){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	 
    	$typeProperty = Stypeproperty::findFirst("idStype = ".$idStype." and idProperty = ".$idProperty);
    	 
    	$semantic=$this->semantic;
    	 
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick($this->controller."/index","#index");
    
    	$form=$semantic->htmlForm("frmDelete");
    	 
    	$form->addHeader("Voulez-vous vraiment supprimer l'élément : ". $typeProperty->getName()." ? ",3);

    	$form->addInput("idProperty",NULL,"hidden",$typeProperty->getIdProperty());
    	$form->addInput("idStype",NULL,"hidden",$typeProperty->getIdStype());
    	
    	$form->addInput("name","Nom *:","text",NULL,"Confirmer le nom du type de propriété");
    	$form->addButton("submit", "Supprimer","ui negative button")->postFormOnClick($this->controller."/confirmDelete", "frmDelete","#divAction");
    	$form->addButton("btnCancel", "Annuler","ui positive button");
    	 
    
    	$this->view->setVars(["element"=>$typeProperty]);
    
    	$this->jquery->compile($this->view);
    }
    
    public function confirmDeleteAction(){
    	
    	$typeProperty = Stypeproperty::findFirst("idStype = ".$_POST['idStype']." and idProperty = ".$_POST['idProperty']);
    	 
    	if($typeProperty->getName() == $_POST['name']){
    		$typeProperty->delete();
    
    		$this->flash->message("success","Le type de propriété '".$_POST['name']."' a été supprimé avec succès");
    		$this->jquery->get($this->controller,"#refresh");
    
    	}else{
    
    		$this->flash->message("error","Le type de propriété '".$_POST['name']."' n'a pas été supprimé : le nom ne correspond pas ! ");
    		$this->jquery->get($this->controller,"#refresh");
    	}
    	 
    	echo $this->jquery->compile();
    }
}

