<?php

use Ajax\semantic\widgets\datatable\PositionInTable;
use Ajax\service\JArray;
use Ajax\semantic\html\elements\HtmlLabel;
use Ajax\semantic\html\collections\form\HtmlForm;
use Ajax\semantic\html\elements\HtmlList;

class STypeController extends ControllerBase{

	public function initialize(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
	}

	public function indexAction($hasHeader=""){
		$semantic=$this->jquery->semantic();

		if($hasHeader==="btStypes"){
			$header=$semantic->htmlHeader("header",3);
			$header->asTitle("Types de serveur","Sélectionner un type pour visualiser ses propriétés");
			$header->addIcon("server");
			$btAdd=$semantic->htmlButton("btAddStype","Ajouter un type de serveur");
			$btAdd->getOnClick("SType/add","#dtStypes-edit",["ajaxTransition"=>"random"]);

		}
		$sTypes=Stype::find();
		$dtStypes=$semantic->dataTable("dtStypes", "Stype",$sTypes);
		$dtStypes->setIdentifierFunction("getId");
		$dtStypes->setFields(["name","configTemplate"]);
		$dtStypes->setCaptions(["Nom","Template"]);
		$dtStypes->addEditDeleteButtons(false,["ajaxTransition"=>"random"]);
		$dtStypes->setUrls(["SType/search","SType/edit","SType/delete"]);
		$dtStypes->setTargetSelector("#dtStypes-edit");
		$dtStypes->setActiveRowSelector("error");
		$dtStypes->getOnRow("click","SType/stypeDetail","#dtStypes-edit",["attr"=>"data-ajax","preventDefault"=>false,"stopPropagation"=>false,"ajaxTransition"=>"fade right"]);

		$this->jquery->compile($this->view);
	}

	public function editAction($id){
		$this->session->set("idStype", $id);
		$semantic=$this->jquery->semantic();
		$sType=Stype::findFirst($id);
		$formStype=$semantic->dataForm("formStype", $sType);
		$formStype->setFields(["name","id","name","configTemplate"]);
		$formStype->setCaptions(["Modification","","Nom","Template"]);
		$formStype->fieldAsMessage(0,["icon"=>"edit"]);
		$formStype->fieldAsInput("id",["inputType"=>"hidden"]);
		$formStype->fieldAsTextarea("configTemplate");
		$formStype->addSubmitInToolbar("submitStype", "Valider les modifications","green","SType/update","#edit-z1");
		$formStype->wrap("<div id='edit-z1'>","</div>");

		$lvProperties=$semantic->jsonDataTable("lvProperties", "Stypeproperty", Stypeproperty::find("idStype={$id}"));
		$lvProperties->setIdentifierFunction(function($index,$instance){return $instance->getIdStype()."_".$instance->getIdProperty();});
		$lvProperties->setValidationParams(["inline"=>true]);

		$lvProperties->setRowClass("_no-refresh");
		$lvProperties->setFields(["idStype","idProperty","property","name","template"]);
		$lvProperties->fieldsAs(["hidden","hidden","label","input","input"]);
		$lvProperties->setCaptions(["","","Property","Name","Template","Actions"]);
		$lvProperties->hideColumn(0);
		$lvProperties->hideColumn(1);
		$lvProperties->setEdition();
		$lvProperties->addDeleteButton(false,["ajaxTransition"=>"random","responseElement"=>"#info"]);
		$lvProperties->setUrls(["delete"=>"SType/deleteStypeProperty"]);
		$lvProperties->setRowModelCallback(function($object){$object->property="__property__";});
		$lvProperties->setSubmitParams("SType/updateProperties","#edit-z2");
		$lvProperties->wrap("<div id='edit-z2'>","</div>");


		$frmNewProperty=$semantic->dataForm("frmNewProperty", new Property());
		$frmNewProperty->setFields(["Propriété","id","name","description","prority","required","submit"]);
		$frmNewProperty->setCaptions(["Ajout d'une nouvelle propriété au serveur ".$sType->getName(),"","Nom","Description","Priorité","Requis ?","Ajouter la propriété"]);
		$frmNewProperty->fieldsAs(["message","hidden","input","textarea"=>[["rows"=>2]],"input"=>[["inputType"=>"number"]],"checkbox","submit"=>["green","SType/newProperty","#dd"]]);

		$bt=$semantic->htmlButtonGroups("dd",["Ajouter une propriété..."]);
		$bt->onClick("$('#modal-frmNewProperty').modal('show');");
		$bt->addDropdown(JArray::modelArray($this->getNewProperties($id),"getId","getName"));
		$lvProperties->jsonArrayOnClick($bt->getDropdown(),"SType/addNewStypeProperty","post","{idStype:$('#formStype-id-0').val(),idProperty:$(this).attr('data-value')}","self.remove();",["rowClass"=>"_no-refresh"]);
		$formStype->addInToolbar($bt);
		$formStype->setToolbarPosition(PositionInTable::AFTERTABLE);

		echo $formStype;
		echo "<div id='info'></div>";
		echo $lvProperties;
		echo $frmNewProperty->asModal();
		echo $this->jquery->compile($this->view);
	}

