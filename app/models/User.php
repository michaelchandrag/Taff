<?php

class User extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="userId", type="string", length=10, nullable=false)
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
     * @Column(column="userPassword", type="string", length=50, nullable=false)
     */
    public $userPassword;

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
        $this->setSource("user");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function insertUser($name,$email,$password,$status)
    {
        $user = new User();
        $index = $user->countUser();
        $id = "B".str_pad($index,5,'0',STR_PAD_LEFT);
        $user->userId = $id;
        $user->userName = $name;
        $user->userEmail = $email;
        $user->userPassword = $password;
        $user->userStatus = "1";
        $user->save();
    }

    public function countUser()
    {
        $user = User::find();
         return count($user);
    }

    public function validateUser($email)
    {
        $user = User::find();
        $match = false;
        foreach($user as $r)
        {
            if($email == $r->userEmail)
            {
                $match = true;
            }
        }
        return $match;
    }

    public function doLogin($email,$password)
    {
        $user = User::find();
        $id = null;
        foreach($user as $r)
        {
            if($email == $r->userEmail && $password == $r->userPassword)
            {
                $id = $r->userId;
            }
        }
        return $id;
    }

    public function setName($id,$name)
    {
        $user = User::findFirst(
            [
                "userId='".$id."'"
            ]
        );
        $user->userName = $name;
        $user->save();
    }

    public function setNameAdmin($id,$name,$status)
    {
        $user = User::findFirst(
            [
                "userId='".$id."'"
            ]
        );
        $user->userName = $name;
        $user->userStatus = $status;
        $user->save();
    }

    public function setPassword($userId,$userPassword)
    {
        $user = User::findFirst(
            [
                "userId='".$userId."'"
            ]
        );
        $user->userPassword = $userPassword;
        $user->save();
    }
}
