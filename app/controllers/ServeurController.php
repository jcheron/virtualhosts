<?php

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
		$this->jquery->getOnClick("#lst-hosts .item","Serveur/servers","#servers",["attr"=>"data-ajax"]);
		$this->jquery->compile($this->view);
		
	}
	
	public function serversAction($idHost=NULL){
		$servers=Server::find("idHost=".$idHost);
		$list=$this->semantic->htmlList("lst-hosts");
		
		
		$semantic=$this->semantic;
		
		$table=$semantic->htmlTable('table4',0,5);
		$table->setHeaderValues([" ","Nom du Serveur","Configuration"," "]);
		
		foreach ($servers as $server){
			
			
			$table->addRow([" ",$server->getName(),
								$server->getConfig()," ",$buttons=$semantic->htmlButtonGroups("bg1",array("Supprimer","Configurer"))]);
			
			
			$table->setDefinition();
		}
		echo $table;

		echo "<br/> <br/>";
		$ajout=$semantic->htmlButton("ajouter","Ajouter")->getOnClick("virtualhosts/"," ")->setNegative();
		echo $ajout;
		
		
		
		
		$list->setInverted()->setDivided()->setRelaxed();
		$this->jquery->compile($this->view);
	}
	
	/* supprimer serveurs */
	public function deleteserveurAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		$semantic=$this->semantic;
	}
	
	/*ajouter serveurs*/
	public function ajoutserveurAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		$semantic=$this->semantic;
	}
}