	protected function getNewProperties($idSType){
		$condition="";
		$usedProperties = $this->modelsManager->executeQuery(
				"SELECT DISTINCT idProperty FROM Stypeproperty WHERE idStype=".$idSType
				);
		$usedProperties=$usedProperties->toArray();
		if(sizeof($usedProperties)>0){
			$usedProperties=array_map(function($elm){return $elm["idProperty"];}, $usedProperties);
			$condition='id NOT IN ('.implode(',',$usedProperties).')';
		}
		$properties=Property::find(['conditions'=>$condition ]);
		return $properties;
	}

	public function addNewStypePropertyAction(){
		extract($_POST);
		$stypeProperty=new Stypeproperty();
		$stypeProperty->setIdProperty($idProperty);
		$stypeProperty->setIdStype($idStype);
		$stypeProperty->create(["name"=>"new name","template"=>"{{}}"]);
		$property=Property::findFirst(["id={$idProperty}"]);
		$this->view->disable();
		$jsonData=$stypeProperty->toArray();
		$jsonData["property"]=$property->getName();
		$jsonData=[$jsonData];
		print_r(json_encode($jsonData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
	}

	public function newPropertyAction(){
		$semantic=$this->jquery->semantic();
		$this->view->disable();
		$idStype=$this->session->get("idStype");
		if(sizeof($_POST)>0){
			$property=new Property();
			$property->create($_POST,["name","description","prority","required"]);
			$lbl=new HtmlLabel("lbl-dd","`".$_POST["name"]."` ajoutée");
			$lbl->setColor("green");
			$lbl->setTimeout(5000);
		}
		$bt=$semantic->htmlButtonGroups("dd",["Ajouter une propriété..."]);
		if(isset($lbl))
			$bt->getItem(0)->addContent($lbl);
		$bt->onClick("$('#modal-frmNewProperty').modal('show');");
		$bt->addDropdown(JArray::modelArray($this->getNewProperties($idStype),"getId","getName"));
		$this->jquery->jsonArrayOn("click", "#dd-dd .item","#lvProperties tr._jsonArrayModel","SType/addNewStypeProperty",["jsCallback"=>"self.remove();","method"=>"post","params"=>"{idStype:$('#formStype-id-0').val(),idProperty:$(this).attr('data-value')}","rowClass"=>"_no-refresh"]);
		echo $bt;
		echo $this->jquery->compile($this->view);
	}

	public function deleteAction($idStype,$force=false){
		$sType=Stype::findFirst($idStype);
		$servers=$sType->getServers();
		$count=sizeof($servers);
		if($force==="force" ||$count==0){
			$this->executeOp(function() use($sType){$sType->delete();}, "Le type de serveur `{$sType->getName()}` a été supprimé.", "Impossible de supprimer le type de serveur `{$sType->getName()}`.");
		}else{
			echo $this->showConfDialog("Entrez le nom du type de serveur pour confirmer sa suppression.<br>{$sType->getName()} est utilisé sur {$count} serveur(s).", $sType->getName(), "warning","SType/delete/{$idStype}/force","#dtStypes-edit");
		}
		echo $this->jquery->compile($this->view);
	}

	private function executeOp($op,$success,$error,$jsCallback=null,$refresh=true){
		$errorMessage="";
		try{
			$op();
		}catch(Exception $e){
			$errorMessage=$error."<br>".$e->getMessage();
		}
		if($errorMessage===""){
			if($refresh){
				$this->jquery->get("SType/index","#dtStypes",null,$jsCallback,false,"replaceWith");
			}elseif(isset($jsCallback)){
				$this->jquery->exec($jsCallback,true);
			}
			echo $this->showSimpleMessage($success, "success");
		}else{
			echo $this->showSimpleMessage($errorMessage, "error");
		}
	}

	private function showSimpleMessage($content,$type,$icon="info"){
		$semantic=$this->jquery->semantic();
		$message=$semantic->htmlMessage("msg-".rand(0,50),$content,$type);
		$message->setIcon($icon);
		$message->setDismissable();
		$message->setTimeout(3000);
		return $message;
	}

	private function showConfDialog($content,$conf,$type,$url,$responseElement,$attributes=NULL){
		$semantic=$this->jquery->semantic();
		$frm=$semantic->htmlForm("frm-conf");
		$frm->setValidationParams(["inline"=>true]);
		$frm->addMessage("message", $content,"Suppression","delete",$type);
		$frm->addInput("model","Valeur :","text",$conf)->setDisabled();
		$frm->addInput("confirmation","Confirmation","text","","Entrez la confirmation du nom")->addRule("match[model]","La valeur saisie ne correspond pas au modèle donné :<b>{$conf}</b>.");
		$frm->setState("warning");
		$frm->addSubmit("submit-conf", "Confirmer la suppression",$type,$url,$responseElement,$attributes);
		return $frm;
	}

	public function updateAction(){
		$this->view->disable();
		if(isset($_POST["id"])){
			$this->executeOp(function(){
				$sType=Stype::findFirst($_POST["id"]);
				$sType->save($_POST,["name","configTemplate"]);
			}, "Le type de serveur a été sauvegardé.", "Impossible d'ajouter le type de serveur.","$('#frm-lvProperties').form('submit');");
		}
		echo $this->jquery->compile($this->view);
	}

	public function updatePropertiesAction(){
		$this->view->disable();
		if(sizeof($_POST)>0){
			$out = array();
			foreach($_POST as $field => $values){
				foreach($values as $index => $val){
					$out[$index][$field] = $val;
				}
			}
			$this->executeOp(function() use($out){
				$size=sizeof($out);
				for($i=1;$i<$size;$i++){
					$stypeProperty=Stypeproperty::findFirst("idStype={$out[$i]["idStype"]} AND idProperty={$out[$i]["idProperty"]}");
					$stypeProperty->save($out[$i],["name","template"]);
				}
			}, (sizeof($out)-1)." propriété(s) sauvegardée(s).", "Impossible de sauvegarder les propriétés du serveur.");
		}
		echo $this->jquery->compile($this->view);
	}

	public function addAction(){
		$sType=new Stype();
		$sType->create();
		$this->dispatcher->forward(["controller"=>"SType","action"=>"edit","params"=>[$sType->getId()]]);
	}

	public function deleteStypePropertyAction($idStypeProperty,$force="force"){
		$idStypeProperties=explode("_", $idStypeProperty);
		$sTypeProperty=Stypeproperty::findFirst("idStype={$idStypeProperties[0]} AND idProperty={$idStypeProperties[1]}");
		if($force==="force" && $sTypeProperty!==false){
			$this->executeOp(function() use($sTypeProperty){
				$sTypeProperty->delete();
				$this->jquery->get("SType/newProperty","#dd");
			}, "La propriété `{$sTypeProperty->getName()}` a été supprimée.",
			"Impossible de supprimer la propriété `{$sTypeProperty->getName()}`.","$('tr[data-ajax={$idStypeProperty}]').remove();",false);
		}else{
			echo $this->showConfDialog("Entrez le nom de la propriété pour confirmer sa suppression.<br>{$sTypeProperty->getName()} est ....", $sTypeProperty->getName(), "warning","SType/delete/".$sTypeProperty->getIdStype()."_".$sTypeProperty->getIdProperty()."/force","#edit-z2");
		}
		echo $this->jquery->compile($this->view);
	}

	public function stypeDetailAction($id){
		$sType=Stype::findFirst($id);
		$this->view->disable();
		$semantic=$this->jquery->semantic();
		$de=$semantic->dataElement("stypeDetail", $sType);
		$de->setFields(["name","configTemplate","properties"]);
		$de->setCaptions(["Name","ConfigTemplate","Properties"]);
		$de->setValueFunction("properties", function($name,$instance){
			$list=new HtmlList("lst");
			$list->setDivided()->setRelaxed();
			$list->addItems(JArray::modelArray($instance->getStypeproperties(),null,"getName"));
			$list->setIcons("hashtag");
			return $list;
		});
		$de->setColWidths([4,12]);
		echo $de;
	}
}
