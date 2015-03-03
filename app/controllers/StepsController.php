<?php

/**
 * StepsController file
 *
 * Created by worker
 */

namespace App\Controllers;

use Core;
use Core\Controller;
use Core\Validation;
use Core\View;
use Core\Session;
use Core\Cookie;

/**
 * Class StepsController
 * @property object Steps
 */
class StepsController extends AppController
{

    /**
     * Errors
     *
     * @var array $errors
     */
    private $errors = [];

    /**
     * Datas for model
     *
     * @var string $name
     * @var int $goal
     * @var int pack
     * @var int user
     * @var string $token
     */
    private $name, $goal, $pack, $user, $token;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * @param string $goal
     */
    public function setGoal($goal)
    {
        $this->goal = $goal;
    }

    /**
     * @return string
     */
    public function getPack()
    {
        return $this->pack;
    }

    /**
     * @param string $pack
     */
    public function setPack($pack)
    {
        $this->pack = $pack;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Create a step
     *
     * @param int $id
     */
    function api_create()
    {
        if (!empty($_POST)) {
            if (isset($_POST['name']) && $_POST['name'] != null) {
                $this->setName($_POST['name']);
            } else {
                $this->errors['name'] = 'Empty name.';
            }

            if (isset($_POST['goal']) && $_POST['goal'] != null) {
                $this->setGoal($_POST['goal']);
            } else {
                $this->errors['goal'] = 'Empty goal.';
            }

            if (isset($_POST['pack']) && $_POST['pack'] != null) {
                $this->setPack($_POST['pack']);
            } else {
                $this->errors['pack'] = 'Empty pack id.';
            }

            if (isset($_POST['token']) && $_POST['token'] != null) {
                $this->setToken($_POST['token']);
            } else {
                $this->errors['token'] = 'Empty token.';
            }

            if (empty($this->errors)) {
                $user = $this->getJSON($this->link('api/users/checkToken/' . $this->getToken() . '/' . $_SERVER['REMOTE_ADDR']));
                if ($user->valid) {
                    $user_id = $user->user->tokens_users_id;

                    $pack = $this->getJSON($this->link('api/packs/get/' . $this->getPack()));

                    if ($pack->pack != false) {
                        if ($pack->pack->packs_users_id != $user_id) {
                            $this->errors['pack'] = 'You aren\'t the ownner of this pack.';
                        }
                    } else {
                        $this->errors['pack'] = 'This pack doesn\'t exists.';
                    }
                }

                if (empty($this->errors)) {
                    $this->loadModel('Steps');
                    $this->Steps->save([
                        'packs_id'  => $this->getPack(),
                        'name'      => $this->getName(),
                        'goal'      => $this->getGoal()
                    ]);
                }
            }
        } else {
            $this->errors['post'] = 'No POST received.';
        }

        $data['success'] = empty($this->errors) ? true : false;
        $data['errors'] = $this->errors;

        View::make('api.index', json_encode($data), false, 'application/json');
    }
}
