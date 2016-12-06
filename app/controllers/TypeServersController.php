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
    	$table->setHeaderValues(["id","nom","Action"]);
    	
    	$btnAdd = $semantic->htmlButton("btnAdd","Ajouter","fluid ui button blue");
    	$btnAdd->getOnClick("TypeServers/vAdd","#divAction");
    	
    	
    	$typeServers = Stype::find();
    	
    	$i=0;
    	foreach ($typeServers as $typeServer){
    		$btnUpdate = $semantic->htmlButton("btnUpdate-".$i,"Modifier","small green basic")->asIcon("edit")->getOnClick("TypeServers/vUpdate/".$typeServer->getId(),"#divAction");
    		$btnDelete = $semantic->htmlButton("btnDelete-".$i,"Supprimer","small red")->asIcon("remove")->getOnClick("TypeServers/vDelete/".$typeServer->getId(),"#divAction");
    		$table->addRow([/*$typeServer->getId()*/$i+1,$typeServer->getName(),$btnUpdate.$btnDelete]);
    		$i++;
    	}
    	
    	$this->view->setVars(["typeServers"=>$typeServers]);
    	$this->jquery->compile($this->view);
    	
    }
    
    public function vAddAction(){
    	$this->tools($this->controller,$this->action);
 
    	$semantic=$this->semantic;
    	
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick("TypeServers/index","#index");
    	
    	$form=$semantic->htmlForm("frmAdd");
    	$form->addInput("name","Nom * :");
    	$form->addItem(new HtmlFormTextarea("configTemplate","Template * :"))->setRows(10);
    	//$form->addButton("","Valider")->asSubmit();
    	$form->addButton("submit", "Valider","ui blue button")->postFormOnClick("TypeServers/vAddSubmit", "frmAdd","#divAction");
    	$form->addButton("btnCancel", "Annuler","ui red button");
    	
    	
    	
    	$this->jquery->compile($this->view);
    }
    
    public function vAddSubmitAction(){
    	
    	if(!empty($_POST['name'] && $_POST['configTemplate'])){
	    	$Stype = new Stype();

	    	$Stype->save(
	    			$this->request->getPost(),
	    			[
	    					"name",
	    					"configTemplate",
	    			]
	    			);
	    	
	    	$this->flash->message("success", "Le serveur a été inseré avec succès");
	    	$this->jquery->get("typeServers","#refresh");
    	
    	}else{
    		$this->flash->message("error", "Veuillez remplir tous les champs");
    	}
    	echo $this->jquery->compile();
    }
    
    public function vUpdateAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
    	$typeServer = Stype::findFirst($id);
    	
    	$semantic=$this->semantic;
    	 
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick("TypeServers/index","#index");
    	 
    	$form=$semantic->htmlForm("frmUpdate");
    	$form->addInput("id",NULL,"hidden",$typeServer->getId());
    	$form->addInput("name","Nom *:")->setValue($typeServer->getName());
    	$form->addItem(new HtmlFormTextarea("configTemplate","Template *:"))->setValue($typeServer->getConfigTemplate())->setRows(10);

    	$form->addButton("submit", "Valider","ui positive button")->postFormOnClick("TypeServers/vUpdateSubmit", "frmUpdate","#divAction");
    	$form->addButton("btnCancel", "Annuler","ui red button");
    	
    	
    	
    	
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
    		$this->flash->message("success","Le serveur a été modifié avec succès");
    		$this->jquery->get("typeServers","#refresh");
    	}
    	
    	echo $this->jquery->compile();
    }
    public function vDeleteAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
    	$typeServer = Stype::findFirst($id);
    	
    	$semantic=$this->semantic;
    	
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick("TypeServers/index","#index");
    	 
    	$form=$semantic->htmlForm("frmDelete");
    	
    	$form->addHeader("Voulez-vous vraiment supprimer l'élément : ". $typeServer->getName()." ? ",3);
    	$form->addInput("id",NULL,"hidden",$typeServer->getId());
    	$form->addInput("name","Nom *:","text",NULL,"Confirmer le nom du type de serveur");
    	$form->addButton("submit", "Supprimer","ui negative button")->postFormOnClick("TypeServers/confirmDelete", "frmDelete","#divAction");
    	$form->addButton("btnCancel", "Annuler","ui positive button");
    	
      	 
    	$this->view->setVars(["element"=>$typeServer]);
    
    	$this->jquery->compile($this->view);
    }
    
    public function confirmDeleteAction(){
    	$Stype = Stype::findFirst($_POST['id']);
    	
    	if($Stype->getName() == $_POST['name']){
    		$Stype->delete();
    		
    		$this->flash->message("success","Le serveur a été supprimé avec succès");
    		$this->jquery->get("typeServers","#refresh");
    		
    	}else{
    		
    		$this->flash->message("error","Le serveur n'a pas été supprimé : le nom ne correspond pas ! ");
    		$this->jquery->get("typeServers","#refresh");
    	}
    	
    	echo $this->jquery->compile();
    }
}

