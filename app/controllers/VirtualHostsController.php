<?php
use Ajax\semantic\html\elements\HtmlList;
use Ajax\semantic\html\modules\checkbox\HtmlCheckbox;
use Ajax\semantic\html\elements\HtmlButton;
use Ajax\semantic\html\elements\HtmlInput;
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
		
		$semantic=$this->semantic;
		
		$virtualHosts = Virtualhost::findFirst();
		$server=$virtualHosts->getServer();
		$host=$server->getHost();
		
		if($host->getIpv6() == ""){$IPv6 = "Aucune attribuée";}else{$IPv6 = $host->getIpv6();}
		
		$this->view->setVar("virtualHost", $virtualHosts);
		
		$table=$this->semantic->htmlTable("infos",0,4);
		$table->setHeaderValues(["Machine","Serveur","Adresse IPv6","Adresse IPv6"]);
		$table->addRow([$host->getName(),$server->getName(),$host->getIpv4(),$IPv6]);
			
		$semantic->htmlButton("modifier","Modifier","black")->getOnClick("VirtualHosts/editApache","#modification")->setPositive();
		
		$buttons=$this->semantic->htmlButtonGroups("importOrExport",array("Importer","Exporter"));
		$buttons->insertOr(0,"ou");
	
		
    	$this->jquery->exec("Prism.highlightAll();",true);
		$this->jquery->compile($this->view);
	}
	
	public function editApacheAction($idVirtualhost=NULL){
		$idVirtualhost=2;
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		$semantic=$this->semantic;
		
		$virtualHostProperties=Virtualhostproperty::find("idVirtualhost={$idVirtualhost}");
		$table=$semantic->htmlTable('infos',0,5);
		$table->setHeaderValues(["","Nom","Description","Valeur actuelle","Nouvelle valeur"]);
		$i=0;
		
		foreach ($virtualHostProperties as $virtualHostProperty){
			$property=$virtualHostProperty->getProperty();
			$value=$virtualHostProperty->getValue();
			$input=new HtmlInput("value[]","text",$value,"Nouvelle valeur");
			$input->setProperty("data-input", "check$i");
			$table->addRow([HtmlCheckbox::slider("check$i")->setFitted(),
					$property->getName(), $property->getDescription(),
					$value,($input)
					.(new HtmlInput("id[]","hidden",$property->getId()))
					
			]);

				
			$i=$i+1;
		}
		
		$semantic->htmlInput("idvh","hidden",$idVirtualhost);
		$footer=$table->getFooter()->setFullWidth();
		$footer->mergeCol(0,1);
		
		$bt=HtmlButton::labeled("submit","Valider","settings");
		$bt->setFloated("right")->setColor('blue');
		$bt->postFormOnClick("VirtualHosts/updateConfig", "frmConfig","#info");
		
		$footer->getCell(0,1)->setValue([$bt]);
		$table->addVariation("compact")->setDefinition()->setCelled();	

		$this->jquery->execOn("onClick", "#value", '$("#data-input").prop("checked", true);');
		$this->jquery->change("#value",'$("#check0").prop("checked", true);');
		
		$this->jquery->compile($this->view);
	}
	public function updateConfigAction(){
		$this->jquery->exec("$('#info').show();",true);

		echo "Mise à jour des propriétés effectuées !";

		$i = 0;	
		$idVH=$_POST["idvh"];
		foreach($_POST["id"] as $property){	
			$property=Virtualhostproperty::findFirst("idVirtualhost=$idVH AND idProperty=$property");
			$property->setValue($_POST["value"][$i]);
			$property->save();
			$i=$i+1;			
		}
		echo $this->jquery->compile();
	}
}