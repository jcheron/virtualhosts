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
	
		$table = $semantic->htmlTable("table",0,3);
		$table->setHeaderValues(["#","nom","Action"]);
	
		$btnAdd = $semantic->htmlButton("btnAdd","Ajouter","fluid ui button blue");
		$btnAdd->getOnClick($this->controller."/vAdd","#divAction");
	
		$Properties = Property::find();
	
		$i=0;
		foreach ($Properties as $Property){
			$btnUpdate = $semantic->htmlButton("btnUpdate-".$i,"Modifier","small green basic")->asIcon("edit")->getOnClick($this->controller."/vUpdate/".$Property->getId(),"#divAction");
			$btnDelete = $semantic->htmlButton("btnDelete-".$i,"Supprimer","small red basic")->asIcon("remove")->getOnClick($this->controller."/vDelete/".$Property->getId(),"#divAction");
			$table->addRow([$i+1,$Property->getName(),$btnUpdate.$btnDelete]);
			$i++;
		}
	
		$this->view->setVars(["Property"=>$Property]);
		$this->jquery->compile($this->view);
	}
	public function vAddAction(){
		$this->tools($this->controller,$this->action);
		
		$semantic=$this->semantic;
		 
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick($this->controller."/index","#index");
		 
		$form=$semantic->htmlForm("frmAdd");
		
		$form->addInput("name","Nom * :","text",false,"Nom de la propriété");
		$fields=$form->addFields();
		
		$fields->addItem(new HtmlFormTextarea("description","Description * :",false,"Description"))->setWidth(8);
		$fields->addInput("prority","position","number",FALSE,"Saisir un chiffre ")->setWidth(8);
		
		//$fields->addItem(new HtmlFormCheckbox("prority",c,"1","checkbox"))->setWidth(3);
		$form->addItem(new HtmlFormCheckbox("required","Requis ?","1","checkbox"))->setWidth(4);
		
		$form->addButton("submit", "Valider","ui blue button")->postFormOnClick($this->controller."/vAddSubmit", "frmAdd","#divAction");
		$form->addButton("btnCancel", "Annuler","ui red button");
		 
		 
		 
		$this->jquery->compile($this->view);
	}
	
	public function vAddSubmitAction(){
		var_dump($_POST);
		if(!empty($_POST['name']) && !empty($_POST['description'])){
			
			$Property = new Property();
	
			if(!isset($_POST['prority'])){
				$Property->setPrority(0);
			}
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

		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick($this->controller."/index","#index");
	
		$form=$semantic->htmlForm("frmUpdate");

		$form->addInput("name","Nom *:")->setValue($Property->getName());
		$form->addInput("idProperty",NULL,"hidden",$Property->getId());
		$fields=$form->addFields();
		$fields->addItem(new HtmlFormTextarea("description","Description * :",$Property->getDescription(),"Description"))->setWidth(10);
		$fields->addItem(new HtmlFormCheckbox("prority","Prority ?","1","checkbox"))->setWidth(3);
		$fields->addItem(new HtmlFormCheckbox("required","Requis ?","1","checkbox"))->setWidth(3);
		
		$form->addButton("submit", "Valider","ui positive button")->postFormOnClick($this->controller."/vUpdateSubmit", "frmUpdate","#divAction");
		$form->addButton("btnCancel", "Annuler","ui red button");	
	
		$this->view->setVars(["Property"=>$Property]);
	
		$this->jquery->compile($this->view);
	}
	
	public function vUpdateSubmitAction(){
		$Property = Property::findFirst($_POST['idProperty']);
		
		if(!isset($_POST['prority'])){
			$Property->setPrority(0);
		}
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
	
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick($this->controller."/index","#index");
	
		$form=$semantic->htmlForm("frmDelete");
	
		$form->addHeader("Voulez-vous vraiment supprimer l'élément : ". $Property->getName()." ? ",3);
	
		$form->addInput("idProperty",NULL,"hidden",$Property->getId());
		 
		$form->addInput("name","Nom *:","text",NULL,"Confirmer le nom de la propriété");
		$form->addButton("submit", "Supprimer","ui negative button")->postFormOnClick($this->controller."/confirmDelete", "frmDelete","#divAction");
		$form->addButton("btnCancel", "Annuler","ui positive button");
	
	
		$this->view->setVars(["element"=>$Property]);
	
		$this->jquery->compile($this->view);
	}
	
	public function confirmDeleteAction(){
		 
		$Property = Property::findFirst($_POST['idProperty']);
	
		if($Property->getName() == $_POST['name']){
			$Property->delete();
	
			$this->flash->message("success","Le type de propriété '".$_POST['name']."' a été supprimé avec succès");
			$this->jquery->get($this->controller,"#refresh");
	
		}else{
	
			$this->flash->message("error","Le type de propriété '".$_POST['name']."' n'a pas été supprimé : le nom ne correspond pas ! ");
			$this->jquery->get($this->controller,"#refresh");
		}
	
		echo $this->jquery->compile();
	}

}

