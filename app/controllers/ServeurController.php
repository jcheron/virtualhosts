<?php
use Phalcon\Mvc\View;
use Ajax\semantic\html\collections\form\HtmlFormTextarea;
use Ajax\semantic\html\modules\checkbox\HtmlCheckbox;
use Ajax\semantic\html\elements\HtmlButton;
use Ajax\semantic\html\elements\HtmlInput;
use Ajax\Semantic;
use Ajax\semantic\html\elements\HtmlIcon;
use Phalcon\Db;
use Phalcon\Db\Adapter\Pdo;
class ServeurController extends ControllerBase{

	
	public function indexAction(){
	
	}

	
	public function diversAction(){
		$this->loadMenus();
		$dd=$this->semantic->htmlDropdown("dd");
		$dd->asSelect("vh")->asSearch("vh");
		$virtualhosts=Virtualhost::find();
		$dd->fromDatabaseObjects($virtualhosts, function($vh){
			return $vh->getName();
		});
		
		
			$table=$this->semantic->htmlTable("table", 0, 2);
			$table->setHeaderValues(["id","Nom"]);
			$sTypes=Stype::find();
			foreach ($sTypes as $sType){
				$table->addRow([$sType->getId(),$sType->getName()]);
			}
	}
	
	public function hostsAction($user=NULL){
		$this->loadMenus();
		$hosts=Host::find();
		
		$list=$this->semantic->htmlList("lst-hosts");
		foreach ($hosts as $host){
			$item=$list->addItem(["icon"=>"add","header"=>$host->getName(),"description"=>$host->getIpv4()]);
			$item->addToProperty("data-ajax", $host->getId());
		}
		$list->setHorizontal();
		
		
		$list->setSelection();
		
		
		
		$this->jquery->getOnClick("#lst-hosts .item","Serveur/servers","#servers",["attr"=>"data-ajax"]);
		$this->jquery->compile($this->view);
		
	}
	
	public function serversAction($idHost=NULL){
		
		$virtualhosts=Virtualhost::find("$idHost = ".$idHost);
		$servers=Server::find("idHost=".$idHost);
		$list=$this->semantic->htmlList("lst-hosts");
		
		$semantic=$this->semantic;
		
		$table=$semantic->htmlTable('table4',0,6);
		$table->setHeaderValues([" ","Nom du Serveur","Configuration","Modifier","Supprimer","Nombre Virtualhost(s)"]);
		$i=0;
				
		foreach ($servers as $server){
			
			$btnConfig = $semantic->htmlButton("btnConfig-".$i,"Configurer","small green basic")->asIcon("edit")->getOnClick("Serveur/virtual/".$server->getId(),"#divAction");
			$id = $server->getId();
			$nbrvirtual = count(Virtualhost::find("idServer = ".$id));
				
			
			if ($nbrvirtual == 0 )
			{
				$btnDelete = $semantic->htmlButton("btnDelete-".$i,"Supprimer","small red")->asIcon("remove")->getOnClick("Serveur/vDelete/".$server->getId(),"#divAction");
				$table->addRow([" ",$server->getName(),
						$server->getConfig(),$btnConfig,$btnDelete,$nbrvirtual]);
				
				
			}
		
			else {
						$table->addRow([" ",$server->getName(),
						$server->getConfig(),$btnConfig," ",$nbrvirtual]);
				
			}
			
				
			$table->setDefinition();
			$i++;
				
		}
		
		
	
		echo $table;
		echo "<br/> <br/>";
		
		$test=$semantic->htmlButton("ajouter","Ajouter","black")->getOnClick("Serveur/vUpdate","#divAction")->setNegative();
		echo $test;
		$this->jquery->exec("$('#lst-hosts .item').removeClass('active');",true);
		$this->jquery->exec("$('[data-ajax=".$idHost."]').addClass('active');",true);
		$list->setInverted()->setDivided()->setRelaxed();
	
		
		
		echo $this->jquery->compile($this->view);
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
		
		$form->addButton("submit", "Valider","ui green button")->postFormOnClick("Serveur/vAddSubmit", "frmUpdate","#divAction");
		

		$form->addButton("cancel", "Annuler","ui red button")->postFormOnClick("Serveur/hosts", "frmDelete","#tab");
		
		
		$this->jquery->compile($this->view);
		
		
	}
	

