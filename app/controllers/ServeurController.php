<?php
use Phalcon\Mvc\View;
use Ajax\semantic\html\elements\HtmlButtonGroups;
use Ajax\semantic\html\elements\HtmlButton;
class ServeurController extends ControllerBase{

	
	public function indexAction(){
		$this->loadMenus();
		$semantic=$this->semantic;
		$grid=$semantic->htmlGrid("grid");
		$grid->addRow(2)->setValues(["Vincent",$this->createBts("vincent",["Url1"=>"zz","Url2"=>"Index"])]);
		$this->jquery->getOnClick(".clickable", "","#content-container",["attr"=>"data-ajax"]);
		$this->jquery->compile($this->view);
	}
	private function createBts($name,$actions){
		$bts=new HtmlButtonGroups("bg-".$name);
		foreach ($actions as $k=>$action){
				$bt=new HtmlButton($k."-".$action);
				$bt->setValue($k);
				$bt->setProperty("data-ajax", $action);
				$bt->addToProperty("class", "clickable");
				$bts->addElement($bt);
		}
		
		return $bts;
		
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
		$servers=Server::find("idHost=".$idHost);
		$list=$this->semantic->htmlList("lst-hosts");
		
		
		$semantic=$this->semantic;
		
		$table=$semantic->htmlTable('table4',0,5);
		$table->setHeaderValues([" ","Nom du Serveur","Configuration","Modifier","Supprimer"]);
		$i=0;
		
		foreach ($servers as $server){
			$btnConfig = $semantic->htmlButton("btnConfig-".$i,"Configurer","small green basic")->asIcon("edit")->getOnClick("VirtualHosts/config/","#divAction");
			
			
			$btnCancel = $semantic->htmlButton("btnCancel-".$i,"Supprimer","small red")->asIcon("remove")->getOnClick("Serveur/vDelete/","#divAction");
			$table->addRow([" ",$server->getName(),
								$server->getConfig(),$btnConfig,$btnCancel]);
			
			$table->setDefinition();
			$i++;
			
		}
	
		echo $table;
		echo "<br/> <br/>";
		
		$test=$semantic->htmlButton("ajouter","Ajouter","black")->getOnClick("Serveur/vUpdate","#divAction")->setNegative();
		echo $test;
		$this->jquery->exec("$('[data-ajax=".$idHost."]').toggleClass('active');",true);
		
		$list->setInverted()->setDivided()->setRelaxed();
		echo $this->jquery->compile($this->view);
	}
	
	/* ajout serveur */
	
	public function vUpdateAction($id){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		 
		$Server = Server::findFirst($id);
		 
		$semantic=$this->semantic;
	
		$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
		$btnCancel->getOnClick("TypeServers","#divAction");
	
		$form=$semantic->htmlForm("frmUpdate");
		$form->addInput("name","Nom")->setValue($Server->getName());
		$form->addItem(new HtmlFormTextarea("configTemplate","Template"))->setValue($Server->getConfigTemplate())->setRows(10);
		$form->addButton("submit", "Valider")->postFormOnClick("TypeServers/vUpdateSubmit", "frmUpdate","#divAction");
		 
		 
		$this->view->setVars(["Server"=>$Server]);
	
		$this->jquery->compile($this->view);
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
		$form->addButton("submit", "Supprimer")->postFormOnClick("TypeServers/confirmDelete", "frmDelete","#divAction");
		 
		
		$this->view->setVars(["element"=>$Server]);
		
		$this->jquery->compile($this->view);
		
	}
	public function confirmDeleteAction(){
		$Server= Server::findFirst($_POST['id']);
		 
		if($Server->getName() == $_POST['name']){
			$Server->delete();
	
			$this->flash->message("success","Le serveur a été supprimé avec succès");
			$this->jquery->get("Servers","#refresh");
	
		}else{
	
			$this->flash->message("error","Le serveur n'a pas été supprimé : le nom ne correspond pas ! ");
			$this->jquery->get("typeServers/index","#refresh");
		}
		 
		echo $this->jquery->compile();
	}
}
