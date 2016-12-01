<?php

class VirtualHostsController extends ControllerBase
{
	public function indexAction()
	{
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		$this->jquery->compile($this->view);
	}
	
	public function configAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$virtualHosts = Virtualhost::findFirst();
		$server=$virtualHosts->getServer();
		$host=$server->getHost();
		
		if($host->getIpv6() == ""){$IPv6 = "Aucune attribuée";}else{$IPv6 = $host->getIpv6();}
		
		$this->view->setVar("virtualHost", $virtualHosts);
		$table=$this->semantic->htmlTable("infos",0,4);
		$table->setHeaderValues(["Machine","Serveur","Adresse IPv6","Adresse IPv6"]);
		$table->addRow([$host->getName(),$server->getName(),$host->getIpv4(),$IPv6]);
		
		$modifier=$this->semantic->htmlButton("edit","Modifier");
		$modifier->setPositive();
		$modifier->asLink("VirtualHosts/edit");
		
		$buttons=$this->semantic->htmlButtonGroups("importOrExport",array("Importer","Exporter"));
		$buttons->insertOr(0,"ou");
	
		
    	$this->jquery->exec("Prism.highlightAll();",true);
		$this->jquery->compile($this->view);
	}
	
	public function editApacheAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$this->jquery->compile($this->view);
	}
}