	public function vAddSubmitAction(){
		if(!empty($_POST['name'] && $_POST['config'] && $_POST['stype'] && $_POST['host'])){
			$Server = new Server();
	
			$idhost = Host::findFirst("name = '".$_POST['host']."'");
			$idstype = Stype::findFirst("name = '".$_POST['stype']."'");
			
			$Server->setIdStype($idstype->getId());
			$Server->setIdHost($idhost->getId());
			$Server->save(
					$this->request->getPost(),
					[
							"name",
							"config",
					
					]
					);
	
			
			$this->jquery->get("Serveur/hosts/","#tab");
			$this->flash->message("success", "Le serveur a été inseré avec succès");
			//$this->jquery->get("Serveur","#refresh");
					
			 
		}else{
			$this->flash->message("error", "Veuillez remplir tous les champs");
			
		}
		

		
		echo $this->jquery->compile();
		
	}
	
	
	
	/* supprimer serveurs */
	public function vDeleteAction($id){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		 
		$Server = Server::findFirst($id);
		 
		$semantic=$this->semantic;
		
		
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick("TypeServers","#divAction");
		
		$form=$semantic->htmlForm("frmDelete");
		 
		$form->addHeader("Voulez-vous vraiment supprimer le serveur : ". $Server->getName()."?",3);
		$form->addInput("id",NULL,"hidden",$Server->getId());
		$form->addInput("name","Nom","text",NULL,"Confirmer le nom du type de serveur");
		
		$form->addButton("submit", "Supprimer","ui green button")->postFormOnClick("Serveur/confirmDelete", "frmDelete","#divAction");
		
		
		
		$form->addButton("cancel", "Annuler","ui red button")->postFormOnClick("Serveur/hosts", "frmDelete","#tab");

		
		$this->view->setVars(["element"=>$Server]);
		
		$this->jquery->compile($this->view);
		
	}
	public function confirmDeleteAction(){
		$Server= Server::findFirst($_POST['id']);
		 
		if($Server->getName() == $_POST['name']){
			$Server->delete();
	
			
			$this->jquery->get("Serveur/hosts/","#tab");
			
			$this->flash->message("success","Le serveur a été supprimé avec succès");
	
		}else{
	
			
				$this->jquery->get("Serveur/hosts/","#tab");
		}
		 
		echo $this->jquery->compile();
		
	}
	
	
	
	
	/* virtualhost */
	
	
	
	/* virtualhost du serveur */
	
	public function virtualAction($idServer=NULL,$idhost=NULL){
	
		$virtualhosts=Virtualhost::find("idServer=".$idServer."");

		
		if($virtualhosts->count() == 0 ){
			$semantic=$this->semantic;
			
			$ajoutervirtual=$semantic->htmlButton("ajoutervirtual","Ajouter","black")->getOnClick("Serveur/vUpdatevirtual","#divAction")->setNegative();
			
		}
		
		else {
			
			$list=$this->semantic->htmlList("virtual");
			
			$semantic=$this->semantic;
			
		
			
			$table=$semantic->htmlTable('table4',0,6);
			$table->setHeaderValues([" ","Nom du Virtualhosts","Configuration","Modifier","Supprimer"]);
			$i=0;
			
			echo "<h3> Liste des virtualhosts : </h3>";
			foreach ($virtualhosts as $virtualhost){
				$btnConfigvirtual= $semantic->htmlButton("btnConfigvirtual-".$i,"Configurer","small green basic")->asIcon("edit")->getOnClick("Serveur/vChangevirtual/".$virtualhost->getId(),"#divAction");
					
				$ajoutervirtual=$semantic->htmlButton("ajoutervirtual","Ajouter","black")->getOnClick("Serveur/vUpdatevirtual","#divAction")->setNegative();
					
				$btnDelete = $semantic->htmlButton("btnDeleteVirtual-".$i,"Supprimer","small red")->asIcon("remove")->getOnClick("Serveur/vDeletevirtual/".$virtualhost->getId(),"#divAction");
					
				$table->addRow([" ",$virtualhost->getName(),
						$virtualhost->getConfig(),$btnConfigvirtual,$btnDelete]);
			
				$table->setDefinition();
				$i++;
			
			}
			echo $table;
			echo "<br/> <br/>";
			$this->jquery->exec("$('#divAction .item').removeClass('active');",true);
			$this->jquery->exec("$('[data-ajax=".$idhost."]').addClass('active');",true);
			$list->setInverted()->setDivided()->setRelaxed();
			
		}
	
		echo $this->jquery->compile($this->view);
	}
	

