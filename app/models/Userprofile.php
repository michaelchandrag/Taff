<?php

class Userprofile extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Column(column="userProfileId", type="string", length=50, nullable=false)
     */
    public $userProfileId;

    /**
     *
     * @var string
     * @Column(column="userId", type="string", length=50, nullable=false)
     */
    public $userId;

    /**
     *
     * @var string
     * @Column(column="userName", type="string", length=50, nullable=false)
     */
    public $userName;

    /**
     *
     * @var string
     * @Column(column="userEmail", type="string", length=50, nullable=false)
     */
    public $userEmail;

    /**
     *
     * @var string
     * @Column(column="userBio", type="string", length=256, nullable=true)
     */
    public $userBio;

    /**
     *
     * @var string
     * @Column(column="userJoined", type="string", nullable=false)
     */
    public $userJoined;

    /**
     *
     * @var string
     * @Column(column="userImage", type="string", length=50, nullable=false)
     */
    public $userImage;

    /**
     *
     * @var string
     * @Column(column="userStatus", type="string", length=1, nullable=false)
     */
    public $userStatus;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("taff");
        $this->setSource("userprofile");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'userprofile';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Userprofile[]|Userprofile|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Userprofile|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function insertUserProfile($userId,$name,$email,$bio,$image,$status)
    {
        $profile = new Userprofile();
        $index = $profile->countProfile();
        $id = "UP".str_pad($index,5,'0',STR_PAD_LEFT);
        $profile->userProfileId = $id;
        $profile->userId        = $userId;
        $profile->userName      = $name;
        $profile->userEmail     = $email;
        $profile->userBio       = $bio;
        $profile->userJoined    = date("Y-m-d");
        $profile->userImage     = $image;
        $profile->userStatus    = $status;
        $profile->save();
    }

    public function countProfile()
    {
        $profile = Userprofile::find();
        return count($profile);
    }

}
