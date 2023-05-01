<?php

/**
 * --------------------------------------------------------------------------------
 * @ Author：fish（https://gitee.com/fish_nb）
 * @ Gitee：https://gitee.com/sharkcms/sharkcms
 * @ Link：https://sharkcms.icu
 * @ License：https://gitee.com/sharkcms/sharkcms/blob/master/LICENSE
 * @ 版权所有，请勿侵权。因将此项目用于非法用途导致的一切结果，作者将不承担任何责任，请自负！
 * --------------------------------------------------------------------------------
 */


# --------------------------------## 数据库操作 ##--------------------------------#
/**
 * @name: DBconfig
 * @desc: 数据库配置，解决直接使用System::getConfig报错的问题
 * @author: fish
 * @date: 20230501
 **/
function DBconfig($name)
{
    static $config = null;
    if (!$config) {
        $config = require INC . 'config.php';
    }
    return isset($config[$name]) ? $config[$name] : null;
}

/**
 * @name: DBconnect
 * @desc: 数据库连接函数
 * @author: fish
 * @date: 20230330
 **/
function DBconnect()
{
    static $conn = null;
    if (!$conn) {
        $conn = call_user_func_array('mysqli_connect', DBconfig('DB_CONNECT'));
        if (!$conn) {
            sys_error('数据库错误', '数据库连接错误');
        }
    }
    // $conn = mysqli_fetch_array($conn);
    mysqli_query($conn, "set names " . DBconfig('DB_CHARSET'));
    return $conn;
}

/**
 * @name: DBread
 * @desc: 数据库查询函数
 * @author: fish
 * @date: 20230330
 * @method: EchoALL -> 输出全部 
 *          EchoID -> 条件查询 
 *          EchoPage -> 分页查询 
 *          EchoSize -> 数量查询
 **/
function DBread($method, $data)
{
    $conn = DBconnect();
    $data = json_decode($data, true);

    switch ($method) {
            // 输出全部
        case 'EchoALL':
            $sql = "SELECT " . $data['id'] . " FROM " . $data['name'];
            $res = $conn->query($sql);
            return $res;

            // 条件查询
        case 'EchoWHERE':
            $sql = "SELECT " . $data['id'] . " FROM " . $data['name'] . " WHERE " . $data['whereid'] . "='" . $data['whereinfo'] . "'";
            $res = $conn->query($sql);
            return $res;

            // 分页查询
        case 'EchoPage':

            // 数量查询
        case 'EchoSize':
            $sql = $conn->query("SELECT " . $data['id'] . " FROM " . $data['name']);
            $res = mysqli_num_rows($sql);
            return $res;

            // 是否存在
        case 'EchoExist':
            $sql = $conn->query("SELECT * from " . $data['name'] . " where " . $data['whereid'] . " = '" . $data['whereinfo'] . "' limit 1");
            $res = mysqli_num_rows($sql);
            switch ($res) {
                case '1':
                    return true;
                default:
                    return false;
            }

            // 异常处理
        default:
            $error = mysqli_error($conn);
            sys_error('数据库错误', $error);
    }
}

/**
 * @name: DBwrite
 * @desc: 数据写入函数
 * @author: fish
 * @date: 20230330
 **/
function DBwrite($data)
{
    $conn = DBconnect();
    $data = json_decode($data, true);

    // 数据写入
    $sql = "INSERT INTO " . $data['name'] . " (" . $data['id'] . ") VALUES (" . $data['info'] . ")";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        // 异常处理
        $error = mysqli_error($conn);
        sys_error('数据库错误', $error);
    }
}

/**
 * @name: DBupdate
 * @desc: 数据更新函数
 * @author: fish
 * @date: 20230405
 **/
function DBupdate($data)
{
    $conn = DBconnect();
    $data = json_decode($data, true);

    // s'g
    $sql = "INSERT INTO " . $data['name'] . " (" . $data['id'] . ") VALUES (" . $data['info'] . ")";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        // 异常处理
        $error = mysqli_error($conn);
        sys_error('数据库错误', $error);
    }
}
