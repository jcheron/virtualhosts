<?php

class Virtualhost extends \Phalcon\Mvc\Model
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
     * @Column(type="string", length=250, nullable=true)
     */
    protected $name;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $config;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $idServer;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $idUser;

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
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field config
     *
     * @param string $config
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Method to set the value of field idServer
     *
     * @param integer $idServer
     * @return $this
     */
    public function setIdServer($idServer)
    {
        $this->idServer = $idServer;

        return $this;
    }

    /**
     * Method to set the value of field idUser
     *
     * @param integer $idUser
     * @return $this
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

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
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field config
     *
     * @return string
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Returns the value of field idServer
     *
     * @return integer
     */
    public function getIdServer()
    {
        return $this->idServer;
    }

    /**
     * Returns the value of field idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Virtualhostproperty', 'idVirtualhost', ['alias' => 'Virtualhostproperties']);
        $this->belongsTo('idUser', 'User', 'id', ['alias' => 'User']);
        $this->belongsTo('idServer', 'Server', 'id', ['alias' => 'Server']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'virtualhost';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Virtualhost[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Virtualhost
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
