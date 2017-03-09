<?php
class ConfGenerator {
	/**
	 * @var Virtualhost
	 */
	protected $virtualHost;
	/**
	 * @var Stype
	 */
	protected $sType;
	
	public function __construct($virtualhost){
		$this->virtualHost=$virtualhost;
	}
	
	public function run(){
		$configTemplate=$this->getConfigTemplate();
		$vhProperties=$this->virtualHost->getVirtualhostproperties();
		$properties=[];
		foreach ($vhProperties as $vhProperty){
			if($vhProperty->getActive()){
				$property=$vhProperty->getProperty();
				$attributes=["name"=>$property->getName(),"value"=>$vhProperty->getValue()];
				$properties[$property->getPrority()]=$this->parse($this->getTemplateProperty($property),$attributes);
			}
		}
		ksort($properties);
		$properties=implode("\n", $properties);
		$result=$this->parse($configTemplate, ["properties"=>$properties,"name"=>$this->virtualHost->getName()]);
		return $result;

	}
	
	protected function parse($template,$attributes){
		$result=$template;
		foreach ($attributes as $key=>$value){
			$result=str_ireplace("{{".$key."}}", $value, $result);
		}
		return $result;
	}
	
	protected function getTemplateProperty(Property $property){
		$stypeProperties=$property->getStypeproperties();
		foreach ($stypeProperties as $stypeProperty){
			if($stypeProperty->getStype()->getId()===$this->sType->getId())
				return $stypeProperty->getTemplate();
		}
		return "";
	}
	
	protected function getConfigTemplate(){
		$configTemplate="";
		$server=$this->virtualHost->getServer();
		if(isset($server)){
			$sType=$server->getStype();
			if(isset($sType)){
				$configTemplate=$sType->getConfigTemplate();
				$this->sType=$sType;
			}
		}
		return $configTemplate;
	}

}