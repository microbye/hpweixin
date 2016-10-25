<?php

namespace Addons\BorrowBook;
use Common\Controller\Addon;

/**
 * 借书插件
 * @author microbye
 */

    class BorrowBookAddon extends Addon{

        public $info = array(
            'name'=>'BorrowBook',
            'title'=>'借书',
            'description'=>'完成借书',
            'status'=>1,
            'author'=>'microbye',
            'version'=>'0.1',
            'has_adminlist'=>0
        );

	public function install() {
		$install_sql = './Addons/BorrowBook/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/BorrowBook/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }