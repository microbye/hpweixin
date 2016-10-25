<?php

namespace Addons\BookManage;
use Common\Controller\Addon;

/**
 * 书籍管理插件
 * @author microbye
 */

    class BookManageAddon extends Addon{

        public $info = array(
            'name'=>'BookManage',
            'title'=>'书籍管理',
            'description'=>'用来管理系统中的用户推荐的书本',
            'status'=>1,
            'author'=>'microbye',
            'version'=>'0.1',
            'has_adminlist'=>0
        );

	public function install() {
		$install_sql = './Addons/BookManage/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/BookManage/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }