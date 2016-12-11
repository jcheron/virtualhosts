<?php
use Phalcon\Mvc\View;
use Ajax\semantic\html\collections\form\HtmlFormTextarea;
class ServeurVirtualHostController extends ControllerBase{

	public function indexAction(){
	$this->secondaryMenu($this->controller,$this->action);
	$this->tools($this->controller,$this->action);
	
	$this->jquery->compile($this->view);
	}
	

	public function virtualAction($idHost=NULL){
	
		$virtualhosts=Virtualhost::find();
		$list=$this->semantic->htmlList("virtual");
	
	
		$semantic=$this->semantic;
	
		$table=$semantic->htmlTable('table4',0,6);
		$table->setHeaderValues([" ","Nom du Virtualhosts","Configuration","Serveur","Modifier","Supprimer"]);
		$i=0;
	echo "<h3> Liste des virtualhosts : </h3>";
		foreach ($virtualhosts as $virtualhost){
			$btnConfig = $semantic->htmlButton("btnConfig-".$i,"Configurer","small green basic")->asIcon("edit")->getOnClick("ServeurVirtualHost/hosts","#test");
				
				
			$btnDelete = $semantic->htmlButton("btnDelete-".$i,"Supprimer","small red")->asIcon("remove")->getOnClick("Serveur/vDelete/".$virtualhost->getId(),"#test");
			$table->addRow([" ",$virtualhost->getName(),
					$virtualhost->getConfig(),$virtualhost->getIdServer(),$btnConfig,$btnDelete]);
				
			$table->setDefinition();
			$i++;
				
		}
		
	
		echo $table;
		echo "<br/> <br/>";
	
		$test=$semantic->htmlButton("ajouter","Ajouter","black")->getOnClick("Serveur/vUpdate","#divAction")->setNegative();
		echo $test;
		$this->jquery->exec("$('#divAction .item').removeClass('active');",true);
		$this->jquery->exec("$('[data-ajax=".$idHost."]').addClass('active');",true);
		$list->setInverted()->setDivided()->setRelaxed();
		echo $this->jquery->compile($this->view);
	}
	
	
	
}