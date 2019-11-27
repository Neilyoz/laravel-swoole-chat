<?php
require_once './Logic/UserFdRelation.php';

use ChatServer\Logic\UserFdRelation;
use Swoole\WebSocket\Server;

$server = new Server('0.0.0.0', 9501);

$server->set([
    'heartbeat_check_interval' => 60,
    'heartbeat_idle_time' => 600,
]);

$server->on("workerstart", function (Server $server, $id) {
    $redis = new \Redis();
    $redis->pconnect('127.0.0.1', 6379);
    $server->redis = $redis;
});

$server->on('open', function (Server $server, $request) {
    echo '新连接：' . $request->fd . PHP_EOL;
});

$server->on('message', function (Server $server, $frame) {
    $userFdRelation = new UserFdRelation($server);

    // echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    // $server->push($frame->fd, "this is server");
    $data = json_decode($frame->data, true);

    switch ($data['type']) {
        case 'init':
            $userFdRelation->uidBindFd($data['uid'], $frame->fd);
            $userFdRelation->fdBindUid($frame->fd, $data['uid']);
            $fds = $userFdRelation->getFdsByUid($data['uid']);
            foreach ((array)$fds as $fd) {
                !$server->exist($fd) && $userFdRelation->delFd($fd, $data['uid']);
            }

            $server->push(
                $frame->fd,
                json_encode([
                    'status' => 1,
                    'msg' => '注册成功',
                ])
            );
            break;
        case 'message':
            $data['from'] = $userFdRelation->getUidByFd($frame->fd);
            // 验证是否已经注册
            if (!$data['from']) {
                $server->push(
                    $frame->fd,
                    json_encode([
                        'status' => 0,
                        'msg' => '发送失败，未登入',
                    ])
                );
                return;
            }

            // 将消息推送到uid各端
            $fds = $userFdRelation->getFdsByUid($data['to']);
            foreach ((array)$fds as $fd) {
                $server->exist($fd) && $server->push(
                    $fd,
                    json_encode([
                        'type' => 'message',
                        'status' => 1,
                        'content' => $data['content'],
                        'from' => $data['from'],
                    ])
                );
                echo "#{$fd} 推送成功\n";
            }

            // 告知推送成功
            // $server->push($frame->fd, json_encode(['status' => 1, 'message' => 'sent']));
            break;
        default:
            // 非法请求
            $server->push(
                $frame->fd,
                json_encode([
                    'status' => 0,
                    'msg' => '非法请求',
                    'disconnect' => 1, // 告知终端请断开
                ])
            );
            break;
    }
});

$server->on('close', function (Server $server, $fd) {
    echo "client {$fd} closed\n";
    $userFdRelation = new UserFdRelation($server);
    $userFdRelation->delFd($fd);
});

$server->start();
