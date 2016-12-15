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
		//$vhp=Virtualhostproperty::findFirst();
		$list=$this->semantic->htmlList("lst-virtualhosts");
		
		foreach ($virtualhosts as $virtualhost){
			$item=$list->addItem(["icon"=>"cloud","header"=>$virtualhost->getName(),"description"=>$virtualhost->getServer()->getName()]);
			$props=$virtualhost->getVirtualhostproperties();
			$item->addPopup("Propriétés :","ServeurName: ".$props[0]->getValue());
			$item->addToProperty("data-ajax", $virtualhost->getId());
			$item->getOnClick("Listhostvirtual/AfficherVh","#modification",["attr"=>"data-ajax"]);
			
			
		}
		$list->setHorizontal();
		$this->jquery->compile($this->view);
	}
	public function AfficherVhAction($idVh){
		$semantic=$this->semantic;

		$virtualhost=Virtualhost::findFirst($idVh);
		$vhp=$virtualhost->getVirtualhostproperties();
		$table=$semantic->htmlTable('infos',0,5);
		$table->setHeaderValues(["VirtualHost","Nom","Description","Value"]);
		$i=0;

			$vh=$virtualhost->getName();
			foreach ($vhp as $virtualHostProperty){
				$property=$virtualHostProperty->getProperty();
				$value=$virtualHostProperty->getValue();
					
				$table->addRow([$vh,
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
