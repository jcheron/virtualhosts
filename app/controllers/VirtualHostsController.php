<?php
use Ajax\semantic\html\modules\checkbox\HtmlCheckbox;
use Ajax\semantic\html\elements\HtmlButton;
use Ajax\semantic\html\elements\HtmlInput;
use Ajax\Semantic;
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
		
		$this->jquery->change("#value",'$(this).data("data-input").prop("checked", true);');		
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
	
	public function uploadAction(){
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
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
	}
	
	public function exportConfigAction(){
		$semantic=$this->semantic;		
		$this->jquery->compile($this->view);
	}
}