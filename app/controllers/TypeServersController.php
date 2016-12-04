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
    	
    	//$table = $semantic->htmlTable("table",0,3);
    	//$table->setHeaderValues(["id","nom","Action"]);
    	$semantic->htmlButton("btnAdd","Ajouter","blue")->getOnClick("TypeServers/vAdd","#divAdd");
    	
    	//$btnUpdate = $semantic->htmlButton("btnUpdate","Modifier","green")->getOnClick("TypeServers/vUpdate");
    	$typeServers = Stype::find(); 
    	/*foreach ($typeServers as $typeServer){
    		$btnUpdate = $semantic->htmlButton("btnUpdate","Modifier","green")->getOnClick("TypeServers/vUpdate/".$typeServer->getId(),"#divAdd");
    		$table->addRow([$typeServer->getId(),$typeServer->getName(),$btnUpdate]);
    	}*/
    	$this->view->setVars(["typeServers"=>$typeServers]);
    	$this->jquery->compile($this->view);
    	
    }
    
    public function vAddAction(){
    	$semantic=$this->semantic;
    	$form=$semantic->htmlForm("frmAdd");
    	$form->addInput("Nom","Nom");
    	$form->addItem(new HtmlFormTextarea("template","Template"))->setRows(2);
    	$form->addButton("","Submit")->asSubmit();
    }
    
    public function vAddSubmitAction(){
    	$Stype = new Stype();
    	// Stocke et vérifie les erreurs
    	$success = $Stype->save(
    			$this->request->getPost(),
    			[
    					"name",
    					"configTemplate",
    			]
    			);
    	
    	if ($success) {
    		echo "Le serveur a été inseré avec succès";
    	} 
    }
    
    public function vUpdateAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	$semantic=$this->semantic;
    	
    	$typeServer = Stype::findFirst($id);
    	
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
    		echo "Le serveur a été modifié avec succès";
    	}
    }

}

