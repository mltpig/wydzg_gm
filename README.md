# 我要当主公GM|数据库mysql|随记

http://server-work:81/svn/GameGroup3/配置表/叠Q__配置/主公3.0
http://server-work:81/svn/server/game/wydzg


Tips：https://config.shenzhenyuren.com/cleanCache
Tips：https://dev.shenzhenyuren.com/wydzg_wx_yfb/openServer?site=3&account=5xR4KC8mNE7iNY7zKHB6fjGkjn2tCy&pwd=sBT2fmf6FsT4PYnmYBD75KcfcFkCyGfMncYWBAF4
Tips：https://dev.shenzhenyuren.com/wydzg_jc_dev/openServer?site=8&account=5xR4KC8mNE7iNY7zKHB6fjGkjn2tCy&pwd=sBT2fmf6FsT4PYnmYBD75KcfcFkCyGfMncYWBAF4

1.登录服修改状态，禁止玩家再次登录
2.停止游戏服
3.数据库，代码备份
4.玩家数据入库
5.数据库再次备份
6.更新数据库表及代码
7.启动游戏服，修改预发布登录服，直连正式服
8.测试无误，修改配置数据库指向正式服登录服，清理缓存，修改登录服务状态
9.抓包确认一切无误

Tips：
ALTER TABLE player ADD INDEX idx_nickname(nickname);
UPDATE player SET magic = '[]';