<?php
use Phalcon\Mvc\View;
use Ajax\semantic\html\collections\form\HtmlFormTextarea;
class TypeServersController extends ControllerBase
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
    	
    	
    	$typeServers = Stype::find();
    	
    	$i=0;
    	foreach ($typeServers as $typeServer){
    		$btnUpdate = $semantic->htmlButton("btnUpdate-".$i,"Modifier","small green basic")->asIcon("edit")->getOnClick($this->controller."/vUpdate/".$typeServer->getId(),"#divAction");
    		$btnDelete = $semantic->htmlButton("btnDelete-".$i,"Supprimer","small red basic")->asIcon("remove")->getOnClick($this->controller."/vDelete/".$typeServer->getId(),"#divAction");
    		$table->addRow([/*$typeServer->getId()*/$i+1,$typeServer->getName(),$btnUpdate.$btnDelete]);
    		$i++;
    	}
    	
    	$this->view->setVars(["typeServers"=>$typeServers]);
    	$this->jquery->compile($this->view);
    	
    }
    
    public function vAddAction($nom=NULL){
    	$this->tools($this->controller,$this->action);
 
    	$semantic=$this->semantic;

    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick($this->controller."/index","#index");
    	
    	$form=$semantic->htmlForm("frmAdd");
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	$form->addInput("name","Nom * :","text",false,"Nom du type de serveur")->addRule("empty");
    	$form->addItem(new HtmlFormTextarea("configTemplate","Template * :",false,"Template"))->setRows(10);
    	//$form->addButton("","Valider")->asSubmit();
    	$form->addButton("submit", "Valider","ui blue button")->postFormOnClick($this->controller."/vAddSubmit", "frmAdd","#divAction");
    	$form->addButton("btnCancel", "Annuler","ui red button");
    	$form->addErrorMessage();
    	
    	
    	$this->jquery->compile($this->view);
    }
    
    public function vAddSubmitAction(){
    	
    	if(!empty($_POST['name']) && !empty($_POST['configTemplate'])){
	    	$Stype = new Stype();

	    	$Stype->save(
	    			$this->request->getPost(),
	    			[
	    					"name",
	    					"configTemplate",
	    			]
	    			);
	    	
	    	$this->flash->message("success", "Le serveur '".$_POST['name']."' a été inseré avec succès");
	    	$this->jquery->get($this->controller,"#refresh");
    	
    	}else{
    		$this->flash->message("error", "Veuillez remplir tous les champs");
    		$this->jquery->get($this->controller,"#refresh");
    	}
    	echo $this->jquery->compile();
    }
    
    public function vUpdateAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
    	$typeServer = Stype::findFirst($id);
    	
    	$semantic=$this->semantic;
    	 
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick($this->controller."/index","#index");
    	
    	$form=$semantic->htmlForm("frmUpdate");
    	$form->addInput("id",NULL,"hidden",$typeServer->getId());
    	$form->addInput("name","Nom *:")->setValue($typeServer->getName());
    	$form->addItem(new HtmlFormTextarea("configTemplate","Template *:"))->setValue($typeServer->getConfigTemplate())->setRows(10);

    	$form->addButton("submit", "Valider","ui positive button")->postFormOnClick($this->controller."/vUpdateSubmit", "frmUpdate","#divAction");
    	$form->addButton("btnCancel", "Annuler","ui red button");
    	
    	$form->addButton("button", "Gestion propriétés","ui green basic button")->getOnClick("typeProperty/vUpdate/".$id,"#index");
    	
    	
    	
    	$this->view->setVars(["typeServer"=>$typeServer]);

    	$this->jquery->compile($this->view);
    }
    
    public function vUpdateSubmitAction(){
    	$Stype = Stype::findFirst($_POST['id']);
    	// Stocke et vérifie les erreurs
    	$success = $Stype->update(
    			$this->request->getPost(),
    			[
    					"name",
    					"configTemplate",
    			]
    			);
    	 
    	if ($success) {
    		$this->flash->message("success","Le serveur '".$Stype->getName()."' a été modifié avec succès");
    		$this->jquery->get($this->controller,"#refresh");
    	}
    	
    	echo $this->jquery->compile();
    }
    public function vDeleteAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
    	$typeServer = Stype::findFirst($id);
    	
    	$semantic=$this->semantic;
    	
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick($this->controller."/index","#index");
    	 
    	$form=$semantic->htmlForm("frmDelete");
    	
    	$form->addHeader("Voulez-vous vraiment supprimer l'élément : ". $typeServer->getName()." ? ",3);
    	$form->addInput("id",NULL,"hidden",$typeServer->getId());
    	$form->addInput("name","Nom *:","text",NULL,"Confirmer le nom du type de serveur");
    	$form->addButton("submit", "Supprimer","ui negative button")->postFormOnClick($this->controller."/confirmDelete", "frmDelete","#divAction");
    	$form->addButton("btnCancel", "Annuler","ui positive button");
    	
      	 
    	$this->view->setVars(["element"=>$typeServer]);
    
    	$this->jquery->compile($this->view);
    }
    
    public function confirmDeleteAction(){
    	$Stype = Stype::findFirst($_POST['id']);
    	
    	if($Stype->getName() == $_POST['name']){
    		$Stype->delete();
    		
    		$this->flash->message("success","Le type de serveur '".$_POST['name']."' a été supprimé avec succès");
    		$this->jquery->get($this->controller,"#refresh");
    		
    	}else{
    		
    		$this->flash->message("error","Le type de serveur '".$_POST['name']."' n'a pas été supprimé : le nom ne correspond pas ! ");
    		$this->jquery->get($this->controller,"#refresh");
    	}
    	
    	echo $this->jquery->compile();
    }
}

