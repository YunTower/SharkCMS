<?php

/**
 * --------------------------------------------------------------------------------
 * @ Author：fish（https://gitee.com/fish_nb）
 * @ Gitee：https://gitee.com/sharkcms/sharkcms
 * @ Link：https://sharkcms.cn
 * @ License：https://gitee.com/sharkcms/sharkcms/blob/master/LICENSE
 * @ 版权所有，请勿侵权。因将此项目用于非法用途导致的一切结果，作者将不承担任何责任，请自负！
 * --------------------------------------------------------------------------------
 */


# --------------------------------## 数据库操作 ##--------------------------------#

class DB
{
    private $_db = null; //数据库连接句柄
    private $_table = null; //表名
    private $_where = null; //where条件
    private $_order = null; //order排序
    private $_limit = null; //limit限定查询
    private $_group = null; //group分组
    private $_configs = null; //数据库配置



    // 构造数据库连接函数
    public function __construct()
    {
        $this->_configs = System::getConfig('DB_CONNECT');
        $link = $this->_db;
        if (!$link) {
            $db = mysqli_connect($this->_configs['hostname'], $this->_configs['username'], $this->_configs['password'], $this->_configs['dbname']);
            mysqli_query($db, "set names utf8");
            if (!$db) {
                System::ERROR('数据库错误', mysqli_connect_error());
            }
            $this->_db = $db;
        }
    }

    // 获取所有数据
    public function getAll($table = null)
    {
        $link = $this->_db;
        if (!$link) return false;
        $sql = "SELECT * FROM {$table}";
        $data = mysqli_fetch_all($this->execute($sql), MYSQLI_ASSOC);
        return $data;
    }

    // 设置数据表
    public function table($table)
    {
        $this->_table = $table;
        return $this;
    }

    // select查询
    public function select($fields = "*")
    {
        $fieldsStr = '';
        $link = $this->_db;
        if (!$link) return false;
        if (is_array($fields)) {
            $fieldsStr = implode(',', $fields);
        } elseif (is_string($fields) && !empty($fields)) {
            $fieldsStr = $fields;
        }
        $sql = "SELECT {$fields} FROM {$this->_table} {$this->_where} {$this->_order} {$this->_limit}";
        $data = mysqli_fetch_array($this->execute($sql), MYSQLI_ASSOC);
        return $data;
    }

    // order排序查询
    public function order($order = '')
    {
        $orderStr = '';
        $link = $this->_db;
        if (!$link) return false;
        if (is_string($order) && !empty($order)) {
            $orderStr = "ORDER BY " . $order;
        }
        $this->_order = $orderStr;
        return $this;
    }

    // where条件查询
    public function where($where = '')
    {
        $whereStr = '';
        $link = $this->_db;
        if (!$link) return $link;
        if (is_array($where)) {
            foreach ($where as $key => $value) {
                if ($value == end($where)) {
                    $whereStr .= "`" . $key . "` = '" . $value . "'";
                } else {
                    $whereStr .= "`" . $key . "` = '" . $value . "' AND ";
                }
            }
            $whereStr = "WHERE " . $whereStr;
        } elseif (is_string($where) && !empty($where)) {
            $whereStr = "WHERE " . $where;
        }
        $this->_where = $whereStr;
        return $this;
    }

    // group分组查询
    public function group($group = '')
    {
        $groupStr = '';
        $link = $this->_db;
        if (!$link) return false;
        if (is_array($group)) {
            $groupStr = "GROUP BY " . implode(',', $group);
        } elseif (is_string($group) && !empty($group)) {
            $groupStr = "GROUP BY " . $group;
        }
        $this->_group = $groupStr;
        return $this;
    }

    // limit限定查询
    public function limit($limit = '')
    {
        $limitStr = '';
        $link = $this->_db;
        if (!$link) return $link;
        if (is_string($limit) || !empty($limit)) {
            $limitStr = "LIMIT " . $limit;
        } elseif (is_numeric($limit)) {
            $limitStr = "LIMIT " . $limit;
        }
        $this->_limit = $limitStr;
        return $this;
    }

    // 执行语句
    public function execute($sql = null)
    {
        $link = $this->_db;
        if (!$link) return false;
        $res = mysqli_query($this->_db, $sql);
        if (!$res) {
            $errors = mysqli_error_list($this->_db);
            System::ERROR('数据库错误', "错误号：" . $errors[0]['errno'] . "<br/>SQL错误状态：" . $errors[0]['sqlstate'] . "<br/>错误信息：" . $errors[0]['error']);
            die();
        }
        return $res;
    }

    // insert插入数据
    public function insert($data)
    {
        $link = $this->_db;
        if (!$link) return false;
        if (is_array($data)) {
            $keys = '';
            $values = '';
            foreach ($data as $key => $value) {
                $keys .= "`" . $key . "`,";
                $values .= "'" . $value . "',";
            }
            $keys = rtrim($keys, ',');
            $values = rtrim($values, ',');
        }
        $sql = "INSERT INTO `{$this->_table}`({$keys}) VALUES({$values})";
        if (mysqli_query($this->_db, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    // update数据更新
    public function update($data)
    {
        $link = $this->_db;
        if (!$link) return $link;
        if (is_array($data)) {
            $dataStr = '';
            foreach ($data as $key => $value) {
                $dataStr .= "`" . $key . "`='" . $value . "',";
            }
            $dataStr = rtrim($dataStr, ',');
        }
        $sql = "UPDATE `{$this->_table}` SET {$dataStr} {$this->_where} {$this->_order} {$this->_limit}";
        $res = $this->execute($sql);
        return $res;
    }

    // delete数据删除
    public function delete()
    {
        $link = $this->_db;
        if (!$link) return $link;
        $sql = "DELETE FROM `{$this->_table}` {$this->_where}";
        $res = $this->execute($sql);
        return $res;
    }

    // 异常输出
    private function ShowException($var)
    {
        if (is_bool($var)) {
            var_dump($var);
        } else if (is_null($var)) {
            var_dump(NULL);
        } else {
            System::ERROR('数据库错误', $var);
            // echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9;'>" . print_r($var, true) . "</pre>";
        }
    }
}
