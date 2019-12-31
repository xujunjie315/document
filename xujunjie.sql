/*
 Navicat Premium Data Transfer

 Source Server         : 本机
 Source Server Type    : MySQL
 Source Server Version : 50712
 Source Host           : localhost:3306
 Source Schema         : xujunjie

 Target Server Type    : MySQL
 Target Server Version : 50712
 File Encoding         : 65001

 Date: 31/12/2019 18:14:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for fund
-- ----------------------------
DROP TABLE IF EXISTS `fund`;
CREATE TABLE `fund`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `code` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '编码',
  `type` enum('1','2','3','4') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '1:基金；2：指数；3：板块；4：股票',
  `status` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '0:无效；1：有效',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of fund
-- ----------------------------
INSERT INTO `fund` VALUES (1, '沪深300', '1B0300', '2', '1');
INSERT INTO `fund` VALUES (2, '深证成指', '399001', '2', '1');
INSERT INTO `fund` VALUES (3, '上证指数', '1A0001', '2', '1');

-- ----------------------------
-- Table structure for time
-- ----------------------------
DROP TABLE IF EXISTS `time`;
CREATE TABLE `time`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `time` date NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of time
-- ----------------------------
INSERT INTO `time` VALUES (1, '2017-04-20');
INSERT INTO `time` VALUES (2, '2017-07-20');
INSERT INTO `time` VALUES (3, '2017-10-20');
INSERT INTO `time` VALUES (4, '2018-01-20');
INSERT INTO `time` VALUES (5, '2018-04-20');
INSERT INTO `time` VALUES (6, '2018-07-20');
INSERT INTO `time` VALUES (7, '2018-10-20');
INSERT INTO `time` VALUES (8, '2019-01-20');
INSERT INTO `time` VALUES (9, '2019-04-20');
INSERT INTO `time` VALUES (10, '2019-07-20');
INSERT INTO `time` VALUES (11, '2019-10-20');
INSERT INTO `time` VALUES (12, '2020-01-20');
INSERT INTO `time` VALUES (13, '2020-04-20');
INSERT INTO `time` VALUES (14, '2020-07-20');
INSERT INTO `time` VALUES (15, '2020-10-20');

-- ----------------------------
-- Table structure for value
-- ----------------------------
DROP TABLE IF EXISTS `value`;
CREATE TABLE `value`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `fund_id` int(11) NOT NULL COMMENT '名称编号',
  `time_id` int(11) NOT NULL COMMENT '名称编号',
  `price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '价格',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
