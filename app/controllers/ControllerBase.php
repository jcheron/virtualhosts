<?php

use Phalcon\Mvc\Controller;
use Ajax\semantic\html\elements\HtmlButton;
use Ajax\semantic\html\base\HtmlSemDoubleElement;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller{
	protected $controller;
	protected $action;

	/**
	 * @property \Ajax\Semantic;
	 */
	protected $semantic;
	public function beforeExecuteRoute(Dispatcher $dispatcher){
		if($this->request->isAjax()){
			$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
		}
		$this->action=$dispatcher->getActionName();
		$this->controller=$dispatcher->getControllerName();
		$this->semantic=$this->jquery->semantic();
	}

	protected function tools($controller,$action){
		$url=Url::findFirst("controller='{$controller}' AND action='{$action}'");
		$semantic=$this->semantic;
		$menu=$semantic->htmlButtonGroups("tools");
		if($url){
			if($url->getTools()!==NULL){
				$urls=Url::find([ 'conditions'=>'id IN ('.$url->getTools().')' ]);

				$menu->fromDatabaseObjects($urls, function($url){
					$libelle=$url->getTitle();
					$item=new HtmlButton("tool-".$url->getId());
					$item->setTagName("a");
					$item->setContent($libelle);
					$icon=$url->getIcon();
					if(isset($icon)){
						$item->addIcon($icon);
					}
					$path=$url->getController()."/".$url->getAction();
					$item->setProperty("href",$this->url->get($path));
					$item->getOnClick($path,"#content-container");
					return $item;
				});
			}
		}
		return $menu;
	}

	protected function secondaryMenu($controller,$action){
		$url=Url::findFirst("controller='{$controller}' AND action='{$action}'");
		$semantic=$this->semantic;
		$menu=$semantic->htmlMenu("secondary");
		$menu->setSecondary()->setPointing();
		if($url){
			if($url->getChildren()!==NULL){
				$urls=Url::find([ 'conditions'=>'id IN ('.$url->getChildren().')' ]);
				$menu->fromDatabaseObjects($urls, function($url) use ($controller,$action){
					$libelle=$url->getTitle();
					$item=new HtmlSemDoubleElement("menu-".$url->getId(),"a","item");
					$item->setContent($libelle);
					if($controller==$url->getController() && $action==$url->getAction())
						$item->addToProperty("class", "active");
						$path=$url->getController()."/".$url->getAction();
						$item->setProperty("href",$this->url->get($path));
						if($libelle!=="Accueil")
							$item->getOnClick($path,"#main-container");
							return $item;
				});
			}
		}
		return $menu;
	}

	public function secondaryMenuAction($controller,$action){
		$menu=$this->secondaryMenu($controller, $action);
		$this->view->disable();
		if(isset($menu)){
			echo $menu->compile($this->jquery);
		}
		echo $this->jquery->compile($this->view);
	}
}
