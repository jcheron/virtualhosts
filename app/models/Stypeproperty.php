<?php

class Stypeproperty extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $idStype;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $idProperty;

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
    protected $template;

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
     * Method to set the value of field idProperty
     *
     * @param integer $idProperty
     * @return $this
     */
    public function setIdProperty($idProperty)
    {
        $this->idProperty = $idProperty;

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
     * Method to set the value of field template
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
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
     * Returns the value of field idProperty
     *
     * @return integer
     */
    public function getIdProperty()
    {
        return $this->idProperty;
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
     * Returns the value of field template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idProperty', 'Property', 'id', ['alias' => 'Properties']);
        $this->belongsTo('idStype', 'Stype', 'id', ['alias' => 'Stype']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'stypeproperty';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Stypeproperty[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Stypeproperty
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
