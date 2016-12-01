<?php

use Ajax\semantic\html\elements\HtmlButtonGroups;
use Ajax\semantic\html\elements\HtmlButton;
class TmpController extends ControllerBase{

	
	
	public function indexAction(){
		$this->loadMenus();
		$semantic=$this->semantic;
		$grid=$semantic->htmlGrid("grid");
		$grid->addRow(2)->setValues(["Vincent",$this->createBts("vincent",["Serveurs"=>"Accueil/Serveur"],"red")]);
		$grid->addRow(2)->setValues(["Yann",$this->createBts("yann",["Connexion"=>"Accueil/connect","Reload config"=>"Config/index"])]);
		$grid->addRow(2)->setValues(["Thomas",$this->createBts("thomas",["Config virtualhost"=>"VirtualHosts/config"])]);
		$grid->addRow(2)->setValues(["Edouard",$this->createBts("ed",["Gest. rôles"=>"ManageRole/index","Gest. utilisateurs"=>"ManageUsers/index"])]);
		$grid->addRow(2)->setValues(["Romain",$this->createBts("romain",["Infos compte"=>"InfoCompte/ModifInfo"])]);
		$grid->addRow(2)->setValues(["Anthony",$this->createBts("anthony",["Liste hosts & virtualhost"=>"Listhostvirtual/listhv"])]);
		$grid->addRow(2)->setValues(["Aboudou",$this->createBts("aboudou",["Gest. types servers"=>"TypeServers/index"])]);
		$this->jquery->getOnClick(".clickable", "","#content-container",["attr"=>"data-ajax"]);
		$this->jquery->compile($this->view);
	}
	
	private function createBts($name,$actions,$color=""){
		$bts=new HtmlButtonGroups("bg-".$name);
		foreach ($actions as $k=>$action){
				$bt=new HtmlButton($k."-".$action);
				$bt->setValue($k);
				$bt->setProperty("data-ajax", $action);
				$bt->addToProperty("class", "clickable");
				$bt->setColor($color);
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
		$list->setHorizontal()->setSelection();
		$this->jquery->getOnClick("#lst-hosts .item","Tmp/servers","#servers",["attr"=>"data-ajax"]);
		$this->jquery->compile($this->view);
		
	}
	
	public function serversAction($idHost=NULL){
		$servers=Server::find("idHost=".$idHost);
		$list=$this->semantic->htmlList("lst-hosts");
		foreach ($servers as $server){
			$item=$list->addItem(["icon"=>"delete","header"=>$server->getName()]);
		}
		$list->setInverted()->setDivided()->setRelaxed();
		echo $list->compile();
	}
}

