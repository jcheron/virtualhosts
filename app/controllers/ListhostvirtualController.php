<?php
use Phalcon\Mvc\View;
use Ajax\semantic\html\modules\checkbox\HtmlCheckbox;
use Ajax\semantic\html\elements\HtmlInput;
class ListhostvirtualController extends ControllerBase {
	
	public function listhvAction($user=NULL){
		$this->loadMenus();
		$hosts=Host::find();
		
		//$item->addPopup("Propriétés","test popup");
		$list=$this->semantic->htmlList("lst-hosts");
		foreach ($hosts as $host){
			$item=$list->addItem(["icon"=>"cloud","header"=>$host->getName(),"description"=>$host->getIpv4()]);
			//$item->addPopup("Propriétés","test popup");
			$item->addToProperty("data-ajax", $host->getId());
		}
		$list->setHorizontal();
		
		$virtualhosts=Virtualhost::find();
		$vhp=Virtualhostproperty::findFirst();
		$list=$this->semantic->htmlList("lst-virtualhosts");
		
		foreach ($virtualhosts as $virtualhost){
			$item=$list->addItem(["icon"=>"cloud","header"=>$virtualhost->getName(),"description"=>$virtualhost->getServer()->getName()]);
			$item->addPopup("Propriétés :","ServeurName: ".$vhp->getValue());
			$item->addToProperty("data-ajax", $virtualhost->getId());
			$item->getOnClick("Listhostvirtual/AfficherVh","#modification");
			
			
		}
		$list->setHorizontal();
		$this->jquery->compile($this->view);
	}
	public function AfficherVhAction(){
		$semantic=$this->semantic;

		$idVirtualhost=2;
		$virtualhosts=Virtualhost::findFirst("id=2");
		$vhp=Virtualhostproperty::find("idVirtualhost={$idVirtualhost}");
		$table=$semantic->htmlTable('infos',0,5);
		$table->setHeaderValues(["Host","Nom","Description","Value"]);
		$i=0;
		
		foreach ($vhp as $virtualHostProperty){
			$property=$virtualHostProperty->getProperty();
			$value=$virtualHostProperty->getValue();
			
			$table->addRow([$virtualhosts->getName(),
					$property->getName(), $property->getDescription(),
					$value
					
						
			]);
			$i=$i+1;
				
				
		}
		
		$semantic->htmlInput("idvh","hidden",$idVirtualhost);
		$footer=$table->getFooter()->setFullWidth();
		$footer->mergeCol(0,1);
		$this->jquery->compile($this->view);
	}
}
