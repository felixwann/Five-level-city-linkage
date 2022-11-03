<?php
ini_set('memory_limit', -1);
require_once 'MysqliDb.php';
function msg($code = 1, $data=null,$msg = '成功')
{
    header('Content-Type: application/json');
    echo json_encode([
        'code' => $code,
        'msg' => $msg,
        'data' => $data
    ], JSON_PRETTY_PRINT);
    exit;
}
$conf = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'db' => 'test',
    'port' => 3306,
    'charset' => 'utf8mb4'
];
$db = new MysqliDb($conf);
$tbl = 'region';

if (!empty($params = $_POST) && count($params)>0) {
    list($code, $level) = [$params['code'] ?? null, $params['level'] ?? null];
    if ($level >= 0 && empty($code)) {
        $data = $db->where('level', 0)->get($tbl);
        msg(1, $data);
    }elseif (!empty($code)){
        $data = $db->where('parent_id', $code)->get($tbl);
        msg(1, $data);
    }else{
        msg(-1, '', '失败');
    }
}
msg(-1, '', '失败');