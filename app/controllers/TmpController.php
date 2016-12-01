<?php

class TmpController extends ControllerBase{

	
	
	public function indexAction(){
		$this->loadMenus();
		$semantic=$this->semantic;
		$grid=$semantic->htmlGrid("grid1");
		$grid->setColsCount(16);
		echo $grid;
		
		$this->jquery->compile($this->view);
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
}

