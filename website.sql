CREATE TABLE `syy_admins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT, 
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理员账号状态 0：禁用 1：开启',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员表';

INSERT INTO `syy_admins` VALUES (1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1, 1642750967, 1642750967);

CREATE TABLE `syy_upload_file` (
  `file_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件id',
  `storage` tinyint(1) NOT NULL DEFAULT 0 COMMENT '存储方式 0：本地',
  `file_url` varchar(255) NOT NULL DEFAULT '' COMMENT '存储路径',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `file_size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小(字节)',
  `file_type` varchar(20) NOT NULL DEFAULT '' COMMENT '文件类型',
  `real_name` varchar(255) DEFAULT '' COMMENT '文件真实名',
  `extension` varchar(20) NOT NULL DEFAULT '' COMMENT '文件扩展名',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) unsigned DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`file_id`),
  UNIQUE KEY `path_idx` (`file_name`)
) ENGINE=MyISAM AUTO_INCREMENT=10566 DEFAULT CHARSET=utf8 COMMENT='文件库记录表';

CREATE TABLE `syy_staffs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT, 
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `account` varchar(50) NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理员账号状态 0：禁用 1：开启',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='员工表';

CREATE TABLE `syy_staff_articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT, 
  `staff_id` int(11) unsigned NOT NULL default 0 COMMENT '员工id',
  `content` text not null comment '文章内容',
  `status` tinyint(1) unsigned not null default '0' comment '0:待审核院内可见；1:院内外都可见',
  `author` varchar(20) not null default '' comment '作者',
  `title` varchar(30) not null default '' comment '文章标题',
  `count` int(11) not null default 0 comment '浏览次数',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='员工文章表';

CREATE TABLE `syy_briefs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT, 
  `content` text not null comment '文章内容',
  `status` tinyint(1) unsigned not null default '0' comment '0:待审核院内可见；1:院内外都可见',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='医院简介';

CREATE TABLE `syy_leaders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT, 
  `file_id` int(11) unsigned NOT NULL default 0 COMMENT '文件id',
  `name` varchar(20) not null default '' comment '姓名',
  `position` varchar(100) NOT NULL DEFAULT '' COMMENT '职务',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) unsigned not null default '0' comment '0:待审核院内可见；1:院内外都可见',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='领导团队';

CREATE TABLE `syy_cultures` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text not null comment '文章内容',
  `status` tinyint(1) unsigned not null default '0' comment '0:待审核院内可见；1:院内外都可见',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='医院文化';

CREATE TABLE `syy_historys` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '标题',
  `content` varchar(300) not null comment '内容',
  `status` tinyint(1) unsigned not null default '0' comment '0:待审核院内可见；1:院内外都可见',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='历史沿革';

CREATE TABLE `syy_organizations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` int(1) not null default 0 comment 'file_id',
  `status` tinyint(1) unsigned not null default '0' comment '0:待审核院内可见；1:院内外都可见',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='组织机构';

CREATE TABLE `syy_honors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text not null comment '内容',
  `status` tinyint(1) unsigned not null default '0' comment '0:待审核院内可见；1:院内外都可见',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='医院荣誉';

CREATE TABLE `syy_futures` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text not null comment '内容',
  `status` tinyint(1) unsigned not null default '0' comment '0:待审核院内可见；1:院内外都可见',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='未来展望';


