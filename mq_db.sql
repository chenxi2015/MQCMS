/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80017
 Source Host           : localhost:3306
 Source Schema         : mq_db

 Target Server Type    : MySQL
 Target Server Version : 80017
 File Encoding         : 65001

 Date: 22/11/2019 18:11:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for mq_attachment
-- ----------------------------
DROP TABLE IF EXISTS `mq_attachment`;
CREATE TABLE `mq_attachment`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `attach_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '附件地址',
  `user_id` int(11) NULL DEFAULT NULL COMMENT '附件上传的用户id',
  `attach_type` tinyint(1) NULL DEFAULT NULL COMMENT '附件类型 1：图片 2：视频',
  `created_at` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '附件表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mq_post
-- ----------------------------
DROP TABLE IF EXISTS `mq_post`;
CREATE TABLE `mq_post`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '内容',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '发布者id',
  `link_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '发布内容绑定的id',
  `relation_tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '关联标签 标签1,标签2...',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '地址',
  `address_lat` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '地址纬度',
  `address_lng` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '地址经度',
  `attach_urls` json NULL COMMENT '附件列表',
  `is_publish` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否发布 1：发布 0：未发布（草稿）',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态 1：正常 0：删除',
  `is_recommend` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否推荐 1：推荐 0：正常',
  `created_at` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '内容（帖子）表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mq_tag
-- ----------------------------
DROP TABLE IF EXISTS `mq_tag`;
CREATE TABLE `mq_tag`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_hot` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否热门 0：正常 1：热门',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态 1：正常 0：禁用（删除）',
  `first_create_user_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '第一个创建的人的用户id',
  `used_count` int(11) UNSIGNED NOT NULL DEFAULT 1 COMMENT '被使用的次数',
  `created_at` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '标签表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mq_user
-- ----------------------------
DROP TABLE IF EXISTS `mq_user`;
CREATE TABLE `mq_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_no` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '唯一id号',
  `user_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '用户名',
  `real_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '真实姓名',
  `phone` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '手机号',
  `avatar` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '头像',
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `salt` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码加盐',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态 1：正常 2：禁用',
  `register_time` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '注册时间',
  `register_ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '注册ip',
  `login_time` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '登录时间',
  `login_ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '登录ip',
  `created_at` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mq_user_auth
-- ----------------------------
DROP TABLE IF EXISTS `mq_user_auth`;
CREATE TABLE `mq_user_auth`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `oauth_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '第三方 uid 、openid 等',
  `unionid` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'QQ / 微信同一主体下 Unionid 相同',
  `auth_type` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '登录类型 email phone weibo username weixin',
  `credential` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码凭证 /access_token (目前更多是存储在缓存里)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户第三方登录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mq_user_collect
-- ----------------------------
DROP TABLE IF EXISTS `mq_user_collect`;
CREATE TABLE `mq_user_collect`  (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) UNSIGNED NOT NULL,
  `created_at` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mq_user_follow
-- ----------------------------
DROP TABLE IF EXISTS `mq_user_follow`;
CREATE TABLE `mq_user_follow`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `post_id` int(11) NULL DEFAULT NULL COMMENT '帖子id',
  `is_comment` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否评论 1：评论 0：未评论',
  `is_like` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否点赞 1：点赞 0：未点赞',
  `is_collect` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否收藏 1：已收藏 0：未收藏',
  `created_at` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mq_user_info
-- ----------------------------
DROP TABLE IF EXISTS `mq_user_info`;
CREATE TABLE `mq_user_info`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `intro` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '简介',
  `like_num` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '获赞数',
  `follow_num` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '关注数',
  `fans_num` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '粉丝数',
  `post_num` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '发帖数',
  `my_like_num` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mq_user_like
-- ----------------------------
DROP TABLE IF EXISTS `mq_user_like`;
CREATE TABLE `mq_user_like`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `post_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '帖子id',
  `created_at` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
