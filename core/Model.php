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
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
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
     * Database Informations
     *
     * @var array $connections
     * @var array $connection
     * @var object $pdo
     * @var array $table
     * @var array $join
     * @var array $fields
     * @var string $prefix
     */
    protected $connections, $connection, $pdo, $table, $join, $fields, $prefix;

    /**
     * Params for bindValue
     *
     * @var array $params
     */
    protected $params = array();

    /**
     * Tables
     *
     * @var array
     */
    protected $tables = array();

    /**
     * Default primary key
     *
     * @var string $pk
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
    function __construct($connection = null)
    {
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
            throw new Exception("Error Processing Request: connection to DB", 1);
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
    public function select($req = array())
    {
        $sql = 'SELECT ';

        if (!isset($req['count'])) {
            if (isset($req['fields'])) {
                $sql .= implode(', ', $req['fields']);
            } else if (!empty($this->tables)) {
                $previous = false;
                foreach ($this->tables as $table) {
                    if ($previous == true) {
                        $sql .= ', ';
                    }
                    $previous = true;
                    $sql .= $table . '.*';
                }
            } else if (!empty($this->fields)) {
                $sql .= $this->fields . '.*';
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

        if (!empty($this->tables)) {
            $count = 0;
            foreach ($this->tables as $table) {
                $count++;
                if ($count == 1) {
                    $previous = $table;
                    $sql .= ' INNER JOIN `' . $this->prefix . $table . '` AS ' . $table . ' ON ' . $table . '.' . $table . '_' . $this->table . '_id = ' . $this->table . '.' . $this->table . '_id';
                } else {
                    $sql .= ' INNER JOIN `' . $this->prefix . $table . '` AS ' . $table . ' ON ' . $previous . '.' . $previous . '_' . $table . '_id = ' . $table . '.' . $table . '_id';
                }
            }
        }

        /**
         * WHERE
         */
        if (isset($req['conditions']) && is_array($req['conditions'])) {

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
        } else if (isset($req['conditions']) && is_string($req['conditions'])) {
            $sql .= $req['conditions'];
        } else if (isset($req['like'])) {
            $sql .= ' WHERE ';
            foreach ($req['like'] as $k => $v) {
                $k = strtolower($this->table) . '_' . $k;
                $conditions[$k] = '`' . $k . '` LIKE :' . $k;

                $this->params[':' . $k] = '%' . $v . '%';
            }

            $sql .= implode(' AND ', $conditions);
        } else if (isset($req['likeor'])) {
            $sql .= ' WHERE ';
            foreach ($req['likeor'] as $k => $v) {
                $k = strtolower($this->table) . '_' . $k;
                $conditions[$k] = '`' . $k . '` LIKE :' . $k;

                $this->params[':' . $k] = '%' . $v . '%';
            }

            $sql .= implode(' OR ', $conditions);
        }

        /**
         * ORDER
         */
        if (empty($this->tables)) {
            if (isset($req['orderby'])) {
                $sql .= ' ORDER BY ';
                if (is_array($req['orderby'])) {
                    $sql .= $this->table . '_' . implode(', ' . $this->table . '_', $req['orderby']);
                } else {
                    $sql .= '`' . $this->table . '_' . $req['orderby'] . '`';
                }
            }
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
                $query = str_replace($param, '"' . $value . '"', $query);
            } elseif (is_int($value)) {
                $pre->bindValue($param, $value, PDO::PARAM_INT);
                $query = str_replace($param, $value, $query);
            } elseif (is_null($value)) {
                $pre->bindValue($param, $value, PDO::PARAM_NULL);
                $query = str_replace($param, $value, $query);
            } elseif (is_bool($value)) {
                $pre->bindValue($param, $value, PDO::PARAM_BOOL);
                $query = str_replace($param, $value, $query);
            } else {
                throw new Exception('Error Processing Request. binValue error : ' . $param . ' => ' . $value, 1);
            }
        }

        try {
            $pre->execute();
            $return = $pre->fetchAll($this->connections['fetch']);
            $pre->closeCursor();
            $this->params = array();
            $this->tables = null;
            $this->fields = null;

            if (isset($req['count'])) {
                $return = current($return)->Count;
            }

            $log = new Logger('select');
            $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/sql.log', Logger::INFO));
            $log->addInfo($query);

            return $return;
        } catch (PDOException $e) {
            return $e->getMessage();
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
                $query = str_replace($param, '"' . $value . '"', $sql);
            } elseif (is_int($value)) {
                $pre->bindValue($param, $value, PDO::PARAM_INT);
                $query = str_replace($param, $value, $sql);
            } elseif (is_null($value)) {
                $pre->bindValue($param, $value, PDO::PARAM_NULL);
                $query = str_replace($param, $value, $sql);
            } elseif (is_bool($value)) {
                $pre->bindValue($param, $value, PDO::PARAM_BOOL);
                $query = str_replace($param, $value, $sql);
            } else {
                throw new Exception('Error Processing Request. binValue error : ' . $param . ' => ' . $value, 1);
            }
        }

        try {
            $pre->execute();
            $this->lastInsertId = $this->pdo->lastInsertId();
            $this->params = null;

            $log = new Logger('save');
            $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/sql.log', Logger::INFO));
            $log->addInfo($query);

            return $this->lastInsertId;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get the lastest saved entity
     *
     * @return array|bool
     */
    public function getLastSaved()
    {
        return $this->select(array(
            'conditions' => array(
                'id' => $this->lastInsertId
            )
        ));
    }

    /**
     * Delete a value in the selected table
     *
     * @param integer|array $req The id or conditions of entity that have to be deleted
     *
     * @return boolean
     */
    public function delete($req)
    {
        if (is_array($req)) {
            foreach ($req as $k => $v) {
                $k = strtolower($this->table) . '_' . $k;

                $fields[$k] = '`' . $k . '` = :' . $k;

                $this->params[':' . $k] = stripslashes(htmlentities($v));
            }
        } else {
            $fields[$this->pk] = '`' . $this->pk . '` = :' . $req;
            $this->params[':' . $this->pk] = $req;
        }

        /**
         * DELETE
         */
        $sql = 'DELETE FROM `' . $this->prefix . $this->table . '` WHERE ' . implode(' AND ', $fields) . ';';

        /**
         * PREPARE BINDVALUE EXECUTE
         */
        $query = $sql;
        $pre = $this->pdo->prepare($sql);
        foreach ($this->params as $param => $value) {
            if (is_string($value)) {
                $pre->bindValue($param, $value, PDO::PARAM_STR);
                $query = str_replace($param, '"' . $value . '"', $sql);
            } elseif (is_int($value)) {
                $pre->bindValue($param, $value, PDO::PARAM_INT);
                $query = str_replace($param, $value, $sql);
            } elseif (is_null($value)) {
                $pre->bindValue($param, $value, PDO::PARAM_NULL);
                $query = str_replace($param, $value, $sql);
            } elseif (is_bool($value)) {
                $pre->bindValue($param, $value, PDO::PARAM_BOOL);
                $query = str_replace($param, $value, $sql);
            } else {
                throw new Exception('Error Processing Request. binValue error : ' . $param . ' => ' . $value, 1);
            }
        }

        try {
            $pre->execute();
            $this->lastInsertId = $this->pdo->lastInsertId();
            $this->params = null;

            $log = new Logger('delete');
            $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/sql.log', Logger::INFO));
            $log->addInfo($query);

            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Has many
     *
     * @param $name string
     * @param array $req
     *
     * @return array|bool
     *
     * @throws Exception
     */
    public function hasMany($name, $req = array())
    {
        $name = strtolower($name);
        $this->tables = array($this->table . '_' . $name, $name);
        $this->join = 'has';

        $return = $this->select($req);

        return $return;
    }

    /**
     * Has one
     *
     * @param $name
     * @param array $req
     *
     * @return array|bool
     *
     * @throws Exception
     */
    public function hasOne($name, $req = array())
    {
        $name = strtolower($name);
        $this->fields = $name;
        $req['join'] = array(array(
            'name' => $name,
            'direction' => 'left',
        ));

        $return = current($this->select($req));

        return $return;
    }

    /**
     * Belongs to many
     *
     * @param $name string
     * @param array $req
     *
     * @return array|bool
     *
     * @throws Exception
     */
    public function belongsToMany($name, $req = array())
    {
        $name = strtolower($name);
        $this->tables = array($name . '_' . $this->table, $name);

        $return = $this->select($req);

        return $return;
    }

    /**
     * Belongs to
     *
     * @param $name string
     * @param array $req
     *
     * @return array|bool
     *
     * @throws Exception
     */
    public function belongsTo($name, $req = array())
    {
        $name = strtolower($name);
        $this->fields = $name;
        $req['fields'] = array(
            $this->table . '.*'
        );
        $req['join'] = array(array(
            'name' => $name,
            'direction' => 'left',
        ));

        $return = $this->select($req);

        return $return;
    }
}
