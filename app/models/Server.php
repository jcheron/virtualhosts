<?php

class Server extends \Phalcon\Mvc\Model
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
     * @Column(type="string", length=255, nullable=true)
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
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $configFile;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $idHost;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $idStype;

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
     * Method to set the value of field configFile
     *
     * @param string $configFile
     * @return $this
     */
    public function setConfigFile($configFile)
    {
        $this->configFile = $configFile;

        return $this;
    }

    /**
     * Method to set the value of field idHost
     *
     * @param integer $idHost
     * @return $this
     */
    public function setIdHost($idHost)
    {
        $this->idHost = $idHost;

        return $this;
    }

    /**
     * Method to set the value of field idStype
     *
     * @param integer $idStype
     * @return $this
     */
    public function setIdStype($idStype)
    {
        $this->idStype = $idStype;

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
     * Returns the value of field configFile
     *
     * @return string
     */
    public function getConfigFile()
    {
        return $this->configFile;
    }

    /**
     * Returns the value of field idHost
     *
     * @return integer
     */
    public function getIdHost()
    {
        return $this->idHost;
    }

    /**
     * Returns the value of field idStype
     *
     * @return integer
     */
    public function getIdStype()
    {
        return $this->idStype;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Virtualhost', 'idServer', ['alias' => 'Virtualhost']);
        $this->belongsTo('idStype', 'Stype', 'id', ['alias' => 'Stype']);
        $this->belongsTo('idHost', 'Host', 'id', ['alias' => 'Host']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'server';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Server[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Server
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
