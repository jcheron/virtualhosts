<?php

class Url extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $id;

    /**
     *
     * @var string
     * @Column(type="string", length=30, nullable=true)
     */
    protected $icon;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=true)
     */
    protected $title;

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=true)
     */
    protected $controller;

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=true)
     */
    protected $action;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $subMenu;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $children;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $tools;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $roles;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field icon
     *
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Method to set the value of field title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Method to set the value of field controller
     *
     * @param string $controller
     * @return $this
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Method to set the value of field action
     *
     * @param string $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Method to set the value of field subMenu
     *
     * @param integer $subMenu
     * @return $this
     */
    public function setSubMenu($subMenu)
    {
        $this->subMenu = $subMenu;

        return $this;
    }

    /**
     * Method to set the value of field children
     *
     * @param string $children
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Method to set the value of field tools
     *
     * @param string $tools
     * @return $this
     */
    public function setTools($tools)
    {
        $this->tools = $tools;

        return $this;
    }

    /**
     * Method to set the value of field roles
     *
     * @param string $roles
     * @return $this
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the value of field controller
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns the value of field action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Returns the value of field subMenu
     *
     * @return integer
     */
    public function getSubMenu()
    {
        return $this->subMenu;
    }

    /**
     * Returns the value of field children
     *
     * @return string
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Returns the value of field tools
     *
     * @return string
     */
    public function getTools()
    {
        return $this->tools;
    }

    /**
     * Returns the value of field roles
     *
     * @return string
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'url';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Url[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Url
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
