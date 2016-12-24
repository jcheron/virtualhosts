<?php

use Ajax\semantic\html\collections\form\HtmlFormTextarea;
use Ajax\semantic\html\collections\form\HtmlFormCheckbox;

class PropertyController extends ControllerBase
{

	public function indexAction()
	{
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		$semantic=$this->semantic;
	
		$table = $semantic->htmlTable("table",0,4);
		$table->setHeaderValues(["#","nom","Propriétés virtuelle","Action"]);
	
		$btnAdd = $semantic->htmlButton("btnAdd","Ajouter","fluid ui button blue");
		$btnAdd->getOnClick($this->controller."/vAdd","#divAction");
	
		$Properties = Property::find(["order" => "prority Asc"]);
	
		$i=0;
		foreach ($Properties as $Property){
			$id = $Property->getId();
			$nbProperties = count(Virtualhostproperty::find("idProperty = ".$id));
			$label= $semantic->htmlLabel("nbProprietes",$this->correcteur($nbProperties),false)->setColor("green");
						
			$btnUpdate = $semantic->htmlButton("btnUpdate-".$i,"Modifier","small green basic")->asIcon("edit")->getOnClick($this->controller."/vUpdate/".$Property->getId(),"#divAction");
			$btnDelete = $semantic->htmlButton("btnDelete-".$i,"Supprimer","small red basic")->asIcon("remove")->getOnClick($this->controller."/vDelete/".$Property->getId(),"#divAction");
			$btnVoir = $semantic->htmlButton("btnVoir-".$i,"Visualiser","small black basic")->asIcon("search")->getOnClick("Virtualhosts/editApache/".$Property->getId(),"#divAction");
			
			$table->addRow([$i+1,$Property->getName(),$label,$btnUpdate.$btnDelete.$btnVoir]);
			$i++;
		}
	
		$this->view->setVars(["Property"=>$Property]);
		$this->jquery->compile($this->view);
	}
	
	private function correcteur($nb){
		$mot = "";
		if($nb == 0){
			$mot = " Aucune propriété";
		}elseif ($nb == 1){
			$mot = $nb." propriété";
		}else{
			$mot = $nb." propriétés";
		}
		return $mot;
	
	}
	
	public function vAddAction(){
		$this->tools($this->controller,$this->action);
		
		$semantic=$this->semantic;
		$semantic->setLanguage("fr");
		
		$property = Property::findFirst(["order" => "prority DESC"]);
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick($this->controller."/index","#index");
		 
		$form=$semantic->htmlForm("frmAdd");
		$form->setValidationParams(["on"=>"blur","inline"=>true]);
		$form->addErrorMessage();
		
		$nom = $form->addInput("name","Nom * :","text",false,"Nom de la propriété")->addRule("empty");
		$nom->getField()->labeledToCorner("asterisk","right");
		$form->addItem(new HtmlFormTextarea("description","Description * :",false,"Description"))->addRule("empty");
		
		$form->addItem(new HtmlFormCheckbox("required","Requis ?","1","checkbox"));
		
		$form->addInput("prority",FALSE,"hidden",$property->getPrority()+1,"Saisir un chiffre ");
		
		$form->addButton("submit", "Valider","ui blue button")->asSubmit();
		$form->submitOnClick("submit",$this->controller."/vAddSubmit","#divAction");

		$form->addButton("btnCancel", "Annuler","ui red button");
		 
		 
		 
		$this->jquery->compile($this->view);
	}
	
	public function vAddSubmitAction(){

		if(!empty($_POST['name']) && !empty($_POST['description'])){
			
			$Property = new Property();
	

			if (!isset($_POST['required'])){
				$Property->setRequired(0);
			}
			$Property->save(
					$this->request->getPost(),
					[
							"name",
							"description",
							"prority",
							"required",
					]
					);
	
			$this->flash->message("success", "La propriété '".$_POST['name']."' a été inseré avec succès");
			$this->jquery->get($this->controller,"#refresh");
			 
		}else{
			$this->flash->message("error", "Veuillez remplir tous les champs");
		}
		echo $this->jquery->compile();
	}
	
