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
    use Core\View;
    use Core\Cookie;

    /**
     * PacksController Class
     *
     * @property  Packs
     * @property  Steps
     */
    class PacksController extends Controller
    {
        
        /**
         * Index API Action
         * 
         * @return void
         */
        function api_get($id = null) {
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

                    foreach ($events as $event) {
                        $data['pack']->events = current($this->getJSON($this->link('api/events/get/' . $event->events_packs_events_id)));
                    }
                }
            } else {
                $nb = 20;
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $page = (($page - 1) * $nb);

                $data['packs'] = $this->Packs->select(array(
                    'order' => 'desc',
                    'limit' => array($page, $page + $nb),
                ));

                foreach ($data['packs'] as $pack) {
                    $pack->steps = $this->Steps->select(array(
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

                    foreach ($events as $event) {
                        $pack->events = current($this->getJSON($this->link('api/events/get/' . $event->events_packs_events_id)));
                    }
                }
            }

            View::make('api.index', json_encode($data), false, 'application/json');
        }
    }
