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
    	
    	$table = $semantic->htmlTable("table",0,2);
    	$table->setHeaderValues(["id","nom","id","Action"]);
    	$btnUpdate = $semantic->htmlButton("btnAdd","Ajouter","green")->getOnClick("TypeServers/vAdd","#divAdd");
    	$typeServers = Stype::find(); 
    	foreach ($typeServers as $typeServer){
    		$table->addRow([$typeServer->getId(),$typeServer->getName(),$btnUpdate]);
    	}
    	$this->jquery->compile($this->view);
    	//$this->view->setVars(["Stypes"=>$typeServers]);
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

}

