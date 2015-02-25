<?php

/**
 * PacksController
 *
 * @author Edwin Dayot <edwin.dayot@sfr.fr>
 * @copyright 2014
 */

namespace App\Controllers;

use Core;
use Core\Controller;
use Core\Exceptions\NotFoundHTTPException;
use Core\Helpers\StringHelper;
use Core\Session;
use Core\Validation;
use Core\View;
use Core\Cookie;
use HTML;

/**
 * Class PacksController
 *
 * @property mixed Users
 * @property mixed Token
 * @property mixed Packs
 * @property mixed Steps
 * @package App\Controllers
 */
class PacksController extends AppController
{

    /**
     * Errors
     *
     * @var array $errors
     */
    private $errors = array();

    /**
     * Datas for model
     *
     * @var string $name
     * @var string $description
     * @var string $end
     * @var int $user
     * @var string $token
     */
    private $name, $description, $end, $user, $token;

    /**
     * Set Name
     *
     * @param $name
     */
    function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get Name
     *
     * @return string
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * Set Description
     *
     * @param string $description
     */
    function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get Description
     *
     * @return string
     */
    function getDescription() {
        return $this->description;
    }

    /**
     * Set End
     *
     * @param string $end
     */
    function setEnd($end) {
        if (Validation::validateDate($end, 'Y-m-d H:i')) {
            $this->end = $end;
        } else {
            $this->errors['end'] = 'Not a datetime';
        }
    }

    /**
     * Get End
     *
     * @return string
     */
    function getEnd() {
        return $this->end;
    }

    /**
     * Set Token
     *
     * @param $token
     */
    function setToken($token) {
        $this->token = $token;
    }