	/* supprimer virtualhost */
	public function vDeletevirtualAction($id){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
			
		$Virtualhost = Virtualhost::findFirst($id);
			
		$semantic=$this->semantic;
	
	
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick("TypeServers","#divAction");
	
		$form=$semantic->htmlForm("frmDelete");
			
		$form->addHeader("Voulez-vous vraiment supprimer le virtualhost : ". $Virtualhost->getName()."?",3);
		$form->addInput("id",NULL,"hidden",$Virtualhost->getId());
		$form->addInput("name","Nom","text",NULL,"Confirmer le nom du virtualhost");
	
		$form->addButton("submit", "Supprimer","ui green button")->postFormOnClick("Serveur/confirmDeletevirtual", "frmDelete","#divAction");


		$form->addButton("cancel", "Annuler","ui red button")->postFormOnClick("Serveur/hosts", "frmDelete","#tab");
		
		
		$this->view->setVars(["element"=>$Virtualhost]);
	
		$this->jquery->compile($this->view);
	
	}
	public function confirmDeletevirtualAction(){
		$Virtualhost= Virtualhost::findFirst($_POST['id']);
			
		if($Virtualhost->getName() == $_POST['name']){
			$Virtualhost->delete();
	
			$this->flash->message("success","Le virtualhost a été supprimé avec succès");
			$this->jquery->get("Serveur/hosts/","#tab");
			
	
		}else{
	
			$this->flash->message("error","Le virtualhost n'a pas été supprimé : le nom ne correspond pas ! ");
			$this->jquery->get("Serveur/index","#test");
		}
			
		echo $this->jquery->compile();
	}
	
	
	/* ajout les virtualhost du serveur */
	public function vUpdatevirtualAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
			
		$stypes = Stype::find();
		$servers = Server::find();
		
		$itemservers = array();
		foreach($servers as $server) {
			$itemservers[] = $server->getName();
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
			
		
		
		$form->addDropdown("server",$itemservers,"Nom du Serveurs : * ","Selectionner un nom de serveur ...",false);
		
		$form->addButton("submit", "Valider","ui green button")->postFormOnClick("Serveur/vAddSubmitvirtual", "frmUpdate","#divAction");
		
		

		$form->addButton("cancel", "Annuler","ui red button")->postFormOnClick("Serveur/hosts", "frmDelete","#tab");
		
			
		$this->jquery->compile($this->view);
		
		
	}
	public function vAddSubmitvirtualAction(){
		if(!empty($_POST['name'] && $_POST['config'] && $_POST['server'])){
			$Virtualhost = new Virtualhost();
	
			$idserver = Server::findFirst("name = '".$_POST['server']."'");
			
				
			
			$Virtualhost->setIdServer($idserver->getId());
			
			$Virtualhost->save(
					$this->request->getPost(),
					[
							"name",
							"config",
								
					]
					);
	
		
			$this->jquery->get("Serveur/hosts/","#tab");
			
			$this->flash->message("success", "Le serveur a été inseré avec succès");
			
			
		}else{
			$this->flash->message("error", "Veuillez remplir tous les champs");
				
		}
	
	
	
		echo $this->jquery->compile();
	
	}
	
	/* modifier le virtualhost*/
	
	public function vChangevirtualAction($idvirtualhost){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
				 
		$virtualhosts = Virtualhost::findFirst($idvirtualhost);
	
		
		$hosts = Host::find();
		
		$itemhost = array();
		foreach($hosts as $host) {
			$itemhost[] = $host->getName();
		}
		
		$servers = Server::find();
		
		$itemservers = array();
		foreach($servers as $server) {
			$itemservers[] = $server->getName();
		}
		
		
					 
		$semantic=$this->semantic;
		
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick($this->controller."/index","#index");
		 
		$form=$semantic->htmlForm("frmUpdate");
		$form->addInput("id",NULL,"hidden",$virtualhosts->getId());
		$form->addInput("name","Changer de Nom *:")->setValue($virtualhosts->getName());	
		$form->addInput("config","Changer sa configuration :")->setValue($virtualhosts->getConfig());
		
		
		$form->addDropdown("host",$itemhost,"Nom du nouveau Host :  ","Nouveau host ...",false);

		$form->addDropdown("server",$itemservers,"Nom du Serveurs : * ","Selectionner un nom de serveur ...",false);
		
		

		if(!isset($idVirtualhost) || $idVirtualhost == "modifier"){
			$idVirtualhost=2;
		}
		
	
		
		
		
		$form->addButton("submit", "Valider","ui positive button")->postFormOnClick($this->controller."/vAddSubmitvirtual", "frmUpdate","#divAction");
		$form->addButton("btnCancel", "Annuler","ui red button");
		 
		
		$this->jquery->compile($this->view);
		
		
	}
	
	
}
