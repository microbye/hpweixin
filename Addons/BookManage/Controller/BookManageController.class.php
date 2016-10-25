<?php

namespace Addons\BookManage\Controller;
use Home\Controller\AddonsController;

class BookManageController extends AddonsController{
	function _initialize() {
		$act = strtolower ( CONTROLLER_NAME );
		$nav = array ();
		
		
		$res ['title'] = '已审核书籍';
		$res ['url'] = U ( 'bookList' );
		$res ['class'] = 'current';//'$act == 'bookmanage' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '未审核书籍';
		$res ['url'] = "index.php?s=/addon/BookManage/AdviseBookManage/bookList";
		$res ['class'] = $act == 'books' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '增书请求';
		$res ['url'] = "index.php?s=/addon/BookManage/AddBookManage/bookList";
		$res ['class'] = $act == 'books' ? 'current' : '';
		$nav [] = $res;
		
		$res ['title'] = '预购书籍';
		$res ['url'] = "index.php?s=/addon/BookManage/PurchaseBookManage/bookList";
		$res ['class'] = $act == 'bookmanage' ? 'current' : '';
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
		$book=M("books");
		$count  = $book->field(true)->count(); //查询满足要求的总记录数
		$p=new \Think\Page($count,20);//// 实例化分页类 传入总记录数和每页显示的记录数

		
		$list=$book->field(true)->order('id desc')->limit($p->firstRow,$p->listRows)->select();
		//dump($list)  ;
	   	foreach ($list as $k => $v){		
		//获取书本的基本信息
			
			if($list[$k]['ownner']==0){
				$list[$k]['nickname'] = "三楼阅览室";
				$list[$k]['kind'] ="暂无";
				if($list[$k]['writer'] == null)
					$list[$k]['writer']="未知";
			}
			else{
				$user = D ( 'Common/User' )->getUserInfo ( $list[$k]['ownner'], true );
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
		$show = $p->show();// 分页显示输出
		$this->assign('p',$show);// 赋值分页输出
		$this->display ();
	}
	//删除书本
	function delbook(){
		$bookid = $_GET['id'];
		//根据这个id删除书本
		
		if(M('books')->where('id = '.$bookid)->delete()){
			return true;
		}
		else{
			return false;
		}
	}
	
	//批量删除
	function delByChoose(){
		//books 是根据id排列的数组，现在需要批量删除。
		//$ids = $_POST['ids'];
		$ids = I('ids');
		if($ids ==null){
			$this->error('请选择要操作的书籍');
		}
		else{
			$where = array('id'=>array('in',$ids));
			
			if(M('books')->where($where)->delete()){
				$this->success("已经删除！");
			}
			else{
				$this->error('删除失败！');
			}
		}
	}
	
	//编辑书本页面
	function editbook(){
		$id = $_GET['id'];
		$book = M("books")->where("id=".$id)->limit(1)->find();
		if($book == null){
			$this->error ( '数据不存在！' );
		}
		else{
			if($book['ownner']==0){
				$book['nickname'] = "三楼阅览室";
				$book['kind'] ="暂无";
				$book['writer']="未知";
			}
			else{
				$user = D ( 'Common/User' )->getUserInfo ( $book['ownner'], true );
				$book["nickname"] = $user["nickname"];
				$book["ownner"] = $user["uid"];
				$book["kind"] = M("kind_book")->where("id=".$book["kind"])->getField("kind");
			}
		
			$data = M("kind_book")->select();
			$this->assign("data",$data);
			$this->assign("book",$book);
		}	
		$this->display();
	}
	//保存书本信息
	function updateBook(){
		$id = $_GET['id'];
		$kind = $_POST['kind'];
		if(M("books")->where("id=".$id)->limit(1)->find()){
			$book['id'] = $id;
			$book['kind'] = M('kind_book')->where("kind = '".$kind."'")->getField('id');
			$book['writer']=$_POST['writer'];
			$book['description'] = $_POST['description'];
			$book['name'] = $_POST['name'];
			$book['available'] = $_POST['available'];
			if(M('books')->save($book)){
				$this->success ( '保存书本成功！', U('bookList'));
			}
			else{
				$this->error("保存失败");
			}
			
		}
		else{
			$this->error("保存失败");
		}
		
	}
	
	//增加书本页面
	function addbook(){
		
		$data = M("kind_book")->select();
		$this->assign("data",$data);
		$this->display();
	}
	//新增书籍
	function add(){
		$kind = $_POST['kind'];
		$book['kind'] = M('kind_book')->where("kind = "."'".$kind."'")->getField('id');
		$book['create_time'] = time();
		$book['writer']=$_POST['writer'];
		$book['description'] = $_POST['description'];
		$book['name'] = $_POST['name'];
		$book['available'] = $_POST['available'];
		
		if(M("books")->where("name='".$book['name']."'and writer = '".$book['writer']."'")->find()){
			$this->error("增加失败,已存在同名书籍");
		}
		else{
			if(M('books')->add($book)){
				$this->success("增加成功",U('bookList'));
			}
			else{
				$this->error("增加失败");
			}
		}
	}
	
	public function import(){
		
	}
}