    /**
     * Get Token
     *
     * @return string
     */
    function getToken() {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Constructor
     *
     * @return void
     */
    function constructor()
    {
        if (isset($_SESSION['admin']) && $this->getPrefix() == 'admin') {
            $admin = Session::get('admin');
            if (!$this->getJSON($this->link('admin1259/is_admin/' . $admin->admin_username . '/' . $admin->admin_password))->admin) {
                if ($this->getPrefix() != false && $this->getPrefix() == 'admin') {
                    throw new NotFoundHTTPException('Non authorized address.');
                }
            }
        } else if ($this->getPrefix() != false && $this->getPrefix() == 'admin') {
            throw new NotFoundHTTPException('Non authorized address.');
        }
    }

    /**
     * Index API Action
     *
     * @param mixed $id
     *
     * @return void
     */
    function api_get($id = null)
    {
        $this->loadModel('Packs');
        $this->loadModel('Steps');

        if ($id != null) {
            $data['pack'] = current($this->Packs->select(array(
                'conditions'    => array(
                    'id'            => $id
                ),
            )));

            if (!empty($data['pack'])) {
                $data['pack']->steps = $this->Steps->select(array(
                    'conditions'    => array(
                        'packs_id'      => $data['pack']->packs_id
                    ),
                ));

                $data['pack']->user = current($this->getJSON($this->link('api/users/get/' . $data['pack']->packs_users_id)));

                $events = $this->Packs->events(array(
                    'conditions'    => array(
                        'id'      => $data['pack']->packs_id,
                    ),
                ));

                $data['pack']->timeago = HTML::timeago($data['pack']->packs_created_at);

                foreach ($events as $event) {
                    $data['pack']->events = current($this->getJSON($this->link('api/events/get/' . $event->events_packs_events_id)));
                }
            }
        } else {
            $nb = isset($_GET['limit']) && $_GET['limit'] != null ? $_GET['limit'] : 20;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $page = (($page - 1) * $nb);

            $data['packs'] = $this->Packs->select(array(
                'order' => 'desc',
                'orderby'   => 'id',
                'limit' => array($page, $page + $nb),
            ));

            foreach ($data['packs'] as $pack) {
                $pack->steps = $this->Steps->pack(array(
                    'conditions'    => array(
                        'packs_id'      => $pack->packs_id,
                    ),
                ));

                $pack->user = current($this->getJSON($this->link('api/users/get/' . $pack->packs_users_id)));

                $events = $this->Packs->events(array(
                    'conditions'    => array(
                        'id'      => $pack->packs_id,
                    ),
                ));

                $pack->timeago = HTML::timeago($pack->packs_created_at);

                foreach ($events as $event) {
                    $pack->events = current($this->getJSON($this->link('api/events/get/' . $event->events_packs_events_id)));
                }
            }
        }

        View::make('api.index', json_encode($data), false, 'application/json');
    }

    /**
     * API Create
     *
     * @throws Core\Exceptions\NotFoundHTTPException
     */
    function api_create()
    {
        if (!empty($_POST)) {
            if (!empty($_POST['name'])) {
                $this->setName($_POST['name']);
            } else {
                $this->errors['name'] = 'Empty name.';
            }

            if (!empty($_POST['endtime'])) {
                $this->setEnd($_POST['endtime']);
            } else {
                $this->errors['endtime'] = 'Empty end time.';
            }

            if (!empty($_POST['token'])) {
                $this->setToken($_POST['token']);
                $token = true;
            } else {
                $this->setUser(1);
                $token = false;
            }

            if (!empty($_POST['description'])) {
                $this->setDescription($_POST['description']);
            }

            if (empty($this->errors)) {
                $this->loadModel('Packs');

                if ($token) {
                    $user = $this->getJSON($this->link('api/users/checkToken/' . $this->getToken() . '/' . $_SERVER['REMOTE_ADDR']));
                    if ($user->valid) {
                        $user_id = $user->user->tokens_users_id;
                    } else {
                        $this->errors['user'] = $user->errors;
                    }
                } else {
                    $user_id = $this->getUser();
                }

                if (empty($this->errors)) {
                    $this->Packs->save([
                        'name'          => $this->getName(),
                        'description'   => $this->getDescription(),
                        'endtime'       => $this->getEnd(),
                        'slug'          => StringHelper::generateRandomString(6),
                        'users_id'      => $user_id,
                    ]);
                    $pack = $this->Packs->getLastSaved();
                    $data['pack_id'] = $pack->packs_id;
                    $data['slug'] = $pack->packs_slug;
                } else {
                    $this->errors = $user->errors;
                }
            }
        } else {
            $this->errors['POST'] = 'No data received';
        }

        $data['success'] = !empty($this->errors) ? false : true;
        $data['errors'] = $this->errors;

        View::make('api.index', json_encode($data), false, 'application/json');
    }

    /**
     * Create
     *
     * @throws NotFoundHTTPException
     */
    function create()
    {
        if (!empty($_POST)) {
            foreach ($_POST as $k => $v) {
                if (preg_match('#events_([a-z0-9]*)#', $k)) {
                    $k = str_replace('events_', '', $k);
                    $event[$k] = $v;
                } else if (preg_match('#hosting_([a-z0-9]*)#', $k)) {
                    if ($_POST['hosting'] != 'false') {
                        $hosting['name'] = $_POST['hosting'];
                        $k = str_replace('hosting_', '', $k);
                        $hosting[$k] = $v;
                    }
                } else if (preg_match('#transport_([a-z0-9]*)#', $k)) {
                    if ($_POST['transport'] != 'false') {
                        $k = str_replace('transport_', '', $k);
                        $transport['name'] = $_POST['transport'];
                        $transport[$k] = $v;
                    }
                }  else if (preg_match('#option0_([a-z0-9]*)#', $k)) {
                    $k = str_replace('option0_', '', $k);
                    $option0[$k] = $v;
                } else if (preg_match('#option1_([a-z0-9]*)#', $k)) {
                    $k = str_replace('option1_', '', $k);
                    $option1[$k] = $v;
                }
            }

            if (isset($event)) {
                if (empty($event['id'])) {
                    $returnEvent = json_decode($this->postCURL($this->link('api/events/create'), $event), true);
                    if ($returnEvent['success']) {
                        $event_id = $returnEvent['event'];
                    } else {
                        $this->errors = $returnEvent['errors'];
                    }
                } else {
                    $event_id = $event['id'];
                }

                if (empty($this->errors)) {
                    $returnPacks = json_decode($this->postCURL($this->link('api/packs/create'), $event), true);
                    if ($returnPacks['success']) {
                        $pack_id = $returnPacks['pack_id'];
                        $returnPrice = json_decode($this->postCURL($this->link('api/steps/create'), [
                            'pack'      => $pack_id,
                            'goal'      => $event['price'],
                            'name'      => 'eventprice'
                        ]), true);

                        if (!$returnPrice['success']) {
                            $this->errors = $returnPrice['errors'];
                        }
                    } else {
                        $this->errors = $returnPacks['errors'];
                    }
                }
            }

            if (isset($hosting) && empty($this->errors)) {
                $returnHosting = json_decode($this->postCURL($this->link('api/steps/create'), [
                    'pack'      => $pack_id,
                    'goal'      => $hosting['price'],
                    'name'      => $hosting['name']
                ]), true);
                if (!$returnHosting['success']) {
                    $this->errors = $returnHosting['errors'];
                }
            }

            if (isset($transport) && empty($this->errors)) {
                $returnTransport = json_decode($this->postCURL($this->link('api/steps/create'), [
                    'pack'      => $pack_id,
                    'goal'      => $transport['price'],
                    'name'      => $transport['name']
                ]), true);
                if (!$returnTransport['success']) {
                    $this->errors = $returnTransport['errors'];
                }
            }

            if (isset($option0) && empty($this->errors)) {
                $returnOption0 = json_decode($this->postCURL($this->link('api/steps/create'), [
                    'pack'      => $pack_id,
                    'goal'      => $option0['price'],
                    'name'      => $option0['name']
                ]), true);
                if (!$returnOption0['success']) {
                    $this->errors = $returnOption0['errors'];
                }
            }

            if (isset($option1) && empty($this->errors)) {
                $returnOption1 = json_decode($this->postCURL($this->link('api/steps/create'), [
                    'pack'      => $pack_id,
                    'goal'      => $option1['price'],
                    'name'      => $option1['name']
                ]), true);
                if (!$returnOption1['success']) {
                    $this->errors = $returnOption1['errors'];
                }
            }
        }

        View::$title = 'Create your pack';
        View::make('packs.create', null, 'default');
    }

    /**
     * Summary
     *
     * @throws NotFoundHTTPException
     */
    function summary()
    {
        $data = false;
        View::make('packs.summary', $data, 'default');
    }

    /**
     * Show page
     *
     * @throws NotFoundHTTPException
     */
    function show($slug = null)
    {
        $this->loadModel('Packs');
        $pack = $this->Packs->select([
            'conditions'    => [
                'slug'          => $slug
            ]
        ]);

        if (count($pack) == 1) {
            $pack = current($pack);
            $data['pack'] = $this->getJSON($this->link('api/packs/get/' . $pack->packs_id));
            View::$title = $pack->packs_name;
        } else {
            throw new NotFoundHTTPException('Pack not found.');
        }

        View::make('packs.show', $data, 'default');
    }

    /**
     * Admin Index Action
     *
     * @return void
     */
    function admin_index()
    {
        View::$title = 'Packs';

        $this->loadModel('Packs');

        $data['count'] = $this->Packs->select(array('count' => true));

        View::make('packs.admin_index', $data, 'admin');
    }

    /**
     * Admin Count Action
     *
     * @return void
     */
    function admin_count()
    {
        $this->loadModel('Packs');

        $data['count'] = $this->Packs->select(array('count' => true));

        View::make('api.index', json_encode($data), false, 'application/json');
    }
}
