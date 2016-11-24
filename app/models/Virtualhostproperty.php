<?php

class Virtualhostproperty extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $idVirtualhost;

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
    protected $value;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $active;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    protected $comment;

    /**
     * Method to set the value of field idVirtualhost
     *
     * @param integer $idVirtualhost
     * @return $this
     */
    public function setIdVirtualhost($idVirtualhost)
    {
        $this->idVirtualhost = $idVirtualhost;

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
     * Method to set the value of field value
     *
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Method to set the value of field active
     *
     * @param integer $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Method to set the value of field comment
     *
     * @param integer $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Returns the value of field idVirtualhost
     *
     * @return integer
     */
    public function getIdVirtualhost()
    {
        return $this->idVirtualhost;
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
     * Returns the value of field value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns the value of field active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Returns the value of field comment
     *
     * @return integer
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('idProperty', 'Property', 'id', ['alias' => 'Property']);
        $this->belongsTo('idVirtualhost', 'Virtualhost', 'id', ['alias' => 'Virtualhost']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'virtualhostproperty';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Virtualhostproperty[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Virtualhostproperty
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
