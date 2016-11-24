<?php

use Phalcon\Mvc\View;
use Ajax\semantic\html\elements\HtmlButton;
class IndexController extends ControllerBase{

    public function indexAction(){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);

    	$semantic=$this->semantic;

    	$button=$semantic->htmlButton("btAfficher","Afficher message")->setColor("red");
    	$message=$semantic->htmlMessage("message1","<b>Cliquer</b> sur le bouton...");
    	$button->onClick($message->jsHtml("Click sur bouton"));
    	$this->jquery->compile($this->view);
    }

    public function hostsAction(){
    	$this->tools($this->controller,$this->action);
    	$this->jquery->get("Index/secondaryMenu/{$this->controller}/{$this->action}","#secondary-container");
		$this->jquery->compile($this->view);
    }

    public function virtualhostsAction(){
    	$this->tools($this->controller,$this->action);
    	$this->jquery->get("Index/secondaryMenu/{$this->controller}/{$this->action}","#secondary-container");
    	$this->jquery->compile($this->view);
    }

    public function newVirtualhostAction(){

    }


}

