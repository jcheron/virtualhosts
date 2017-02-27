<?php
use Ajax\semantic\html\base\constants\Direction;
use Ajax\semantic\html\elements\HtmlButton;


class ServerExchangeController extends \ControllerBase {
	const ICONS=["success"=>"checkmark box","info"=>"info circle","warning"=>"warning circle","error"=>"announcement"];

	public function indexAction(){
		$this->loadMenus();
		$mess=$this->semantic->htmlMessage("infoFrm","<p>Ce module permet de tester les échanges entre le(s) server(s) distant(s) et l'application virtualhosts, pour transférer des fichiers, recharger apache ou NginX...</p>");
		$mess->addHeader("Interface de test Client/serveur");
		$bt=(new HtmlButton("bt-download", "Télécharger"))->asLink("https://github.com/jcheron/vhServer/releases/download/1.0/vhServer.jar");
		$bt->addIcon("download");
		$bt->addLabel("vhServer v1.0")->asLink("https://github.com/jcheron/vhServer/releases/download/1.0/vhServer.jar")->setPointing("left");

		$mess->addList(array($bt,"Copier le serveur java sur le(s) serveur(s) distant(s) ","Démarrer le serveur par la commande : <b>java -jar vhServer.jar 9001</b>","Exécuter des commandes via le module : ping, sendfile..."),false);
		$mess->setIcon("info circle");

		$frm=$this->semantic->htmlForm("frmPing");
		$fields=$frm->addFields();
		$fields->addInput("server","Serveur","text","127.0.0.1","Serveur")->setWidth(14);
		$fields->addInput("port","Port","number","9001","Port")->setWidth(2);
		$fields->addFieldRule(1, "integer");
		$input=$frm->addInput("message","Action","text","public/robots.txt","Message à envoyer...");
		$input->getDataField()->addProperties(["data-run"=>"c:\windows\system32\calc.exe","data-sendfile"=>"public/robots.txt","data-message"=>"","data-ping"=>""]);
		$input->getField()->addDropdown("sendfile",["run"=>"run","ping"=>"ping","sendFile"=>"sendFile","message"=>"message","stop"=>"stop","restart"=>"restart"],Direction::LEFT);
		$frm->addInput("params","Paramètres","text","","Paramètres séparés par une virgule");
		$this->jquery->execOn("change", "#select-div-message", "var self=this;$('['+'data-'+$(self).val()+']').each(function(){ if($(this).is('[value]')) $(this).val($(this).attr('data-'+$(self).val())); else $(this).html($(this).attr('data-'+$(self).val()));});");
		$bt=$frm->addButton("btPing", "Envoyer données vers le serveur")->asSubmit();
		$bt->addLabel("Connecté ?",false,"plug")->setPointing("left");
		$bt->getContent()[0]->addProperties(["data-run"=>"Exécuter sur le serveur","data-sendfile"=>"Envoyer le fichier vers le serveur","data-message"=>"?","data-ping"=>"Envoyer un ping"]);
		$frm->submitOnClick("btPing", "ServerExchange/send", "#pingResponse");
		$this->jquery->postFormOn("change", "#server, #port", "ServerExchange/ping","frmPing","#label-btPing");
		if($this->request->isAjax()){
			$this->view->setVar("ajax", true);
		}
		$this->jquery->compile($this->view);
	}

	public function sendAction(){
			$address=$_POST["server"];$port=$_POST["port"];
			$action=$_POST["select-div-message"];
			$params=explode(",", $_POST["params"]);
			$content=$_POST["message"];
			$responses=$this->send($address, $port, $action, $content, $params);
			$this->displayMessages($responses);
			$this->updatePingDiv($responses);
			echo $this->jquery->compile();
	}

	public function pingAction(){
		$address=$_POST["server"];$port=$_POST["port"];
		$action="ping";
		$params=[];
		$content="";
		$responses=$this->send($address, $port, $action, $content, $params);
		$this->updatePingDiv($responses);
		echo $this->jquery->compile();
	}

	private function updatePingDiv($responses){
		$txt= "<i id='icon-label-btPing' class='icon warning'></i>Non connecté";
		if($this->hasError($responses)){
			$this->jquery->doJQuery("#label-btPing", "removeClass","teal");
			$this->jquery->doJQuery("#label-btPing", "addClass","red");
		}else {
			$txt="<i id='icon-label-btPing' class='icon plug'></i>Connecté";
			$this->jquery->doJQuery("#label-btPing", "removeClass","red");
			$this->jquery->doJQuery("#label-btPing", "addClass","teal");
		}
		$this->jquery->doJQuery("#label-btPing", "html",$txt);
	}

	private function send($address,$port,$action,$content,$params){
		set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
			if (0 === error_reporting()) {
				return false;
			}
			throw new ErrorException($errstr, $errno, $errno, $errfile, $errline);
		});
			$serverResponses=[];
			$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			$msg=$this->createTCPMessage($action,$content,$params);
			try{
				$result = socket_connect($sock, $address, $port);
				if ($result !== false) {
					$this->sendMessage($sock, $msg);
					$buf = '';
					if(false!==($buf= socket_read($sock, 2048))){
						if(mb_detect_encoding($buf, 'UTF-8', true)===false)
							$buf=utf8_encode($buf);
						$serverResponses=explode("|", $buf);
					}
					socket_close($sock);
					$serverResponses[]='{"type":"info","content":"Lecture de '.strlen($buf).' bytes provenant du serveur.\nFermeture de la connexion..."}';
				}
			}catch(ErrorException $e){
				$serverResponses[]='{"type":"error","content":"Communication impossible avec le serveur.\nAssurez vous que <b>vhServer</b> est lancé sur '.$address.' et écoute sur le port '.$port.'"}';
			}
			return $serverResponses;
	}

	private function displayMessages($messages){
		foreach ($messages as $message){
			$obj=json_decode($message);
			if($obj!==null){
				$this->showMessage($obj->content, $obj->type);
			}
		}
	}

	private function hasError($messages){
		$result=false;
		foreach ($messages as $message){
			$obj=json_decode($message);
			if($obj!==null){
				if($obj->type==="error")
					$result=true;
			}
		}
		return $result;
	}

	private function showMessage($content,$style){
		$msg=$this->semantic->htmlMessage("",nl2br($content));
		$msg->setStyle($style);
		$msg->setIcon(self::ICONS[$style]);
		echo $msg;
	}

	private function createTCPMessage(){
		$action=$_POST["select-div-message"];
		$params=explode(",", $_POST["params"]);
		if($action==="sendfile"){
			$filename='http://'.$_SERVER['SERVER_NAME'].$this->url->get($_POST["message"]);

			$fileContent=file_get_contents($filename);
			$msg ='{"action":"'.$action.'", "content":'.json_encode($fileContent).',"params":'.json_encode($params).'}';
		}else{
			$msg ='{"action":"'.$action.'", "content":'.json_encode($_POST["message"]).',"params":'.json_encode($params).'}';
		}
		return $msg."\n";
	}

	private function sendMessage($socket,$msg){
		$length = strlen($msg);
		while (true) {
			$sent = socket_write($socket, $msg, $length);
			if ($sent === false) {
				break;
			}
			if ($sent < $length) {
				$msg = substr($msg, $sent);
				$length -= $sent;
			} else {
				break;
			}
		}
	}

}