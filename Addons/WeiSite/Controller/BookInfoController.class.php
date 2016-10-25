<?php

namespace Addons\WeiSite\Controller;

use Addons\WeiSite\Controller\BaseController;

class BookInfoController extends BaseController {
	function config() {
		$public_info = get_token_appinfo ();
		$normal_tips = '在微信里回复“微官网”即可以查看效果,也可以点击：<a href="' . addons_url ( 'WeiSite://WeiSite/index', array (
				'publicid' => $public_info ['id'] 
		) ) . '">预览</a>， <a id="copyLink" data-clipboard-text="' . addons_url ( 'WeiSite://WeiSite/index', array (
				'publicid' => $public_info ['id'] 
		) ) . '">复制链接</a><script type="application/javascript">$.WeiPHP.initCopyBtn("copyLink");</script>';
		$this->assign ( 'normal_tips', $normal_tips );
		
		$config = D ( 'Common/AddonConfig' )->get ( _ADDONS );
		// dump(_ADDONS);
		if (IS_POST) {
			$_POST ['config'] ['background'] = implode ( ',', $_POST ['background'] );
			// $config = array_merge ( ( array ) $config, ( array ) $_POST ['config'] );
			$flag = D ( 'Common/AddonConfig' )->set ( _ADDONS, $_POST ['config'] );
			if ($flag !== false) {
				if ($_GET ['from'] == 'preview') {
					$url = U ( 'preview' );
				} else {
					$url = Cookie ( '__forward__' );
				}
				$this->success ( '保存成功', $url );
			} else {
				$this->error ( '保存失败' );
			}
			exit ();
		}
		$config ['background_arr'] = explode ( ',', $config ['background'] );
		$config ['background'] = $config ['background_arr'] [0];
		$this->assign ( 'data', $config );
		$this->display ();
	}

