<?php

use Ajax\semantic\html\collections\form\HtmlFormTextarea;

class TypePropertyController extends ControllerBase
{
	
    public function indexAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	 
    	$table = $semantic->htmlTable("table",0,4);
    	$table->setHeaderValues(["#","nom","Propriétés","Action"]);
    	 
    	$btnAdd = $semantic->htmlButton("btnAdd","Ajouter","fluid ui button blue");
    	$btnAdd->getOnClick($this->controller."/vAdd","#divAction");
    	 
    	$typeProperties = Stypeproperty::find(["group" => "idStype"]);
    	 
    	$i=0;
    	foreach ($typeProperties as $Stypeproperty){
    		$id = $Stypeproperty->getStypes()->getId();
    		$nbProperties = count(Stypeproperty::find("idStype = ".$id));
    		$label= $semantic->htmlLabel("nbProprietes",$this->correcteur($nbProperties),false)->setColor("green");
    		
    		$btnUpdate = $semantic->htmlButton("btnUpdate-".$i,"Modifier","small green basic")->asIcon("edit")->getOnClick($this->controller."/vUpdate/".$Stypeproperty->getIdStype()."/".$Stypeproperty->getIdProperty(),"#divAction");
    		//$btnDelete = $semantic->htmlButton("btnDelete-".$i,"Supprimer","small red basic")->asIcon("remove")->getOnClick($this->controller."/vDelete/".$Stypeproperty->getIdStype()."/".$Stypeproperty->getIdProperty(),"#divAction");
    		$table->addRow([$i+1,$Stypeproperty->getStypes()->getName(),$label,$btnUpdate]);
    		$i++;
    	}
    	$this->view->setVars(["typeProperty"=>$Stypeproperty]);
    	$this->jquery->compile($this->view);
    }
    private function correcteur($nb){
    	$mot = "";
    	if($nb == 0){
    		$mot = " Aucune propriété";
    	}elseif ($nb == 1){
    		$mot = $nb." Propriété";
    	}else{
    		$mot = $nb." Propriétés";
    	}
    	return $mot;
    	
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
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	$form->addErrorMessage();
    	
    	$fields=$form->addFields();
      	$fields->addDropdown("stype",$itemsStypes,"Type Serveurs","Selectionner un type de serveur...",false)->setWidth(8).
    	$fields->addDropdown("property",$itemsProperties,"Propriétés","Selectionner une propriété...",false)->setWidth(8);
    	
    	$form->addInput("name","Nom * :","text",false,"Nom de la propriété")->addRule("empty");;
    	$form->addItem(new HtmlFormTextarea("template","Template * :",false,"Template",10))->addRule("empty");

    	$form->addButton("submit", "Valider","ui blue button")->asSubmit();
    	$form->submitOnClick("submit",$this->controller."/vAddSubmit","#divAction");
    	
    	$form->addButton("btnCancel", "Annuler","ui red button");
    	 
    	 
    	 
    	$this->jquery->compile($this->view);
    }
    
    public function vAddSubmitAction(){

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
    
    public function vUpdateAction($idStype,$active = NULL){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	$semantic=$this->semantic;
    	
    	$StypeProperties = Stypeproperty::find("idStype = ".$idStype);
    	$Stype = Stype::findFirst($idStype);
    	
    	if($StypeProperties->count() > 0 ){
    	
    	
    	$table = $semantic->htmlTable("table",0,5);
    	$table->setHeaderValues(["#","serveur (propriétés)","Nom","Template","Supprimer"]);
    	
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick($this->controller."/index","#index");
    	 
    	$form=$semantic->htmlForm("frmUpdate");
     	
    	$i=0;
    	foreach ($StypeProperties as $Stypeproperty){
    		
    		$btnDelete = $semantic->htmlButton("btnDelete-".$i,"Supprimer","small red basic")->asIcon("remove")->getOnClick($this->controller."/vDelete/".$Stypeproperty->getIdStype()."/".$Stypeproperty->getIdProperty(),"#delete");
    		
    		$hiddenPrprty = $form->addInput("idProperty[]",NULL,"hidden",$Stypeproperty->getIdProperty());
    		$inputName = $form->addInput("name[]",false)->setValue($Stypeproperty->getName());
    		$inputTemplate = $form->addInput("template[]",false)->setValue($Stypeproperty->getTemplate());
    		
    		$table->addRow(
    				[
    						$i+1,//col1
    						$Stypeproperty->getName()."(".$Stypeproperty->getProperties()->getName().")".$hiddenPrprty,//col2
    						$inputName,//Col3
    						$inputTemplate,//col4
    						$btnDelete
    				]);
    		$i++;
    	}
    	$table->setDefinition();
    	$table->addColVariations(2,"collapsing");
		$footer = $table->getFooter()->setFullWidth();
		$footer->getCell(0,1)->setValue([
				$form->addInput("idStype",NULL,"hidden",$Stypeproperty->getIdStype()),
				$form->addButton("submit", "Valider","ui positive button")->postFormOnClick($this->controller."/vUpdateSubmit","frmUpdate","#divAction"),
				$form->addButton("btnCancel", "Annuler","ui red button")
		]);  	
    	
    	$form->addButton("btnCancel", "Annuler","ui red button");
    	
    	$this->view->setVars(["Stype"=>$Stype,"active"=>"true"]);
    	
    	}else{

    		$btnCancel = $semantic->htmlButton("btnCancel","Non","ui button red");
    		$btnCancel->getOnClick($this->controller."/index","#content-container");
    		
    		$btnAdd = $semantic->htmlButton("btnAdd","Oui","ui button blue");
    		$btnAdd->getOnClick($this->controller."/vAdd","#content-container");
    		
    		$this->view->setVars(["Stype"=>$Stype,"active"=>"false"]);
    		$this->jquery->compile($this->view);
    	}
    	
    	$this->jquery->compile($this->view);
    }
    
    public function vUpdateSubmitAction(){
    	$success = false;
    	$i = 0;
    	foreach($_POST["idProperty"] as $property){
    		$property=Stypeproperty::findFirst("idStype = ".$_POST["idStype"]." AND idProperty = ".$property);
    		$property->setName($_POST["name"][$i]);
    		$property->setTemplate($_POST["template"][$i]);
    		$property->save();
    		$i++;
    		$success = true;
    	}
    	if ($success) {
    		$this->flash->message("success","Les modifications ont été effectuée avec succès");
    		$this->jquery->get($this->controller,"#refresh");
    	}else {
    		$this->flash->message("error","Une erreur est survenue ! veuillez réessayer à nouveau !");
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
    	
    	$form->addInput("name","Nom *:","text",NULL,"Confirmer le nom du type de propriété");
    	$form->addButton("submit", "Supprimer","ui negative button")->postFormOnClick($this->controller."/confirmDelete", "frmDelete","#divAction");
    	$form->addButton("btnCancel", "Annuler","ui positive button");
    	$form->addInput("idStype",NULL,"hidden",$typeProperty->getIdStype());
    
    	$this->view->setVars(["element"=>$typeProperty]);
    
    	$this->jquery->compile($this->view);
    }
    
    public function confirmDeleteAction(){
    	
    	$typeProperty = Stypeproperty::findFirst("idStype = ".$_POST['idStype']." and idProperty = ".$_POST['idProperty']);
    	 
    	if($typeProperty->getName() == $_POST['name']){
    		$typeProperty->delete();
    
    		$this->flash->message("success","Le type de propriété '".$_POST['name']."' a été supprimé avec succès");
    		$this->jquery->get($this->controller."/vUpdate/".$_POST['idStype'],"#refresh");
    
    	}else{
    
    		$this->flash->message("error","Le type de propriété '".$typeProperty->getName()."' n'a pas été supprimé : le nom ne correspond pas ! ");
    		$this->jquery->get($this->controller,"#refresh");
    	}
    	 
    	echo $this->jquery->compile();
    }
    
}

