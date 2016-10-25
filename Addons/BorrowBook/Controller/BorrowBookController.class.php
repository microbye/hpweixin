<?php

namespace Addons\BorrowBook\Controller;
use Home\Controller\AddonsController;

class BorrowBookController extends AddonsController{
	function _initialize() {
		$act = strtolower ( CONTROLLER_NAME );
		$nav = array ();
		
		
		$res ['title'] = '已借出书籍';
		$res ['url'] = U ( 'booklist' );
		$res ['class'] = 'current';//'$act == 'bookmanage' ? 'current' : '';
		$nav [] = $res;
		
		$this->assign ( 'nav', $nav );
		//$_GET ['sidenav'] = 'home_creditconfig_lists';
	}
	
	//读取已经推荐并且首页显示的书本列表并且分页
	public function booklist(){
		$top_more_button [] = array (
				'title' => '导入数据',
				'url' => U ( 'import' ) 
		);
		
		$this->assign ( 'top_more_button', $top_more_button );
		//dump($_REQUEST);
		//获取书本的模型
		$book=M("borrowed_books");
		$count = $book->field(true)->count(); //查询满足要求的总记录数
		$p=new \Think\Page($count,20);//// 实例化分页类 传入总记录数和每页显示的记录数

		//获取到已经借出的书本的id，借出时间
		
		$list=$book->field(true)->order('id desc')->limit($p->firstRow,$p->listRows)->select();
		//根据id获取到借出书本的基本信息
		
	   	foreach ($list as $k => $v){		
		//获取书本的基本信息
			$data = M('books')->where('id = '.$list[$k]['book_id'])->find();
			//$list[$k]['id'] = $data['id']
			$list[$k]['ownner'] = $data['ownner'];
			$list[$k]['nickname'] = $data['nickname'];
			$list[$k]['name'] = $data['name'];
			$list[$k]['writer'] = $data['writer'];
			if($list[$k]['ownner']==0){
				$list[$k]['nickname'] = "三楼阅览室";
				$list[$k]['kind'] ="暂无";
				if($list[$k]['writer'] == null)
					$list[$k]['writer']="未知";
			}
			else{
				$user = D ( 'Common/User' )->getUserInfo ( $data['ownner'], true );
				$list[$k]['nickname'] = $user['nickname'];
				$list[$k]['kind'] = M("kind_book")->where("id=".$data['kind'])->getField("kind");
				if($list[$k]['writer']==""){
					$list[$k]['writer']="未知";
				}
				else{
					$list[$k]['writer'] = $data['writer'];
				}
			}	
			$list[$k]['create_time'] = date("Y-m-d H:i:s",$list[$k]['borrow_time'] );
		}
		//list中保存了书本的基本信息现在需要把书本中的来源id换成作者昵称，书的种类id换成种类名字
		//设置分页显示
		$this->assign('list',$list);// 赋值数据集
		//$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$p->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
		$show = $p->show();// 分页显示输出
		$this->assign('p',$show);// 赋值分页输出
		$this->display ();
	}
	//更改书本状态为可借
	function restoreBook(){
		$bookid = $_GET['id'];
		//根据这个id删除书本,并且将另一本书的状态设置为可以获取		
		if(M('borrowed_books')->where('book_id = '.$bookid)->delete()){
			M('books')->where('id = '.$bookid)->setField('available',1);
		}
		else{
			return false;
		}
	}
	
	//批量更改书本状态为可借
	function restoreByChoose(){	
		//获取书本id
		$ids = I('ids');
		if($ids == null){
			$this->error('请选择要操作的书籍');
		}
		else{
			$where = array('book_id'=>array('in',$ids));
			$books = array('id'=>array('in',$ids));
			if(M('borrowed_books')->where($where)->delete()){
				//foreach($ids as $k=>$v){
					//M('books')->where('$id = '.$ids[$k])->setField('available',1);
				//}
				M('books')->where($books)->setField('available',1);
				$this->success("已经还原！");	
			}
			else{
				$this->error('还原失败！');
			}
		}
	}
}
