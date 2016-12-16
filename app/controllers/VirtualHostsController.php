<?php
use Ajax\semantic\html\modules\checkbox\HtmlCheckbox;
use Ajax\semantic\html\elements\HtmlButton;
use Ajax\semantic\html\elements\HtmlInput;
use Ajax\Semantic;
use Ajax\semantic\html\elements\HtmlIcon;
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
		
		
		$check=new HtmlIcon("","large green checkmark");
		
		if ($server->getName() != NULL && $host->getName() != NULL && $host->getIPv4() != NULL || $IPv6 != NULL){
			$check="Config. 0K "; 
			$check.=new HtmlIcon("", "large green checkmark");
		}else{
			$check="Err. config ";
			$check.=new HtmlIcon("", "large red bug");
		}
		
		$title=$semantic->htmlHeader("header1",2);
		$title->asTitle("Informations générales","Permet de vérifier l'état actuel de machine");
		$this->view->setVar("title1", $title);
		

		$title2=$semantic->htmlHeader("header2",2);
		$title2->asTitle("Fichier de configuration","Fichier Apache actuellement utilisé sur l'hôte virtuel");
		//$semantic->htmlIcon("editIcon","edit")->getOnClick("VirtualHosts/editApache","#modification2");
		
		$semantic->htmlIcon("editIcon", "edit")->onClick("$('.settings').trigger('click')")->onClick("$('#modifier').trigger('click')");
		//->onClick("$('#modifier').trigger('click')");
		$this->view->setVar("title2", $title2);
		
		$table=$semantic->htmlTable('infos',5,3);
		$table->setHeaderValues(["","Valeur","Description"]);
		$table->setValues([["Etat global : ",$check,"<i>Vérifie si la machine dispose d'une configuration suffisante</i>"],
				["Serveur",$server->getName(),"<i>Nom du serveur sur lequel est hebergé la machine</i>"],
				["Machine",$host->getName(),"<i>Nom de l'hôte hebergeant l'hôte virtuel</i>"],
				["Adresse IPv4",$host->getIpv4(),"<i>Adresse IPv4 affectée à l'hôte virtuel</i>"],
				["Adresse IPv4",$IPv6,"<i>Adresse IPv6 affectée à l'hôte virtuel</i>"],
				
		]);
		$table->setDefinition();
		
		/*$table=$this->semantic->htmlTable("infos",2,4);
		$table->setHeaderValues(["Machine","Serveur","Adresse IPv4","Adresse IPv6"]);
		$table->setValues([$host->getName(),$server->getName(),$host->getIpv4(),$IPv6]);
			*/
		$semantic->htmlButton("modifier","Modifier")->getOnClick("VirtualHosts/editApache","#modification")->setPositive();
		
		$buttons=$this->semantic->htmlButtonGroups("importOrExport",array("Importer","Exporter"));
		$buttons->insertOr(0,"ou");		
		$buttons->getElement(0)->getOnClick("VirtualHosts/readConfig","#uploadExport");
		$buttons->getElement(2)->getOnClick("VirtualHosts/exportConfig","#uploadExport");
		
		
		$this->jquery->exec("Prism.highlightAll();",true);
		$this->jquery->compile($this->view);
	}
	
	public function editApacheAction($idVirtualhost=NULL){
		$idVirtualhost=2;
		$semantic=$this->semantic;
		
		$virtualHostProperties=Virtualhostproperty::find("idVirtualhost={$idVirtualhost}");
		
		$table=$semantic->htmlTable("s-infos",0,6);
		$table->setHeaderValues(["","Priorité","Nom","Description","Valeur actuelle","Nouvelle valeur"]);
		foreach ($virtualHostProperties as $virtualHostProperty){
			$property=$virtualHostProperty->getProperty();
			$priority=$property->getPrority();
		
			$value=$virtualHostProperty->getValue();
			$input=new HtmlInput("value[]","text",$value,"Nouvelle valeur");
			$input->setProperty("data-changed", "label$i");
			$table->addRow([$semantic->htmlLabel("label$i","État"),
					$priority,
					$property->getName(), $property->getDescription(),
					$value,($input)
					.(new HtmlInput("id[]","hidden",$property->getId())),
					
			]);
				
			$i=$i+1;
		}
	
		$footer=$table->getFooter()->setFullWidth();
		$footer->mergeCol(0,1);
		$bt=HtmlButton::labeled("submit","Valider","settings");
		$bt->setFloated("right")->setColor('blue');
		$bt->postFormOnClick("VirtualHosts/updateConfig", "frmConfig","#info");
		$footer->getCell(0,1)->setValue([$bt]);
		$semantic->htmlInput("idvh","hidden",$idVirtualhost);
		
		$table->setSortable(1);
		

		$this->jquery->change("[data-changed]","$('#'+$(this).attr('data-changed')).html('Modifié');");
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
	
	public function readConfigAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$target_dir = APP_PATH."/uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
				$this->view->setVar("state", $uploadOk);
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
				$this->view->setVar("state", $uploadOk);
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
			$this->view->setVar("state", $uploadOk);
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
			$this->view->setVar("state", $uploadOk);
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
					echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					$uploadOk = 0;
					$this->view->setVar("state", $uploadOk);
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "Sorry, your file was not uploaded.";
					$this->view->setVar("state", $uploadOk);
					// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
						echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
						$this->view->setVar("state", "1");
					} else {
						echo "Sorry, there was an error uploading your file.";
						$this->view->setVar("state", "0");
					}
				}
		$this->jquery->compile($this->view);
	}
		
	public function exportConfigAction(){
		$semantic=$this->semantic;		
		$this->jquery->compile($this->view);
	}
}