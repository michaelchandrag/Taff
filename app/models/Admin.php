<?php

class Admin extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="adminId", type="string", length=10, nullable=false)
     */
    public $adminId;

    /**
     *
     * @var string
     * @Column(column="adminEmail", type="string", length=50, nullable=false)
     */
    public $adminEmail;

    /**
     *
     * @var string
     * @Column(column="adminPassword", type="string", length=50, nullable=false)
     */
    public $adminPassword;

    /**
     *
     * @var string
     * @Column(column="adminName", type="string", length=50, nullable=false)
     */
    public $adminName;

    /**
     *
     * @var string
     * @Column(column="adminStatus", type="string", length=1, nullable=false)
     */
    public $adminStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("admin");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'admin';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Admin[]|Admin|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Admin|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function insertAdmin($id,$email,$password,$name,$status)
    {
        $this->adminId = $id;
        $this->adminEmail = $email;
        $this->adminPassword = $this->security->hash($password);
        $this->adminName = $name;
        $this->adminStatus = "1";
        $this->save();
    }

}
