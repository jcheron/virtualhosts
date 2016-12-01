<?php

class ManageUsersController extends ControllerBase
{

    public function indexAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
		echo "test";
		
		$this->jquery->compile($this->view);
    }

}

