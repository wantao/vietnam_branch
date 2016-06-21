/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.6
Source Server Version : 50162
Source Host           : 192.168.1.16:3306
Source Database       : z_all

Target Server Type    : MYSQL
Target Server Version : 50162
File Encoding         : 65001

Date: 2015-03-10 19:37:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tbl_notice`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_notice`;
CREATE TABLE `tbl_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area_ids` text CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL COMMENT '区号:0,表示所有区; 单个区a,; 多个区:a1,a2,',
  `title` text CHARACTER SET utf8 NOT NULL COMMENT '公告名称',
  `content` text CHARACTER SET utf8 COMMENT '公告内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_notice
-- ----------------------------
INSERT INTO `tbl_notice` VALUES ('8', ',0,', '[ff0000]抢先体验[-]', '[ff0000]1.修复bug[-]\r\n[ff0000]2.asdfasdfg[-]');
INSERT INTO `tbl_notice` VALUES ('9', ',1,2,3,', '[ff0000]清明活动[-]', '[ff0000]1.清明ss活动[-]\r\n[ff0000]1.清明sssfd活动[-]');
INSERT INTO `tbl_notice` VALUES ('10', ',1,2,3,', '[ff0000]补偿公告[-]', '[ff0000]1.补偿公告[-]\r\n[ff0000]2.补偿公告[-]');
