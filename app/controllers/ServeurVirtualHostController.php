<?php
use Phalcon\Mvc\View;
use Ajax\semantic\html\collections\form\HtmlFormTextarea;
class ServeurVirtualHostController extends ControllerBase{

	public function indexAction(){
	$this->secondaryMenu($this->controller,$this->action);
	$this->tools($this->controller,$this->action);
	
	$this->jquery->compile($this->view);
	}
	

	/* supprimer serveurs */
	public function vDeleteAction($id){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
			
		$Virtualhosts = Virtualhost::findFirst($id);
			
		$semantic=$this->semantic;
	
	
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick("TypeServers","#divAction");
	
		$form=$semantic->htmlForm("frmDelete");
			
		$form->addHeader("Voulez-vous vraiment supprimer le virtualhosts  : ". $Virtualhosts->getName()."?",3);
		$form->addInput("id",NULL,"hidden",$Virtualhosts->getId());
		$form->addInput("name","Nom","text",NULL,"Confirmer le nom du type de serveur");
	
		$form->addButton("submit", "Supprimer","ui green button")->postFormOnClick("ServeurVirtualHost/confirmDelete", "frmDelete","#divAction");
		$form->addButton("cancel", "Annuler","ui red button");
	
	
		$this->view->setVars(["element"=>$Virtualhosts]);
	
		$this->jquery->compile($this->view);
	
	}
	public function confirmDeleteAction(){
		$Virtualhosts= Virtualhost::findFirst($_POST['id']);
			
		if($Virtualhosts->getName() == $_POST['name']){
			$vi->delete();
	
			$this->flash->message("success","Le serveur a été supprimé avec succès");
			$this->jquery->get("Servers","#refresh");
	
		}else{
	
			$this->flash->message("error","Le serveur n'a pas été supprimé : le nom ne correspond pas ! ");
			$this->jquery->get("typeServers/index","#refresh");
		}
			
		echo $this->jquery->compile();
	}
	
	
	/* ajout serveur */
	
	public function vUpdateAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
			
		$host = Host::findFirst();
	
		$stypes = Stype::find();
		$itemsStypes = array();
		foreach($stypes as $stype) {
			$itemsStypes[] = $stype->getName();
		}
	
	
		$hosts = Host::find();
		$itemshost = array();
		foreach($hosts as $host) {
			$itemshost[] = $host->getName();
		}
	
	
		$semantic=$this->semantic;
	
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick("Serveur/index","#index");
	
	
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick("Servers","#divAction");
	
	
		$form=$semantic->htmlForm("frmUpdate");
		$form->addInput("name")->getField()->labeledToCorner("asterisk","right");
	
	
		$input2=$semantic->htmlInput("Configuration...");
		$form->addInput("config")->getField()->labeledToCorner("asterisk","right");
			
	
	
		$form->addDropdown("stype",$itemsStypes,"Type Serveurs : * ","Selectionner un type de serveur ...",false);
		$form->addDropdown("host",$itemshost,"Host : *","Selectionner host ...",false);
	
		$form->addButton("submit", "Valider","ui green button")->postFormOnClick("ServeurVirtualHost/vAddSubmit", "frmUpdate","#divAction");
	
	
		$form->addButton("cancel", "Annuler","ui red button");
			
		$this->jquery->compile($this->view);
	
	
	}
	
	
}