	public function vUpdateAction($idProperty){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		 
		$semantic=$this->semantic;
		 
		$Property = Property::findFirst($idProperty);
		if($Property->getRequired() == 1 ){
			$requis = $semantic->htmlLabel("labelRequis","Actuellement requis.")->setColor("blue");
			$value = true;
		}else{
			$requis = $semantic->htmlLabel("labelRequis","Actuellement non requis.")->setColor("red");
			$value = false;
		}
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick($this->controller."/index","#index");
	
		$form=$semantic->htmlForm("frmUpdate");

		$nom=$form->addInput("name","Nom *:")->setValue($Property->getName());
		$nom->getField()->labeledToCorner("asterisk","right");
		$form->addInput("idProperty",NULL,"hidden",$Property->getId());
		$form->addItem(new HtmlFormTextarea("description","Description * :",$Property->getDescription(),"Description"));
		$form->addItem(new HtmlFormCheckbox("required","Requis ? ".$requis,"1","checkbox"))->setChecked($value);
		
		$form->addButton("submit", "Valider","ui positive button")->postFormOnClick($this->controller."/vUpdateSubmit", "frmUpdate","#divAction");
		$form->addButton("btnCancel", "Annuler","ui red button");	
	
		$this->view->setVars(["Property"=>$Property]);
	
		$this->jquery->compile($this->view);
	}
	
	public function vUpdateSubmitAction(){
		$Property = Property::findFirst($_POST['idProperty']);
		
		if (!isset($_POST['required'])){
			$Property->setRequired(0);
		}
		
		// Stocke et vérifie les erreurs
		$success = $Property->update(
				$this->request->getPost(),
				[
						"name",
						"description",
						"prority",
						"required",
				]
				);
	
		if ($success) {
			$this->flash->message("success","Le serveur '".$Property->getName()."' a été modifié avec succès");
			$this->jquery->get($this->controller,"#refresh");
		}
	
		echo $this->jquery->compile();
	}
	public function vDeleteAction($idProperty){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
	
		$Property = Property::findFirst($idProperty);
	
		$semantic=$this->semantic;
		$semantic->setLanguage("fr");
		
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick($this->controller."/index","#index");
	
		$form=$semantic->htmlForm("frmDelete");
		$form->setValidationParams(["on"=>"blur","inline"=>true]);
		$form->addErrorMessage();
		
		$form->addHeader("Voulez-vous vraiment supprimer l'élément : ". $Property->getName()." ? ",3);
	
		$form->addInput("idProperty",NULL,"hidden",$Property->getId());
		 
		$nom=$form->addInput("name","Nom *:","text",NULL,"Confirmer le nom de la propriété")->addRule("empty");
		$nom->getField()->labeledToCorner("asterisk","right");
		
		$form->addButton("submit", "Supprimer","ui negative button")->asSubmit();
		$form->submitOnClick("submit",$this->controller."/confirmDelete","#divAction");
		
		$form->addButton("btnCancel", "Annuler","ui positive button");
	
	
		$this->view->setVars(["element"=>$Property]);
	
		$this->jquery->compile($this->view);
	}
	
	public function confirmDeleteAction(){
		 
		$Property = Property::findFirst($_POST['idProperty']);
	
		if($Property->getName() == $_POST['name']){
			$Property->delete();
	
			$this->flash->message("success","Le propriété '".$_POST['name']."' a été supprimé avec succès");
			$this->jquery->get($this->controller,"#refresh");
	
		}else{
	
			$this->flash->message("error","Le propriété '".$Property->getName()."' n'a pas été supprimé : Le nom ne correspond pas ! ");
			$this->jquery->get($this->controller,"#refresh");
		}
	
		echo $this->jquery->compile();
	}

}

