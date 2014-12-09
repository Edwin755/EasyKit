<?php

    /**
     * Model file, to establish connection from the app to the database
     * 
     * @author Edwin Dayot <edwin.dayot@sfr.fr>
     * @copyright 2014
     */

    namespace Core;

    use App\Models;
    use Exception;
    use \PDO as PDO;
    use PDOException;

    /**
     * Model Class
     *
     * @property mixed lastInsertId
     */
    class Model
    {

        /**
         * List of connections and params in database file
         */
        protected $connections;

        /**
         * Infos on database selected
         */
        protected $connection;

        /**
         * PDO Object
         */
        protected $pdo;

        /**
         * Params for bindValue
         */
        protected $params = array();

        /**
         * Table to affect for modifications
         */
        protected $table;

        /**
         * prefix of the table
         */
        protected $prefix;

        /**
         * Default primary key
         */
        protected $pk = 'id';
        
        /**
         * Construct
         * Establish connection to database
         *
         * @param string $connection Name of the database connection to connect
         *
         * @throws Exception
         * 
         * @return boolean
         */
        function __construct($connection = null) {
            $this->connections = require __DIR__ . '/../app/config/database.php';

            ini_set('magic_quotes_gpc', 'Off');

            if (empty($this->table)) {
                $class = get_class($this);
                $class = explode("\\", $class);
                $class = end($class);
                $this->table = strtolower($class);
            }
            
            $this->pk = strtolower($this->table) . '_' . $this->pk;

            if ($this->connection != null) {
                $this->connection = $this->connections['connections'][$connection];
            } else {
                $this->connection = $this->connections['connections'][$this->connections['default']];
            }

            $this->prefix = $this->connection['prefix'];

            if (!empty($this->pdo)) {
                return true;
            }

            try {
                $this->pdo = new PDO('mysql:host=' . $this->connection['host'] . ';dbname=' . $this->connection['database'],
                    $this->connection['username'],
                    $this->connection['password'],
                    array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->connection['charset'],
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ));
            } catch (PDOException $e) {
                throw new Exception("Error Processing Request: connectiion to DB", 1);
            }

            return false;
        }

        /**
         * Find a value in the selected table
         *
         * @param array $req
         *
         * @throws Exception
         *
         * @return array|boolean
         *
         * @example $req = array(
         *      'fields'        => array(
         *          'id',
         *          'name'
         *          ),
         *      'conditions'    => array(
         *          'id'            => '24',
         *          'name'          => 'namame'
         *          ),
         *      'like'          => array(
         *          'name'      => 'test'
         *          ),
         *      'order'         => array(
         *          'id',
         *          'name'
         *          ),
         *      'order'         => 'id, name',
         *      'order'         => 'id',
         *      'limit'         => array(
         *          0,
         *          15
         *          ),
         *      'limit'         => '0, 15'
         *      );
         */
        public function select($req = array()) {
            $sql = 'SELECT ';

            if (!isset($req['count'])) {
                if (isset($req['fields'])) {
                    $sql .= implode(', ', $req['fields']);
                } else {
                    $sql .= '*';
                }
            } else {
                $sql .= ' COUNT(*) AS Count';
            }

            /**
             * FROM
             */
            $sql .= ' FROM `' . $this->prefix . $this->table . '` AS ' . $this->table;

            if (isset($req['join'])) {
                foreach ($req['join'] as $model) {
                    $model['name'] = strtolower($model['name']);
                    $sql .= ' ' . strtoupper($model['direction']) . ' JOIN `' . $this->prefix . $model['name'] . '` AS ' . $model['name'] . ' ON ' . $this->table . '.' . $this->table . '_' . $model['name'] . '_id' . '=' . $model['name'] . '.' . $model['name'] . '_id';
                }
            }

            /**
             * WHERE
             */
            if (isset($req['conditions'])) {

                $sql .= ' WHERE ';

                $conditions = array();

                foreach ($req['conditions'] as $k => $v) {
                    $k = strtolower($this->table) . '_' . $k;
                    if (substr($v, 0, 1) == '>') {
                        $conditions[$k] = '`' . $k . '` > :' . $k;

                        $v = intval(trim(str_replace('>', '', $v)));
                    } elseif (substr($v, 0, 1) == '<') {
                        $conditions[$k] = '`' . $k . '` < :' . $k;

                        $v = intval(trim(str_replace('<', '', $v)));
                    } else {
                        $conditions[$k] = '`' . $k . '` = :' . $k;
                    }
                    
                    $this->params[':' . $k] = $v;
                }

                $sql .= implode(' AND ', $conditions);
            } elseif (isset($req['like'])) {
                $sql .= ' WHERE ';
                foreach ($req['like'] as $k => $v) {
                    $conditions[$k] = '`' . $k . '` LIKE :' . $k;
                    
                    $this->params[':' . $k] = '%' . $v . '%';
                }

                $sql .= implode(' AND ', $conditions);
            }

            /**
             * ORDER
             */
            $sql .= ' ORDER BY ';
            if (isset($req['orderby'])) {
                if (is_array($req['orderby'])) {
                    $sql .= implode(', ', $req['orderby']);
                } else {
                    $sql .= '`' . $req['orderby'] . '`';
                }               
            } else {
                $sql .= '`' . $this->pk . '`';
            }

            if (isset($req['order'])) {
                $sql .= ' ' . strtoupper($req['order']) . ' ';
            }

            /**
             * LIMIT
             */
            if (isset($req['limit'])) {
                if (is_array($req['limit'])) {
                    $sql .= ' LIMIT ' . implode(', ', $req['limit']);
                } else {
                    $sql .= ' LIMIT ' . $req['limit'];
                }   
            }

            $sql .= ';';

            /**
             * PREPARE BINDVALUE EXECUTE
             */
            $pre = $this->pdo->prepare($sql);
            $query = $sql;
            foreach ($this->params as $param => $value) {
                if (is_string($value)) {
                    $pre->bindValue($param, $value, PDO::PARAM_STR);
                    $query = str_replace(':' . $param, '"' . $value . '"', $sql);
                } elseif (is_int($value)) {
                    $pre->bindValue($param, $value, PDO::PARAM_INT);
                    $query = str_replace(':' . $param, $value, $sql);
                } elseif (is_null($value)) {
                    $pre->bindValue($param, $value, PDO::PARAM_NULL);
                    $query = str_replace(':' . $param, $value, $sql);
                } elseif (is_bool($value)) {
                    $pre->bindValue($param, $value, PDO::PARAM_BOOL);
                    $query = str_replace(':' . $param, $value, $sql);
                } else {
                    throw new Exception('Error Processing Request. binValue error : ' . $param . ' => ' . $value, 1);
                }
            }
            if ($pre->execute()) {
                $return = $pre->fetchAll($this->connections['fetch']);
                $pre->closeCursor();
                $this->params = array();

                $query = "FIND : \n" . $query;
                // log_write('sql', $query);

                return $return;
            } else {
                return false;
            }
        }

        /**
         * Insert a value in the selected table
         *
         * @param array $req
         *
         * @throws Exception
         *
         * @return boolean
         */
        public function save($req = array())
        {
            $type = 'insert';
            $fields = array();

            foreach ($req as $k => $v) {
                $k = strtolower($this->table) . '_' . $k;
                if ($k == $this->pk) {
                    $type = 'update';
                } else {
                    $fields[$k] = '`' . $k . '` = :' . $k;
                }

                $this->params[':' . $k] = stripslashes(htmlentities($v));
            }

            if ($type == 'insert') {

                /**
                 * INSERT
                 */
                $sql = 'INSERT INTO `' . $this->prefix . $this->table . '` SET ' . implode(', ', $fields);
            } elseif ($type == 'update') {

                /**
                 * UPDATE
                 */
                $sql = 'UPDATE `' . $this->prefix . $this->table . '` SET ' . implode(', ', $fields) . ' WHERE `' . $this->pk . '` = :' . $this->pk;
            }

            $sql .= ';';

            /**
             * PREPARE BINDVALUE EXECUTE
             */
            $pre = $this->pdo->prepare($sql);
            $query = $sql;
            foreach ($this->params as $param => $value) {
                if (is_string($value)) {
                    $pre->bindValue($param, $value, PDO::PARAM_STR);
                    $query = str_replace(':' . $param, '"' . $value . '"', $sql);
                } elseif (is_int($value)) {
                    $pre->bindValue($param, $value, PDO::PARAM_INT);
                    $query = str_replace(':' . $param, $value, $sql);
                } elseif (is_null($value)) {
                    $pre->bindValue($param, $value, PDO::PARAM_NULL);
                    $query = str_replace(':' . $param, $value, $sql);
                } elseif (is_bool($value)) {
                    $pre->bindValue($param, $value, PDO::PARAM_BOOL);
                    $query = str_replace(':' . $param, $value, $sql);
                } else {
                    throw new Exception('Error Processing Request. binValue error : ' . $param . ' => ' . $value, 1);
                }
            }
            if ($pre->execute()) {
                $this->lastInsertId = $this->pdo->lastInsertId();
                $this->params = array();

                $query = "SAVE : \n" . $query;
                // log_write('sql', $query);

                return $this->pdo->lastInsertId();
            } else {
                return false;
            }
        }

        /**
         * Get the lastest saved entity
         */
        public function getLastSaved() {
            return $this->select(array(
                'conditions'    => array(
                    'id'            => $this->lastInsertId 
                    )
                ));
        }

        /**
         * Delete a value in the selected table
         *
         * @param integer $id The id of entity that have to be deleted
         * 
         * @return boolean
         */
        public function delete($id)
        {
            /**
             * DELETE
             */
            $sql = 'DELETE FROM `' . $this->prefix . $this->table . '` WHERE `' . $this->pk . '` = :' . $this->pk . ';';

            /**
             * PREPARE BINDVALUE EXECUTE
             */
            $query = $sql;
            $pre = $this->pdo->prepare($sql);
            $pre->bindValue($this->pk, $id, PDO::PARAM_INT);
            $pre->execute();
            $query = str_replace(':' . $this->pk, $id, $sql);

            $query = "REMOVE : \n" . $query;

            //log_write('sql', $query);

            return true;
        }
    }