	//用户点赞
	function zan(){				
		//如果用户点赞那么直接将文章赞数加1，不限制点赞数，如果需要限制点赞数可以通过ip或者用户的openid来进行限制。
		$book['zan'] = $_POST['vl'];
		$book['id'] = $_POST['book_id'];
		$A = M('books');//->where($article)->find();
		//$A->zan = $_POST['vl'];
		$A->save($book);
		//获取书本的拥有者
		$ownner = M('books')->where('id = '.$book['id'])->getField('ownner');
		
		$data['book_id'] = $_POST['book_id'];
		$data['uid'] = $_POST['uid'];
		//$data['state'] = $_POST['state'];
		$Zan = M('book_zan');
		//   先判断用户是否已经点过赞，如果点过赞，那么不需要新增数据。直接将state变为新的state
		if($Zan->where($data)->find()){
			$Zan->where($data)->setField("state",$_POST['state']);
			$data['state'] = $_POST['state'];
			/*用户积分增加*/
			if($data['state'] == 1 && $ownner !=0){
				//获取书主人的uid
				
				$credit['uid'] = $ownner;
				$credit['cTime'] = time();
				$credit['experience'] = 1;	
				$credit['score'] =5; 
				$credit['credit_name'] = 'zan';
				$credit['credit_title'] = '点赞';				
				$credit['admin_uid'] = 0;
				$credit['token'] = get_token();
				D("Common/Credit")->addCredit($credit);
			}
			else if($data['state'] == 0 && $ownner !=0){
				$credit['uid'] = $ownner;
				$credit['cTime'] = time();
				$credit['experience'] = -1;	
				$credit['score'] = -5; 
				$credit['credit_name'] = 'cancel_zan';
				$credit['credit_title'] = '取消点赞';				
				$credit['admin_uid'] = 0;
				$credit['token'] = get_token();
				D("Common/Credit")->addCredit($credit);
			}
		}
		else{
			$data['state'] = $_POST['state'];
			$Zan->add($data);
			/*用户积分增加*/
			if($data['state'] == 1 && $ownner !=0){
				//获取书主人的uid
				
				$credit['uid'] = $ownner;
				$credit['cTime'] = time();
				$credit['experience'] = 1;	
				$credit['score'] =5; 
				$credit['credit_name'] = 'zan';
				$credit['credit_title'] = '点赞';				
				$credit['admin_uid'] = 0;
				$credit['token'] = get_token();
				D("Common/Credit")->addCredit($credit);
			}
			else if($data['state'] == 0 && $ownner !=0){
				$credit['uid'] = $ownner;
				$credit['cTime'] = time();
				$credit['experience'] = -1;	
				$credit['score'] = -5; 
				$credit['credit_name'] = 'cancel_zan';
				$credit['credit_title'] = '取消点赞';				
				$credit['admin_uid'] = 0;
				$credit['token'] = get_token();
				D("Common/Credit")->addCredit($credit);
			}
		}
		$data['status'] = 1;
		$data['info'] = 'info'.$data['state'];
		$this->ajaxReturn($data,'JSON');       
	}	
	
	
	//分页显示书籍信息，将数据库中的书籍分页显示,默认从数据看中提取推荐书籍
	function bookList($pagesize = 6){
		$source = $_GET['source'];
		$kinds = $_GET['kinds'];
		$book=M("books");
		$openid =get_openid();
		//$count = $book->count();//连惯操作后会对join等操作进行重置
		//根据source 和kinds 参数获取书本的列表
		/*根据种类和来源进行查找返回书本列表
		默认返回全部种类
		1.来源为0 ，表示图书馆
		其他为个人
		*/
		$p=new \Think\Page($count,$pagesize);//// 实例化分页类 传入总记录数和每页显示的记录数
		//根据source进行判断，如果source 为0 表示用户希望看到图书馆的书籍，图书馆的书籍没有分类
		if($source == -1 & $kinds == 0){
			$list=$book->field(true)->order('id desc')->limit($p->firstRow,$p->listRows)->select();	
		}
		else if($source == -1 & $kinds != 0){
			$list=$book->where("kind = ".$kinds)->field(true)->order('id desc')->limit($p->firstRow,$p->listRows)->select();	
		}
		else if($source == 0){
			$list=$book->where("kind = 0 and ownner = 0")->field(true)->order('id desc')->limit($p->firstRow,$p->listRows)->select();
		}
		else if($source == 1){
			if($kinds == 0){
				$list=$book->where("ownner != 0")->field(true)->order('id desc')->limit($p->firstRow,$p->listRows)->select();
			}
			else{
				$list=$book->where("ownner !=0 and kind = ".$kinds)->field(true)->order('id desc')->limit($p->firstRow,$p->listRows)->select();
			}			
		}
		//dump($list)  ;
	   	foreach ($list as $k => $v){		
		//获取书本的基本信息
			
			if($list[$k]['ownner']==0){
				$list[$k]['nickname'] = "三楼阅览室";
				$list[$k]['kind'] ="暂无";
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
			//获取书本的点赞状态
			$zan['uid'] = M("public_follow")->where("openid="."'".$openid."'")->getField("uid");
			$zan['book_id'] = $list[$k]['id'];
			$zan['state'] = 1;
			$list[$k]['state'] = 1;
			if( M("book_zan")->where($zan)->find()){
				$list[$k]['state'] = 1;
			}
			else{
				$list[$k]['state'] = 0;
			}					
		}
		//list中保存了书本的基本信息现在需要把书本中的来源id换成作者昵称，书的种类id换成种类名字
		//设置分页显示
		//dump($list);
		$userid = M("public_follow")->where("openid="."'".$openid."'")->getField("uid");
		$data = M("kind_book")->select();
		$this->assign("mark",0);
		$this->assign("page",1);
		$this->assign('data',$data);
		$this->assign("source",$source);
		$this->assign("kinds",$kinds);
		$this->assign('list',$list);// 赋值数据集
		$this->assign('userid',$userid);	
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/booklist.html' );
	}
	
	//ajax 滑动到底部返回下一页的数据
	function getMoreBooks(){
		//获取post过来的数据
		$kinds = $_POST['kinds'];
		$page = $_POST['page'];
		$source = $_POST['source'];
		$count = 0;
		$list['mark'] = 0;
		$book=M("books");
		//根据种类和来源获取书单
		if($source == -1 & $kinds == 0){
			$count = $book->field(true)->order('id desc')->count();	
			$list = $book->field(true)->order('id desc')->limit($page*6,6)->select();				
		}
		else if($source == -1 & $kinds != 0){
			$count = $book->where("kind = ".$kinds)->field(true)->order('id desc')->count();	
			$list=$book->where("kind = ".$kinds)->field(true)->order('id desc')->limit($page*6,6)->select();	
		}
		else if($source == 0){
			$count = $book->where("kind = 0 and ownner = 0")->field(true)->order('id desc')->count();	
			$list=$book->where("kind = 0 and ownner = 0")->field(true)->order('id desc')->limit($page*6,6)->select();
		}
		else if($source == 1){
			if($kinds == 0){
				$count = $book->where("ownner != 0")->field(true)->order('id desc')->count();	
				$list=$book->where("ownner != 0")->field(true)->order('id desc')->limit($page*6,6)->select();
			}
			else{
				$count = $book->where("ownner !=0 and kind = ".$kinds)->field(true)->order('id desc')->count();	
				$list=$book->where("ownner !=0 and kind = ".$kinds)->field(true)->order('id desc')->limit($page*6,6)->select();
			}			
		}
		//判断书本列表是否加载到底了
		if(($count - $page*6) <= 0){
				$list['mark'] = 1;
			}
			else{
				$list['mark'] = 0;
		}
		
		foreach ($list as $k => $v){		
		//获取书本的基本信息
			
			if($list[$k]['ownner']==0){
				$list[$k]['nickname'] = "三楼阅览室";
				$list[$k]['kind'] ="暂无";
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
			//获取书本的点赞状态
			$openid = get_openid();
			$zan['uid'] = M("public_follow")->where("openid="."'".$openid."'")->getField("uid");
			$zan['book_id'] = $list[$k]['id'];
			$zan['state'] = 1;
			//$list[$k]['state'] = 1;
			if( M("book_zan")->where($zan)->find()){
				$list[$k]['state'] = 1;
			}
			else{
				$list[$k]['state'] = 0;
			}
		}
		$page++;
		$list['page'] = $page;
		$list['source'] = $source;
		$list['status'] = 1;
		$list['info'] = "大侠，您怎么什么都没写啊？";
		$this->ajaxReturn($list,'JSON');
	}
	
	
	function search(){
		//dump(get_openid());
		//进行搜索是传入的参数书名，查找思路是进行全库的模糊查询
		$openid = get_openid();
		$pagesize = 6;
		$book = M("books");
		$keywords = '%'.$_POST['key'].'%';  //获取搜索关键字 
		$where['name|description|writer'] = array('like',$keywords);  //用like条件搜索title和content两个字段 
		$count = M('books')->where($where)->count();
		if($count<=6)
			$mark = 1;
		else
			$mark = 0;
		$p=new \Think\Page($count,$pagesize);
		$list = M('books')->where($where)->order('id desc')->limit($p->firstRow,$p->listRows)->select();				
		foreach ($list as $k => $v){			
			if($list[$k]['ownner']==0){
				$list[$k]['nickname'] = "三楼阅览室";
				$list[$k]['kind'] ="暂无";
				$list[$k]['writer']="未知";
			}
			else{
				$user = D ( 'Common/User' )->getUserInfo ( $list[$k]['ownner'], true );//M("user")->where(" uid = ".$list[$k]['ownner'])->getField("nickname");
				$list[$k]['nickname'] = $user['nickname'];
				$list[$k]['kind'] = M("kind_book")->where("id=".$list[$k]['kind'])->getField("kind");
				if($list[$k]['writer']==""){
					$list[$k]['writer']="未知";
				}
			}
			//获取书本的点赞状态
			$zan['uid'] = M("public_follow")->where("openid="."'".$openid."'")->getField("uid");
			$zan['book_id'] = $list[$k]['id'];
			$zan['state'] = 1;
			$list[$k]['state'] = 1;
			if( M("book_zan")->where($zan)->find()){
				$list[$k]['state'] = 1;
			}
			else{
				$list[$k]['state'] = 0;
			}	
		}
		//dump($mark);
		$key = $_POST['key'];
		$userid = M("public_follow")->where("openid="."'".$openid."'")->getField("uid");
		$this->assign('mark',$mark);
		$this->assign('list',$list);// 赋值数据集
		$this->assign('userid',$userid);
		$this->assign('key',$key);	
		if($count==0){
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/noresult.html' );
		}
		else{
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/searchlist.html' );
		}
	}
	//加载更多搜索结果：
	
	function getMoreSearchList(){
		//获取post过来的数据
		$keywords = '%'.$_POST['key'].'%';  //获取搜索关键字
		$page = $_POST['page'];
		$count = 0;
		$list['mark'] = 0;
		$book=M("books");
		$where['name|description|writer'] = array('like',$keywords);  //用like条件搜索title和content两个字段 
		$count = M('books')->where($where)->count();
		$p=new \Think\Page($count,$pagesize);
		$list = M('books')->where($where)->order('id desc')->limit($page*6,6)->select();
		//判断书本列表是否加载到底了
		if(($count - $page*6) <= 0){
				$list['mark'] = 1;
			}
			else{
				$list['mark'] = 0;
		}		
		foreach ($list as $k => $v){		
		//获取书本的基本信息
			
			if($list[$k]['ownner']==0){
				$list[$k]['nickname'] = "三楼阅览室";
				$list[$k]['kind'] ="暂无";
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
			//获取书本的点赞状态
			$openid = get_openid();
			$zan['uid'] = M("public_follow")->where("openid="."'".$openid."'")->getField("uid");
			$zan['book_id'] = $list[$k]['id'];
			$zan['state'] = 1;
			//$list[$k]['state'] = 1;
			if( M("book_zan")->where($zan)->find()){
				$list[$k]['state'] = 1;
			}
			else{
				$list[$k]['state'] = 0;
			}
		}		
		$page++;
		$list['page'] = $page;
		$list['status'] = 1;
		$list['info'] = "大侠，您怎么什么都没写啊？";
		$this->ajaxReturn($list,'JSON');
		
	}
	//显示书籍详情页面
	function info(){		
		$id = $_GET["id"];
		$book = M("books")->where("id=".$id)->limit(1)->find();
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
		
		$openid = get_openid();
		$zan['uid'] = M("public_follow")->where("openid="."'".$openid."'")->getField("uid");
		$zan['book_id'] = $book['id'];
		$zan['state'] = 1;
		if( M("book_zan")->where($zan)->find()){
			$this->assign("zan",$zan);
			}
		else{
			$zan['state'] = 0;
			$this->assign("zan",$zan);
		}
		//dump($zan);
		$userid = M("public_follow")->where("openid = "."'".$openid."'")->getField("uid");
		//dump($book);
		//dump($userid);
		M ('books')->where ("id=".$id)->setInc ('view_count');
		/*获取评论列表，默认获取前4条，每一页有4条评论。评论的条数有以下几种情况
		4条以下：输出，并且输出评论已经结束的标志位：mark = 1；表示没有评论了，前台加载的时候根据这个标记选择不加载。并且输出评论加载完毕
		4条以上：分页，输出页码1，mark = 0，表四还可以继续加载。
		1.留言内容
		2.留言时间
		3.留言的用户的基本信息
		*/
		$message_list = M('book_comment')->where("bookid = ".$id)->limit(4)->order('create_time desc')->select();
		$message_count = M('book_comment')->where("bookid = ".$id)->count();
		
		if($message_count<=4){
			$mark = 1;
			$this->assign("mark",$mark);
		}
		else{
			$mark = 0;
			$this->assign("mark",$mark);
		}
		foreach ($message_list as $k => $v){			
			$message_list[$k]['create_time'] =  date("Y-m-d H:i:s",$message_list[$k]['create_time'] );
			//获取用户昵称和头像：
			if($message_list[$k]['userid']==0){
				$message_list[$k]['nickname'] = "游客";
			}
			else{
				$user = D( 'Common/User' )->getUserInfo ( $message_list[$k]['userid'], true );
				$message_list[$k]['nickname']=$user['nickname'];
				$message_list[$k]['headimgurl'] = $user['headimgurl'];
				//dump($user);
			}
		}
		//dump($message_list);
		$this->assign("message_count",$message_count);
		$this->assign("message_list",$message_list);
		$this->assign("userid",$userid);
		$this->assign("book",$book);
		$this->display( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/info.html' );
	}
	
	function borrow(){
		$data["ownner"] = $_GET['ownner']; //书主的id
		$data["book"] = $_GET['book'];//书本名字
		$data["bookid"] = $_GET['bookid'];//书本id
		$data["userid"] = $_GET['userid']; //借书人id
		$user = D ( 'Common/User' )->getUserInfo ( $data['userid'], true ); //获取借书人的昵称
		//查询本条记录是否已经回复过了：
		$record = $data['ownner'].$data['bookid'].$data['userid'];
		$list = M("borrow_apply")->where("record = ".$record)->find();
		if($list['state'] ==1){
			$this->display( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/borrowed.html' );
		}
		else{
			$this->assign("user",$user);
			$this->assign("data",$data);
			$this->display( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/borrow.html' );
		}
	}
	
	function getMessage(){
		//获取post过来的数据
		$bookid = $_POST['bookid'];
		$page = $_POST['page'];
		
		//通过页码和书的id查找评论：
		$data = M('book_comment')->where("bookid = ".$bookid)->limit($page*4,4)->order('create_time desc')->select();
		$count = M('book_comment')->where("bookid = ".$bookid)->count();
		if(($count - $page*4) <= 0){
			$data['mark'] = 1;
		}
		else{
			$data['mark'] = 0;
		}
		
		foreach ($data as $k => $v){			
			$data[$k]['create_time'] =  date("Y-m-d H:i:s",$data[$k]['create_time'] );
			//获取用户昵称和头像：
			if($data[$k]['userid']==0){
				$data[$k]['nickname'] = "游客";
			}
			else{
				$user = D( 'Common/User' )->getUserInfo( $data[$k]['userid'], true );
				$data[$k]['nickname']=$user['nickname'];
				$data[$k]['headimgurl'] = $user['headimgurl'];
				//dump($user);
			}
		}
		$page++;
		$data['page'] = $page;
		$data['status'] = 1;
		$data['info'] = "大侠，您怎么什么都没写啊？";
		//$data = json_encode($data);
		$this->ajaxReturn($data,'JSON');
	}
	
	function feedback(){
		$data['userid'] = $_GET['userid'];
		//dump($data);
		$this->assign("data",$data);
		$this->display(ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/feedback.html' );
	}
	
	function feedbackDeal(){
		/*ajax传过来的数据有：为了防止恶意留言，设定留言为每分钟留言为1条。在一分钟内重复留言不作处理
		1.用户id
		2.书本id
		3.留言内容
		*/
		$openid = get_openid();
		$current_time = time();
		$data['userid'] = $_POST['userid'];
		
		$data['content'] = $_POST['feedback'];
		if($data['content']==""){
			$data['status'] = 0;
			$data['info'] = "大侠，您怎么什么都没写啊？";
			$this->ajaxReturn($data,'JSON');
		}
		else{
			$data['status'] = 0;
			$data['info'] = "感谢您的反馈，我们会认真考虑哒！";
			$this->ajaxReturn($data,'JSON');
		}
		
	}
	function message(){
		$data['userid'] = $_GET['userid'];
		$data['bookid'] = $_GET['bookid'];
		//dump($data);
		$this->assign("data",$data);
		$this->display(ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/message.html' );
	}
	
	function messageDeal(){
		/*ajax传过来的数据有：为了防止恶意留言，设定留言为每分钟留言为1条。在一分钟内重复留言不作处理
		1.用户id
		2.书本id
		3.留言内容
		*/
		$openid = get_openid();
		$current_time = time();
		$data['userid'] = $_POST['userid'];//留言用户的id
		$data['bookid'] = $_POST['bookid'];
		
		$data['content'] = $_POST['message'];
		if($data['content']==""){
			$data['status'] = 0;
			$data['info'] = "大侠，您怎么什么都没写啊？";
			$this->ajaxReturn($data,'JSON');
		}
		else{
			//获取当前时间，判断和上次提交的时间的差距，如果小于60s，不允许提交，提示操作过于频繁。
			$user = M("public_follow")->where("openid = "."'".$openid."'")->find();
			if(($current_time-$user['last_message_time'])<=60){
				//$user['last_advise_time'] = $curent_time;
				//$user['advise_times'] = 0;
				//M("public_follow")->where("openid = "."'".$openid."'")->save($user);			
				$data['status'] = 0;
				$data['info'] = "对不起，您的提交过于频繁了！";
				$this->ajaxReturn($data,'JSON');
			}
			else{
				$user['last_message_time'] = $current_time;
				M("public_follow")->where("openid = "."'".$openid."'")->save($user);
				$data['create_time'] = $current_time;
				M('book_comment')->add($data);
				$data['status'] = 1;
				
				/*用户留言增加积分,留言者和书主人均增加积分，若自己给自己留言不增加积分*/
				//获取书本主任的id
				$ownner = M('books')->where(' id = '.$data['bookid'])->getField('ownner');
				if($user['uid'] == $ownner){
					$data['info'] = "感谢您的留言！";
					$this->ajaxReturn($data,'JSON');
				}
				else{
					//判断是不是给图书馆进行判断
					if($ownner != 0){
						$credit['uid'] = $ownner;
						$credit['cTime'] = time();
						$credit['experience'] = 1;	
						$credit['score'] =5; 
						$credit['credit_name'] = 'message';
						$credit['credit_title'] = '留言和反馈';	
						$credit['admin_uid'] = 0;
						$credit['token'] = get_token();
						D("Common/Credit")->addCredit($credit);
						$credit['uid'] = $user['id'];
						if(D("Common/Credit")->addCredit($credit)){			
							$data['info'] = "感谢您的留言，积分+5！";
							$this->ajaxReturn($data,'JSON');
						}
						else{
					
							$data['info'] = "留言失败！";
							$this->ajaxReturn($data,'JSON');	
						}
					}
					else{
						$credit['uid'] = $user['id'];
						$credit['cTime'] = time();
						$credit['experience'] = 1;	
						$credit['score'] =5; 
						$credit['credit_name'] = 'message';
						$credit['credit_title'] = '留言和反馈';	
						$credit['admin_uid'] = 0;
						$credit['token'] = get_token();
						if(D("Common/Credit")->addCredit($credit)){			
							$data['info'] = "感谢您的留言，积分+5！";
							$this->ajaxReturn($data,'JSON');
						}
						else{
					
							$data['info'] = "留言失败！";
							$this->ajaxReturn($data,'JSON');	
						}
					}
				}	
			}
		}
		
	}
	
	
	function advise(){
		/*检测用户是否是通过微信打开，如果不是微信打开不能够获取到openid
		*/
		
		/*用户点开表单的时候检测该用户是否可以提交:
		检测方式:
		获取到用户的openid ，和uid，检查上次提交的时间和提交次数处理如下：
		1.上次提交时间距离现在大于10分钟，可以提交，提交后次数清0后加1.
		2.上次提交时间距离现在小于10分钟，检测次数是否大于等于3，是不允许提交，否允许提交。提交后次数+10。时间不变
		*/
		//dump(get_openid());
		//$user = M("public_follow")->where("openid = "."'".$openid."'")->select();
		
		$data = M("kind_book")->select();
		$this->assign("data",$data);
		$this->display( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/advise.html' );
		
	}
	function form(){
		//$data["ownner"] = $_GET['ownner']; //书主的id
		//$data["book"] = $_GET['book'];//书本名字
		//$book_id = $_POST['book_id'];//书本id
		//$data["userid"] = $_GET['userid']; //借书人id
		
		//$this->assign("data",$data);
		$this->display( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/form.html' );
		
	}
	
	function adviseDeal(){
		$openid = get_openid();
		$curent_time = time();
		
		//获取到推荐书的信息
		$data['name'] = $_POST['book'];
		$data['kind'] = $_POST['kind'];
		$data['description'] = $_POST['description'];
		$data['writer'] = $_POST['writer'];	
		$data['available'] = $_POST['available'];
		$data['create_time'] = $curent_time;
		/*用户点开表单的时候检测该用户是否可以提交:
		检测方式:
		获取到用户的openid ，和uid，检查上次提交的时间和提交次数处理如下：
		1.上次提交时间距离现在大于10分钟，可以提交，提交后次数清0后加1.
		2.上次提交时间距离现在小于10分钟，检测次数是否大于等于3，是不允许提交，否允许提交。提交后次数+10。时间不变
		*/
		//获取用户建议信息和当前时间
		$user = M("public_follow")->where("openid = "."'".$openid."'")->find();
		
		if(($curent_time-$user['last_advise_time'])>=600){
			$user['last_advise_time'] = $curent_time;
			$user['advise_times'] = 0;
			M("public_follow")->where("openid = "."'".$openid."'")->save($user);
			/*$data['status'] = 0;
			$data['info'] = "提交失败，所有项都要填写哦，亲！".$user['last_advise_time'];
			$this->ajaxReturn($data,'JSON');
			*/
			
			
			//判断值是否为空
			if($data['name']==""|$data['kind']==""|$data['description']==""|$data["writer"]==""){
				$data['status'] = 0;
				$data['info'] = "提交失败，所有项都要填写哦，亲！";
				$this->ajaxReturn($data,'JSON');
			}
			//存入数据库中
			$data["ownner"] = $user['uid'];//M("public_follow")->where("openid="."'".get_openid()."'")->getField("uid");		
			if($data["ownner"]==""){
				$data['status'] = 2;
				$data['info'] = "提交失败，openid获取失败".get_openid();
				$this->ajaxReturn($data,'JSON');
			}
			
			$data['kind'] = M("kind_book")->where("kind = "."'".$data['kind']."'")->getField("id");
			if($data['kind']==""){
				$data['status'] = 3;
				$data['info'] = $data['kind'];
				$this->ajaxReturn($data,'JSON');
			}
			$book["name"] = $data["name"];
			$book["ownner"] = $data["ownner"];
			$book["kind"] = $data["kind"];
			if(M("books")->where($book)->find()!=null){
				$data['status'] = 3;
				$data['info'] = "已经推荐过了哈,请不要重复提交";
				$this->ajaxReturn($data,'JSON');
			}
			//$data['available'] = 1;
			$data["create_time"] = time();
			//M('books')->add($data);
			M('advise_books')->add($data);
			$data['status'] = 1;
			/*
			用户推荐书籍增加积分
			*/
			$credit['uid'] = $data['userid'];
			$credit['cTime'] = time();
			$credit['experience'] = 10;
			
			if($data['available'] ==1){
				$credit['score'] =50; 
				$credit['credit_name'] = 'advise_books2';
				$credit['credit_title'] = '推荐书籍(可借)';
			}
			else{
				$credit['score'] =40; 
				$credit['credit_name'] = 'advise_books';
				$credit['credit_title'] = '推荐书籍';
			}
			$credit['admin_uid'] = 0;
			$credit['token'] = get_token();
			if(D("Common/Credit")->addCredit($credit)){			
				$data['info'] = "提交成功,请不要重复提交";
				$this->ajaxReturn($data,'JSON');
			}
			else{
				
				$data['info'] = "提交失败,请不要重复提交";
				$this->ajaxReturn($data,'JSON');
			}
			
		}
		else if(($curent_time-$user['last_advise_time'])<600){
			if($user['advise_times']>=3){
				$data['status'] = 0;
				$data['info'] = "对不起，您的提交过频哦，亲！";
				$this->ajaxReturn($data,'JSON');
			}
			else{
				$user['advise_times'] +=1;
				M("public_follow")->where("openid = "."'".$openid."'")->save($user);
				//判断值是否为空
				if($data['name']==""|$data['kind']==""|$data['description']==""|$data["writer"]==""){
					$data['status'] = 0;
					$data['info'] = "提交失败，所有项都要填写哦，亲！";
		
					$this->ajaxReturn($data,'JSON');
				}
				//存入数据库中
				$data["ownner"] = $user['uid'];//M("public_follow")->where("openid="."'".get_openid()."'")->getField("uid");		
				if($data["ownner"]==""){
					$data['status'] = 2;
					$data['info'] = "提交失败，openid获取失败";
					$this->ajaxReturn($data,'JSON');
				}
			
				$data['kind'] = M("kind_book")->where("kind = "."'".$data['kind']."'")->getField("id");
				if($data['kind']==""){
					$data['status'] = 3;
					$data['info'] = $data['kind'];
					$this->ajaxReturn($data,'JSON');
				}
				$book["name"] = $data["name"];
				$book["ownner"] = $data["ownner"];
				$book["kind"] = $data["kind"];
				if(M("books")->where($book)->find()!=null){
					$data['status'] = 3;
					$data['info'] = "已经推荐过了哈,请不要重复提交";
					$this->ajaxReturn($data,'JSON');
				}
				//$data['available'] = 1;
				$data["create_time"] = time();
				M('advise_books')->add($data);
				$data['status'] = 1;
				/*
				用户推荐书籍增加积分
			*/
				$credit['uid'] = $data['userid'];
				$credit['cTime'] = time();
				$credit['experience'] = 10;
				
				if($data['available'] ==1){
					$credit['score'] =50; 
					$credit['credit_name'] = 'advise_books2';
					$credit['credit_title'] = '推荐书籍(可借)';
				}
				else{
					$credit['score'] =30; 
					$credit['credit_name'] = 'advise_books';
					$credit['credit_title'] = '推荐书籍';
				}
				$credit['admin_uid'] = 0;
				$credit['token'] = get_token();
				if(D("Common/Credit")->addCredit($credit)){			
					$data['info'] = "提交成功,请不要重复提交";
					$this->ajaxReturn($data,'JSON');
				}
				else{
				
					$data['info'] = "提交失败,请不要重复提交";
					$this->ajaxReturn($data,'JSON');
				}
			}
		}		
	}
	
	//用户请求增加一本书籍
	function addBook(){
		$data = M("kind_book")->select();
		$this->assign("data",$data);
		$this->display( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/addbook.html' );
	}
	//处理增加书的请求
	function addBookDeal(){
		$openid = get_openid();
		$curent_time = time();
		
		//获取到推荐书的信息
		$data['name'] = $_POST['book'];
		$data['kind'] = $_POST['kind'];
		$data['description'] = $_POST['description'];
		$data['writer'] = $_POST['writer'];	
		$data['create_time'] = $curent_time;
		/*用户点开表单的时候检测该用户是否可以提交:
		检测方式:
		获取到用户的openid ，和uid，检查上次提交的时间和提交次数处理如下：
		1.上次提交时间距离现在大于10分钟，可以提交，提交后次数清0后加1.
		2.上次提交时间距离现在小于10分钟，检测次数是否大于等于3，是不允许提交，否允许提交。提交后次数+10。时间不变
		*/
		//获取用户建议信息和当前时间
		
		$user = M("public_follow")->where("openid = "."'".$openid."'")->find();
		
		if(($curent_time-$user['last_advise_time'])>=600){
			$user['last_advise_time'] = $curent_time;
			$user['advise_times'] = 0;
			M("public_follow")->where("openid = "."'".$openid."'")->save($user);
					
			//判断值是否为空
			if($data['name']==""|$data['kind']==""|$data['description']==""|$data['writer']==""){
				$data['status'] = 0;
				$data['info'] = "提交失败，所有项都要填写哦，亲！".$data['uid'];
				$this->ajaxReturn($data,'JSON');
			}
			//存入数据库中
			$data['userid'] = $user['uid'];//M("public_follow")->where("openid="."'".get_openid()."'")->getField("uid");		
			if($data['userid']==""){
				$data['status'] = 2;
				$data['info'] = "提交失败，openid获取失败".get_openid();
				$this->ajaxReturn($data,'JSON');
			}
			
			$data['kind'] = M("kind_book")->where("kind = "."'".$data['kind']."'")->getField("id");
			if($data['kind']==""){
				$data['status'] = 3;
				$data['info'] = $data['kind'];
				$this->ajaxReturn($data,'JSON');
			}
			$book["name"] = $data["name"];
			$book["userid"] = $data["userid"];
			$book["kind"] = $data["kind"];
			if(M("addbook")->where($book)->find()!=null){
				$data['status'] = 3;
				$data['info'] = "已经推荐过了哈,请不要重复提交";
				$this->ajaxReturn($data,'JSON');
			}
			$book["create_time"] = time();
			M('addbook')->add($data);
			$data['status'] = 1;
			/*完成后可以增加积分*/
			//
			$credit['uid'] = $data['userid'];
			$credit['cTime'] = time();
			$credit['experience'] = 0;
			$credit['score'] =0; 
			$credit['credit_name'] = 'advise_add';
			$credit['credit_title'] = '请求增书';
			$credit['admin_uid'] = 0;
			$credit['token'] = get_token();
			if(D("Common/Credit")->addCredit($credit)){			
				$data['info'] = "提交成功,请不要重复提交";
				$this->ajaxReturn($data,'JSON');
			}
			else{
				
				$data['info'] = "提交失败,请不要重复提交";
				$this->ajaxReturn($data,'JSON');
			}
			
			
		}
		else if(($curent_time-$user['last_advise_time'])<600){
			if($user['advise_times']>=3){
				$data['status'] = 0;
				$data['info'] = "对不起，您的提交过频哦，亲！".$data['uid'];
				$this->ajaxReturn($data,'JSON');
			}
			else{
				$user['advise_times'] +=1;
				M("public_follow")->where("openid = "."'".$openid."'")->save($user);
				//判断值是否为空
				if($data['name']==""|$data['kind']==""|$data['description']==""|$data["writer"]==""){
					$data['status'] = 0;
					$data['info'] = "提交失败，所有项都要填写哦，亲！".$data['uid'];
					$this->ajaxReturn($data,'JSON');
				}
				//存入数据库中
				$data['userid'] = $user['uid'];//M("public_follow")->where("openid="."'".get_openid()."'")->getField("uid");		
				if($data['userid']==""){
					$data['status'] = 2;
					$data['info'] = "提交失败，openid获取失败";
					$this->ajaxReturn($data,'JSON');
				}
			
				$data['kind'] = M("kind_book")->where("kind = "."'".$data['kind']."'")->getField("id");
				if($data['kind']==""){
					$data['status'] = 3;
					$data['info'] = $data['kind'];
					$this->ajaxReturn($data,'JSON');
				}
				$book["name"] = $data["name"];
				$book["userid"] = $data["userid"];
				$book["kind"] = $data["kind"];
				if(M("addbook")->where($book)->find()!=null){
					$data['status'] = 3;
					$data['info'] = "已经推荐过了哈,请不要重复提交";
					$this->ajaxReturn($data,'JSON');
				}
				M('addbook')->add($data);
				$data['status'] = 1;
				/*完成后可以增加积分*/
			//
				$credit['uid'] = $data['userid'];
				$credit['cTime'] = time();
				$credit['experience'] = 1;
				$credit['score'] =2; 
				$credit['credit_name'] = 'advise_add';
				$credit['credit_title'] = '请求增书';
				$credit['admin_uid'] = 0;
				$credit['token'] = get_token();
				if(D("Common/Credit")->addCredit($credit)){			
					$data['info'] = "提交成功,请不要重复提交";
					$this->ajaxReturn($data,'JSON');
				}
				else{
				
					$data['info'] = "提交失败,请不要重复提交";
					$this->ajaxReturn($data,'JSON');
				}
			}	
		}			
	}
}
