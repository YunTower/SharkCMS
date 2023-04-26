<?php

$post = json_encode(array('name' => 'sk_content', 'id' => '*'));
$page = json_encode(array('name' => 'sk_page', 'id' => '*'));
$user = json_encode(array('name' => 'sk_user', 'id' => '*'));

$count = json_encode(array('post' => DBread('EchoSize', $post), 'page' => DBread('EchoSize', $page), 'user' => DBread('EchoSize', $user), 'menu' => '0'), JSON_UNESCAPED_UNICODE);
exit($json = json_encode(array('msg' => '查询成功！', 'domain' => sys_domain(), 'count' => ($count)), JSON_UNESCAPED_UNICODE));
