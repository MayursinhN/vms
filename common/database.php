<?php

/*********************************************
 * VMS - Database Class
 * Date - 10-Nov-2017 10:08
 **********************************************/
class Database
{
    private $_hostname = "";
    private $_username = "";
    private $_password = "";
    private $_database = "";
    private $_column = array();
    private $_table = "";
    private $_pdo_connect = '';

    public function __construct()
    {
        if ($_SERVER['HTTP_HOST'] == "localhost") {
            if (define('HOST', "localhost")) {
                $this->_hostname = HOST;
            }
            if (define('USER', 'root')) {
                $this->_username = USER;
            }
            if (define('PASSWORD', "")) {
                $this->_password = PASSWORD;
            }
            if (define('DATABASE', 'db_vms')) {
                $this->_database = DATABASE;
            }
        } else {
            if (define('HOST', "localhost")) {
                $this->_hostname = HOST;
            }
            if (define('USER', 'theadtwq_addsway')) {
                $this->_username = USER;
            }
            if (define('PASSWORD', "MaULKegA%+#+")) {
                $this->_password = PASSWORD;
            }
            if (define('DATABASE', 'theadtwq_addsway')) {
                $this->_database = DATABASE;
            }
        }

        //$connect = @mysql_connect($this->_hostname,$this->_username,$this->_password);
        $pdo = new PDO("mysql:host=" . $this->_hostname . ";dbname=" . $this->_database . "", $this->_username, $this->_password);

        if (!$pdo) {
            die('Enable to connect in MySqL Server.');
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_pdo_connect = $pdo;
    }

    public function getTotal($table, $id, $cond, $params)
    {
        try {
            if ($table != "") $this->_table = $table;

            $query = "SELECT SUM(" . $id . ") as TOTAL FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
            $rs = $this->_pdo_connect->prepare($query);
            $rs->execute($params);
            $total = $rs->rowCount();
            $row = $rs->fetch();
            //$rs->debugDumpParams();
            if ($total > 0) {
                return $row;
            } else {
                return 0;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getTable()
    {
        return $this->_table;
    }

    public function setTable($table)
    {
        if ($table != "")
            $this->_table = $table;
    }

    public function fetchRowAllAssocdata($one, $table, $cond, $params)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $query = "SELECT " . $one . " FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
                $rs = $this->_pdo_connect->prepare($query);
                $rs->execute($params);
                $total = $rs->rowCount();
                $row = $rs->fetchAll();
                $value = array();
                if ($total > 0) {
                    return $row;
                } else {
                    return $value;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchRowAll($table, $cond, $params)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
                $rs = $this->_pdo_connect->prepare($query);
                $rs->execute($params);
                $total = $rs->rowCount();
                $row = $rs->fetchAll();

                // echo $rs->debugDumpParams();

                $value = array();
                if ($total > 0) {
                    return $row;
                } else {
                    return $value;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchRowAllAssoc($table, $cond)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
                $rs = mysql_query($query);
                $num = mysql_num_rows($rs);
                $value = array();
                if ($num > 0) {
                    while ($row = mysql_fetch_assoc($rs)) {
                        $value[] = $row;
                    }
                    return $value;
                } else {
                    return $value;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchAllAsso($table)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "";
                $rs = mysql_query($query);
                $num = mysql_num_rows($rs);
                $value = array();
                if ($num > 0) {
                    while ($row = mysql_fetch_assoc($rs)) {
                        $value[] = $row;
                    }
                    return $value;
                } else {
                    return $value;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchFieldAll($table, $field, $cond)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $query = "SELECT `" . implode(',', $field) . "` FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
                $rs = mysql_query($query);
                $num = mysql_num_rows($rs);
                if ($num > 0) {
                    $value = array();
                    while ($row = mysql_fetch_array($rs)) {

                        $value[] = $row;
                    }
                    return $value;
                } else {
                    return $value;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchRowAllLimit($table, $cond, $start = 0, $limit = 0)
    {

        try {

            if ($table != "") {

                $where = "";
                $limitcond = "";

                if ($cond != "") {
                    $where = " WHERE " . $cond;
                }

                if ($limit > 0) {
                    $limitcond = " LIMIT " . $start . "," . $limit;
                }

                $this->_table = $table;
                $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "`" . $where . $limitcond;
                $rs = mysql_query($query);
                $num = mysql_num_rows($rs);
                if ($num > 0) {
                    $value = array();
                    while ($row = mysql_fetch_array($rs)) {

                        $value[] = $row;
                    }
                    return $value;
                } else {
                    return $value;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchNumOfRow($table, $cond, $params)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
                $rs = $this->_pdo_connect->prepare($query);
                $rs->execute($params);
                $total = $rs->rowCount();

                if ($total > 0) {
                    return $total;
                } else {
                    return NULL;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchRow($table, $cond, $params)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
                $rs = $this->_pdo_connect->prepare($query);
                $rs->execute($params);
                $total = $rs->rowCount();
                $row = $rs->fetch();

                if ($total > 0) {
                    return $row;
                } else {
                    return NULL;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchRowConcate($table, $field, $id)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $in_array = explode(",", $id);
                $in = str_repeat('?,', count($in_array) - 1) . '?';
                $sql = "SELECT GROUP_CONCAT(" . $field . ") as name FROM ".$this->_table." WHERE master_id IN ($in) AND is_active = 1";
                $stm = $this->_pdo_connect->prepare($sql);
                $stm->execute($in_array);
                $data = $stm->fetch();

                if (count($data) > 0) {
                    return $data;
                } else {
                    return NULL;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchMaxRow($table, $id, $cond, $params)
    {
        try {
            if ($table != "") {

                $this->_table = $table;
                $query = "SELECT MAX(" . $id . ") as max_id FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
                $rs = $this->_pdo_connect->prepare($query);
                $rs->execute($params);
                $total = $rs->rowCount();
                $row = $rs->fetch();

                if ($total > 0) {
                    return $row;
                } else {
                    return NULL;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function countInquiry($table, $id, $cond, $params)
    {
        try {
            if ($table != "") {

                $this->_table = $table;
                $query = "SELECT COUNT(" . $id . ") as list_of_count FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
                $rs = $this->_pdo_connect->prepare($query);
                $rs->execute($params);
                $total = $rs->rowCount();
                $row = $rs->fetch();

                if ($total > 0) {
                    return $row;
                } else {
                    return NULL;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function checkRecord($table, $cond, $params, $limit, $offset)
    {
        try {
            if ($table != "") {

                $this->_table = $table;

                $where = "";
                if ($cond != "") {
                    $where = " WHERE " . $cond;
                }

                $query = "SELECT COUNT(`iQueID`) as 'total_record' FROM (SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "` " . $where . " LIMIT $limit OFFSET $offset ) AS c ";

                $rs = $this->_pdo_connect->prepare($query);
                $rs->execute($params);
                $total = $rs->rowCount();
                $row = $rs->fetchAll();
                if ($total > 0) {
                    return $row;
                } else {
                    return $row;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchRowwithjoin($table, $table2, $common, $common1, $cond, $params)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $where = "";
                if ($cond != "") {
                    $where = " WHERE " . $cond;
                }
                $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "` LEFT JOIN `" . $this->_database . "`." . $table2 . " ON `" . $this->_database . "`." . $table . "." . $common . " = `" . $this->_database . "`." . $table2 . "." . $common1 . " " . $where;
                $rs = $this->_pdo_connect->prepare($query);
                $rs->execute($params);
                $total = $rs->rowCount();
                $row = $rs->fetchAll(PDO::FETCH_ASSOC);
                if ($total > 0) {
                    return $row;
                } else {
                    return $row;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchTestsData($table, $table2, $table3, $common, $common1, $cond, $params, $limit = 2, $offset = 0)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $where = "";

                if ($cond != "") {
                    $where = " WHERE " . $cond;
                }

                $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "` LEFT JOIN `" . $this->_database . "`." . $table2 . " ON `" . $this->_database . "`." . $table . "." . $common . " = `" . $this->_database . "`." . $table2 . "." . $common . " LEFT JOIN `" . $this->_database . "`." . $table3 . " ON `" . $this->_database . "`." . $table . "." . $common1 . " = `" . $this->_database . "`." . $table3 . "." . $common1 . " " . $where . " LIMIT $limit OFFSET $offset";

                $rs = $this->_pdo_connect->prepare($query);

                $rs->execute($params);
                $total = $rs->rowCount();
                $row = $rs->fetchAll(PDO::FETCH_ASSOC);
                if ($total > 0) {
                    return $row;
                } else {
                    return $row;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchTestsDataNoLimit($table, $table2, $table3, $common, $common1, $cond, $params)
    {
        try {
            if ($table != "") {
                $this->_table = $table;
                $where = "";

                if ($cond != "") {
                    $where = " WHERE " . $cond;
                }

                $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "` LEFT JOIN `" . $this->_database . "`." . $table2 . " ON `" . $this->_database . "`." . $table . "." . $common . " = `" . $this->_database . "`." . $table2 . "." . $common . " LEFT JOIN `" . $this->_database . "`." . $table3 . " ON `" . $this->_database . "`." . $table . "." . $common1 . " = `" . $this->_database . "`." . $table3 . "." . $common1 . " " . $where;

                $rs = $this->_pdo_connect->prepare($query);

                $rs->execute($params);
                $total = $rs->rowCount();
                $row = $rs->fetchAll(PDO::FETCH_ASSOC);
                if ($total > 0) {
                    return $row;
                } else {
                    return $row;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fetchAllLimit($table, $cond, $params, $limit = 1, $offset = 0)
    {

        try {

            if ($table != "") {
                $this->_table = $table;

                $where = "";
                if ($cond != "") {
                    $where = " WHERE " . $cond;
                }

                $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "` " . $where . " LIMIT $limit OFFSET $offset";
                $rs = $this->_pdo_connect->prepare($query);

                $rs->execute($params);
                //$rs->debugDumpParams();
                $total = $rs->rowCount();
                $row = $rs->fetchAll();

                if ($total > 0) {
                    return $row;
                } else {
                    return $row;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function setData($data)
    {
        $this->_column = $data;
    }

    public function getPageData()
    {
        return $this->_column;
    }

    public function insert($login_array, $table)
    {

        try {

            if ($table != "")
                $this->_table = $table;

            $columns = '';
            $values = '';
            $i = 0;
            $columnString = implode(',', array_keys($login_array));
            $valueString = ":" . implode(',:', array_keys($login_array));
            $sql = "INSERT INTO " . $this->getTable() . " (" . $columnString . ") VALUES (" . $valueString . ")";
            $query = $this->_pdo_connect->prepare($sql);

            foreach ($login_array as $key => $val) {
                $query->bindValue(':' . $key, $val);
            }

            $insert = $query->execute();

            if ($insert > 0) {
                return $insert ? $this->_pdo_connect->lastInsertId() : false;
            } else {
                throw new Exception("Enable to insert data in MySql Server.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update($data, $table, $conditions)
    {

        try {
            if ($table != "")
                $this->_table = $table;

            $colvalSet = '';
            $whereSql = '';
            $i = 0;

            foreach ($data as $key => $val) {
                $pre = ($i > 0) ? ', ' : '';
                $colvalSet .= $pre . $key . "='" . $val . "'";
                $i++;
            }

            if (!empty($conditions) && is_array($conditions)) {

                $whereSql .= ' WHERE ';
                $i = 0;

                foreach ($conditions as $key => $value) {
                    $pre = ($i > 0) ? ' AND ' : '';
                    $whereSql .= $pre . $key . " = '" . $value . "'";
                    $i++;
                }
            }

            $sql = "UPDATE " . $this->getTable() . " SET " . $colvalSet . $whereSql;
            $query = $this->_pdo_connect->prepare($sql);
            $update = $query->execute();

            if ($update) {
                return true;
            } else {
                throw new Exception('Enable to update data in MySql Server.');
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function delete($table, $conditions)
    {
        try {

            if ($table != "")
                $this->_table = $table;

            $whereSql = '';

            if (!empty($conditions) && is_array($conditions)) {

                $whereSql .= ' WHERE ';
                $i = 0;

                foreach ($conditions as $key => $value) {
                    $pre = ($i > 0) ? ' AND ' : '';
                    $whereSql .= $pre . $key . " = " . $value;
                    $i++;
                }
            }

            $sql = "DELETE FROM " . $this->getTable() . $whereSql;

            $delete = $this->_pdo_connect->exec($sql);

            if ($delete) {
                return $delete ? $delete : false;
            } else {
                throw new Exception("Enable to delete data in MySql Server.");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteALL($table)
    {

        try {
            if ($table != "") $this->_table = $table;
            $query = "DELETE FROM `" . $this->_database . "`.`" . $this->getTable();
            $rs = mysql_query($query);
            if ($rs) {
                return true;
            } else {
                throw new Exception("Enable to delete data in MySql Server.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function checkValidLogin($table, $cond, $params)
    {
        try {

            if ($table != "") $this->_table = $table;
            $query = "SELECT * FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
            $rs = $this->_pdo_connect->prepare($query);
            $rs->execute($params);
            $total = $rs->rowCount();
            $row = $rs->fetch();

            if (!empty($row)) {
                return $row;
            } else {
                //throw new Exception("Please check your email id or password");
                return array();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getConcateValue($table, $id, $cond)
    {
        try {

            if ($table != "") $this->_table = $table;

            if ($cond == "") {
                $cond = "1 = 1";
            }

            $query = "SELECT GROUP_CONCAT(" . $id . ") as USERID FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
            $rs = mysql_query($query);
            if ($rs) {

                return mysql_fetch_assoc($rs);

            } else {
                throw new Exception("Please check your email id or password");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getTotalNetWeight($table, $id, $cond, $params)
    {
        try {
            if ($table != "") $this->_table = $table;

            $query = "SELECT SUM(" . $id . ") as TOTAL FROM `" . $this->_database . "`.`" . $this->getTable() . "` WHERE " . $cond;
            $rs = $this->_pdo_connect->prepare($query);
            $rs->execute($params);
            $total = $rs->rowCount();
            $row = $rs->fetch();
            //$rs->debugDumpParams();
            if ($total > 0) {
                return $row;
            } else {
                throw new Exception("Net weight not found");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function loadData($table, $id, $limit, $offset, $cond)
    {
        try {

            if ($table != '') {

                $query = "SELECT * FROM `" . $this->_database . "`." . $table . " WHERE " . $cond . " ORDER BY $id DESC LIMIT $limit OFFSET $offset";

                $rs = mysql_query($query);
                $num = mysql_num_rows($rs);
                $value = array();
                if ($num > 0) {

                    while ($row = mysql_fetch_assoc($rs)) {

                        $value[] = $row;
                    }
                    return $value;
                } else {
                    return $value;
                }
            } else {
                throw new Exception("Please fill the table name.");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}