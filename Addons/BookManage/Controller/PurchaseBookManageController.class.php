<?php

namespace Addons\BookManage\Controller;
use Home\Controller\AddonsController;

class PurchaseBookManageController extends AddonsController{
	function _initialize() {
		$act = strtolower ( CONTROLLER_NAME );
		$nav = array ();
		
		
		$res ['title'] = '已审核书籍';
		$res ['url'] = "index.php?s=/addon/BookManage/BookManage/bookList";
		$res ['class'] = $act == 'books' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '未审核书籍';
		$res ['url'] = "index.php?s=/addon/BookManage/AdviseBookManage/bookList";
		$res ['class'] =  $act == 'books' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '增书请求';
		$res ['url'] = "index.php?s=/addon/BookManage/AddBookManage/bookList";
		$res ['class'] = $act == 'books' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '预购书籍';
		$res ['url'] = "index.php?s=/addon/BookManage/PurchaseBookManage/bookList";
		$res ['class'] = 'current';// $act == 'bookmanage' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '已购书籍';
		$res ['url'] = "index.php?s=/addon/BookManage/PurchasedBookManage/bookList";
		$res ['class'] = $act == 'bookmanage' ? 'current' : '';
		$nav [] = $res;
		$this->assign ( 'nav', $nav );
		
		//$_GET ['sidenav'] = 'home_creditconfig_lists';
	}
	
	//读取已经推荐并且首页显示的书本列表并且分页
	public function bookList(){
		$top_more_button [] = array (
				'title' => '导入数据',
				'url' => U ( 'import' ) 
		);
		
		$this->assign ( 'top_more_button', $top_more_button );
		
		//dump($_REQUEST);
		//获取书本的模型
		$book=M("purchasebooks");
		$count  = $book->field(true)->where('state =0')->count(); //查询满足要求的总记录数
		$p=new \Think\Page($count,20);//// 实例化分页类 传入总记录数和每页显示的记录数

		
		$list=$book->field(true)->where('state =0')->order('id desc')->limit($p->firstRow,$p->listRows)->select();
		//dump($list)  ;
	   	foreach ($list as $k => $v){		
		//获取书本的基本信息
			
			if($list[$k]['userid']==0){
				$list[$k]['nickname'] = "三楼阅览室";
				$list[$k]['kind'] ="暂无";
				if($list[$k]['writer'] == null)
					$list[$k]['writer']="未知";
			}
			else{
				$user = D ( 'Common/User' )->getUserInfo ( $list[$k]['userid'], true );
				$list[$k]['nickname'] = $user['nickname'];
				$list[$k]['kind'] = M("kind_book")->where("id=".$list[$k]['kind'])->getField("kind");
				if($list[$k]['writer']==""){
					$list[$k]['writer']="未知";
				}
			}	
			$list[$k]['create_time'] = date("Y-m-d H:i:s",$list[$k]['create_time'] );
		}
		//list中保存了书本的基本信息现在需要把书本中的来源id换成作者昵称，书的种类id换成种类名字
		//设置分页显示
		$this->assign('list',$list);// 赋值数据集
		//$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$p->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		//dump($list);
		$show = $p->show();// 分页显示输出
		$this->assign('p',$show);// 赋值分页输出
		$this->display (ONETHINK_ADDON_PATH . 'BookManage/View/default/PurchaseBookManage/booklist.html');
	}
	//删除书本
	function delbook(){
		$bookid = $_GET['id'];
		//根据这个id删除书本
		
		if(M('purchasebooks')->where('id = '.$bookid)->delete()){
			return true;
		}
		else{
			return false;
		}
	}
	
	//批量删除
	function delByChoose(){
		
		$ids = I('ids');
		if($ids ==null){
			$this->error('请选择要操作的书籍');
		}
		else{
			$where = array('id'=>array('in',$ids));
			
			if(M('purchasebooks')->where($where)->delete()){
				$this->success("已经删除！");
			}
			else{
				$this->error('删除失败！');
			}
		}
	}
	
	
	
	//将书籍标记为已购
	function agreePurchase(){
		$ids = I('ids');
		if($ids ==null){
			$this->error('请选择要操作的书籍');
		}
		else{
			//获取到需要更变状态的书籍
			$where = array('id'=>array('in',$ids));
			foreach($ids as $id =>$v){
				
				$mark = M('purchasebooks')->where('id = '.$ids[$id])->setField('state',1);
				if(!$mark){
					$this->error('加入已购书单失败！');
				}
			}
			$this->success("已经加入已购书单");			
		}
	}	
}
