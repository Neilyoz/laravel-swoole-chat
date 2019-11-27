<?php

namespace ChatServer\Logic;

use Exception;

class UserFdRelation
{
    private $redis;

    const MAP_UID_FD_PREFIX = 'chat_map_uid_fd:';
    const MAP_FD_UID_PREFIX = 'chat_map_fd_uid:';

    public function __construct($server)
    {
        $this->redis = $server->redis;
    }

    // fd与uid对应
    public function fdBindUid($fd, $uid)
    {
        return $this->redis->setex(
            self::MAP_FD_UID_PREFIX . $fd,
            24 * 3600,
            $uid
        );
    }

    // 获取fd对应的uid
    public function getUidByFd($fd)
    {
        return $this->redis->get(self::MAP_FD_UID_PREFIX . $fd);
    }

    public function uidBindFd($uid, $fd)
    {
        return $this->redis->sadd(
            self::MAP_UID_FD_PREFIX . $uid,
            $fd
        );
    }

    // 获取uid全部fd，确保多端都能收到信息
    public function getFdsByUid($uid)
    {
        return $this->redis->sMembers(self::MAP_UID_FD_PREFIX . $uid);
    }

    // 删除uid的某个fd
    public function delFd($fd, $uid = null)
    {
        if (is_null($uid)) {
            $uid = $this->getUidByFd($fd);
        }

        if (!$uid) {
            return false;
        }

        $this->redis->srem(self::MAP_UID_FD_PREFIX . $uid, $fd);
        $this->redis->del(self::MAP_FD_UID_PREFIX . $fd);

        return true;
    }
}
