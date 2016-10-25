<?php

namespace Addons\WeiSite\Controller;

use Addons\WeiSite\Controller\BaseController;

class WeiSiteController extends BaseController {
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

	// 首页
	function index() {
		// add_credit ( 'weisite', 86400 );
		if (file_exists ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_index'] . '.html' )) {
			$this->pigcms_index ();
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_index'] . '.html' );
		} else {
			$map1 ['token'] = $map ['token'] = get_token ();
			$map1 ['is_show'] = $map ['is_show'] = 1;
			$map ['pid'] = 0; // 获取一级分类
			                  
			// 分类
			$category = M ( 'weisite_category' )->where ( $map )->order ( 'sort asc, id desc' )->select ();
			foreach ( $category as &$vo ) {
				$vo ['icon'] = get_cover_url ( $vo ['icon'] );
				empty ( $vo ['url'] ) && $vo ['url'] = addons_url ( 'WeiSite://WeiSite/lists', array (
						'cate_id' => $vo ['id'] 
				) );
			}
			$this->assign ( 'category', $category );
			// dump($category);
			// 幻灯片
			$slideshow = M ( 'weisite_slideshow' )->where ( $map1 )->order ( 'sort asc, id desc' )->select ();
			foreach ( $slideshow as &$vo ) {
				$vo ['img'] = get_cover_url ( $vo ['img'] );
			}
			
			foreach ( $slideshow as &$data ) {
				foreach ( $category as $cate ) {
					if ($data ['cate_id'] == $cate ['id'] && empty ( $data ['url'] )) {
						$data ['url'] = $cate ['url'];
					}
				}
			}
			$this->assign ( 'slideshow', $slideshow );
			// dump($slideshow);
			
			// dump($category);
			$map2 ['token'] = $map ['token'];
			$public_info = get_token_appinfo ( $map2 ['token'] );
			$this->assign ( 'publicid', $public_info ['id'] );
			
			$this->assign ( 'manager_id', $this->mid );
			
			$this->_footer ();
			// $backgroundimg=ONETHINK_ADDON_PATH.'WeiSite/View/default/TemplateIndex/'.$this->config['template_index'].'/icon.png';
			if ($this->config ['show_background'] == 0) {
				$this->config ['background'] = '';
				$this->assign ( 'config', $this->config );
			}
			$html = empty ( $this->config ['template_index'] ) ? 'ColorV1' : $this->config ['template_index'];
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateIndex/' . $html . '/index.html' );
		}
	}
	
	function test(){
		
		$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/test.html' );
	}
	
	// 分类列表
	function lists() {
		$cate_id = I ( 'cate_id', 0, 'intval' );
		empty ( $cate_id ) && $cate_id = I ( 'classid', 0, 'intval' );
		if (file_exists ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_lists'] . '.html' )) {
			
			$this->pigcms_lists ( $cate_id );
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_lists'] . '.html' );
		} else {
			$map ['token'] = get_token ();
			if ($cate_id) {
				$map ['cate_id'] = $cate_id;
				$cate = M ( 'weisite_category' )->where ( 'id = ' . $map ['cate_id'] )->find ();
				$this->assign ( 'cate', $cate );
				// 二级分类
				$category = M ( 'weisite_category' )->where ( 'pid = ' . $map ['cate_id'] )->order ( 'sort asc, id desc' )->select ();
			}
			if (! empty ( $category )) {
				foreach ( $category as &$vo ) {
					$vo ['icon'] = get_cover_url ( $vo ['icon'] );
					empty ( $vo ['url'] ) && $vo ['url'] = addons_url ( 'WeiSite://WeiSite/lists', array (
							'cate_id' => $vo ['id'] 
					) );
				}
				$this->assign ( 'category', $category );
				// 幻灯片
				
				$slideshow = M ( 'weisite_slideshow' )->where ( $map )->order ( 'sort asc, id desc' )->select ();
				foreach ( $slideshow as &$vo ) {
					$vo ['img'] = get_cover_url ( $vo ['img'] );
				}
				
				foreach ( $slideshow as &$data ) {
					foreach ( $category as $c ) {
						if ($data ['cate_id'] == $c ['id']) {
							$data ['url'] = $c ['url'];
						}
					}
				}
				$this->assign ( 'slideshow', $slideshow );
				
				$this->_footer ();
				if ($this->config ['template_subcate'] == 'default') {
					// code...
					$htmlstr = 'cate.html';
				} else {
					$htmlstr = 'index.html';
				}
				if (! $cate ['template']) {
					$cate ['template'] = $this->config ['template_subcate'];
				}
				$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateSubcate/' . $cate ['template'] . '/' . $htmlstr );
			} else {
				
				$page = I ( 'p', 1, 'intval' );
				$row = isset ( $_REQUEST ['list_row'] ) ? intval ( $_REQUEST ['list_row'] ) : 20;
				
				$data = M ( 'custom_reply_news' )->where ( $map )->order ( 'sort asc, id DESC' )->page ( $page, $row )->select ();
				if (empty ( $data )) {
					$cmap ['id'] = $map ['cate_id'] = intval ( $cate_id );
					$cate = M ( 'weisite_category' )->where ( $cmap )->find ();
					if (! empty ( $cate ['url'] )) {
						redirect ( $cate ['url'] );
						die ();
					}
				}
				/* 查询记录总数 */
				$count = M ( 'custom_reply_news' )->where ( $map )->count ();
				$list_data ['list_data'] = $data;
				
				// 分页
				if ($count > $row) {
					$page = new \Think\Page ( $count, $row );
					$page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
					$list_data ['_page'] = $page->show ();
				}
				
				foreach ( $list_data ['list_data'] as $k => $li ) {
					if ($li ['jump_url'] && empty ( $li ['content'] )) {
						$li ['url'] = $li ['jump_url'];
					} else {
						$li ['url'] = U ( 'detail', array (
								'id' => $li ['id'] 
						) );
					}
					$showType = explode ( ',', $li ['show_type'] );
					if (in_array ( 1, $showType )) {
						$slideData [] = $li;
					}
					if (in_array ( 0, $showType )) {
						// unset($list_data['list_data'][$k]);
						$lists [] = $li;
					}
				}
				$this->assign ( 'slide_data', $slideData );
				$this->assign ( 'lists', $lists );
				$this->assign ( $list_data );
				$this->_footer ();
				$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateLists/' . $this->config ['template_lists'] . '/lists.html' );
			}
		}
	}
	// 详情
	function detail() {
		if (file_exists ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_detail'] . '.html' )) {
			$this->pigcms_detail ();
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/Index_' . $this->config ['template_detail'] . '.html' );
		} else {
			$map ['id'] = I ( 'get.id', 0, 'intval' );
			$info = M ( 'custom_reply_news' )->where ( $map )->find ();//获取文章信息
			// dump($info);exit;
			if ($info ['is_show'] == '0') {
				unset ( $info ['cover'] );
			}
			// dump($info);exit;
			$this->assign ( 'info', $info );
			
			//获取评论信息（根据文章id）
			$num =  M('wcomment')->where("article_id = ".$info['id'])->count(); //获取评论总数
			$this->assign('num',$num);
			$data=array();
			$data=$this->getCommlist($info['id']);//获取评论列表
			//dump($data);
			//为了获取用户的点赞状态
			$openid = get_openid();
			$zan['uid'] = M("public_follow")->where("openid="."'".$openid."'")->getField("uid");
			$zan['news_id'] = $info['id'];
			$zan['state'] = 1;
			if( M("news_zan")->where($zan)->find()){
				$this->assign("zan",$zan);
			}
			else{
				$zan['state'] = 0;
				$this->assign("zan",$zan);
			}
			//$state = M("news_zan")->where("uid=".$userid)->find();
			//dump($openid);
			//dump($zan);
			$this->assign("commlist",$data);
			//dump($info);exit;
			M ( 'custom_reply_news' )->where ( $map )->setInc ( 'view_count' );
			//dump(get_openid());
			$this->_footer ();
			$this->display ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateDetail/' . $this->config ['template_detail'] . '/detail.html' );
		}
	}
	//用户点赞
	function zan(){		
		
		//如果用户点赞那么直接将文章赞数加1，不限制点赞数，如果需要限制点赞数可以通过ip或者用户的openid来进行限制。
		$article['zan'] = $_POST['vl'];
		$article['id'] = $_POST['news_id'];
		$A = M( 'custom_reply_news' );//->where($article)->find();
		//$A->zan = $_POST['vl'];
		$A->save($article);
		
		$data['news_id'] = $_POST['news_id'];
		$data['uid'] = $_POST['uid'];
		//$data['state'] = $_POST['state'];
		$Zan = M('news_zan');
		if($Zan->where($data)->find()){
			//$data['state'] = $_POST['state'];
			$Zan->where($data)->setField("state",$_POST['state']);
		}
		else{
			$data['state'] = $_POST['state'];
			$Zan->add($data);
		}
		$data['status'] = 1;
		$data['info'] = 'info'.$data['state'];
		$this->ajaxReturn($data,'JSON');
         
	}
	
	
	
	/**
	*添加评论
    */
    public function addComment(){

    	$data=array();
    	if((isset($_POST["comment"]))&&(!empty($_POST["comment"]))){
    		$cm = json_decode($_POST["comment"],true);//通过第二个参数true，将json字符串转化为键值对数组
    		$cm['create_time']=date('Y-m-d H:i:s',time());
    		$newcm = M('wcomment');
    		$id = $newcm->add($cm);
			//echo $cm['article_id'];
    		$cm["id"] = $id;
    		$data = $cm;

    		$num =  M('wcomment')->where("article_id = ".$cm['article_id'])->count();//统计评论总数
    		$data['num']= $num;

    	}else{
    		$data["error"] = "0";
    	}
    	

    	echo json_encode($data);
    }
	
	/**
	*递归获取评论列表(目前这个地方有问题，会陷入一个死递归出不来)，根据文章id获取出一个三维数据文章id
    */
    protected function getCommlist($article,$parent_id = 0,&$result = array()){    	
    	//获取到了所有的一级评论,但是并没有放入到array()中
		$arr = M('wcomment')->where("parent_id = ".$parent_id." and article_id = ".$article)->order("create_time desc")->select();   
    	//echo $article;
		//如果$arr是空返回真，即如果没有下级评论直接返回即可
		//dump($arr);
		if(empty($arr)){
    		//dump($arr);
			return array();
    	}
		//依次循环获取每一个下级评论
    	
		foreach ($arr as $cm) {  
			//thisarr指向array数组的下一级	
			$thisArr=&$result[];
			$cm["children"] = $this->getCommlist($article,$cm["id"],$thisArr);    
			//dump($cm);
			$thisArr = $cm; 	
				
		}
		return $result;
		
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
		if($list['state'] == 1){
			$this->assign("user",$user);
			$this->assign("data",$data);
			$this->display( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/borrowed.html' );
		}
		else{
			$this->assign("user",$user);
			$this->assign("data",$data);
			$this->display( ONETHINK_ADDON_PATH . 'WeiSite/View/default/Book/' . $this->config ['template_booklist'] . '/borrow.html' );
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
		$data["writer"] = $_POST["writer"];	/*用户点开表单的时候检测该用户是否可以提交:
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
			$data['available'] = 1;
			$data["create_time"] = time();
			M('books')->add($data);
			$data['status'] = 1;
			$data['info'] = "提交成功,请不要重复提交";
			$this->ajaxReturn($data,'JSON');
			
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
				$data['available'] = 1;
				$data["create_time"] = time();
				M('books')->add($data);
				$data['status'] = 1;
				$data['info'] = "提交成功,请不要重复提交";
				$this->ajaxReturn($data,'JSON');
			}
		}		
		
		
	}
	// 3G页面底部导航
	function _footer($temp_type = 'weiphp') {
		if ($temp_type == 'pigcms') {
			$param ['token'] = $token = get_token ();
			$param ['temp'] = $this->config ['template_footer'];
			$url = U ( 'Home/Index/getFooterHtml', $param );
			$html = wp_file_get_contents ( $url );
			// dump ( $url );
			// dump ( $html );
			$file = RUNTIME_PATH . $token . '_' . $this->config ['template_footer'] . '.html';
			if (! file_exists ( $file ) || true) {
				file_put_contents ( $file, $html );
			}
			
			$this->assign ( 'cateMenuFileName', $file );
		} else {
			$list = D ( 'Addons://WeiSite/Footer' )->get_list ();
			
			foreach ( $list as $k => $vo ) {
				if ($vo ['pid'] != 0)
					continue;
				
				$one_arr [$vo ['id']] = $vo;
				unset ( $list [$k] );
			}
			
			foreach ( $one_arr as &$p ) {
				$two_arr = array ();
				foreach ( $list as $key => $l ) {
					if ($l ['pid'] != $p ['id'])
						continue;
					
					$two_arr [] = $l;
					unset ( $list [$key] );
				}
				
				$p ['child'] = $two_arr;
			}
			$this->assign ( 'footer', $one_arr );
			if (empty ( $this->config ['template_footer'] )) {
				$this->config ['template_footer'] = 'V1';
			}
			$html = $this->fetch ( ONETHINK_ADDON_PATH . 'WeiSite/View/default/TemplateFooter/' . $this->config ['template_footer'] . '/footer.html' );
			$this->assign ( 'footer_html', $html );
		}
	}
	function _deal_footer_data($vo, $k) {
		$arr = array (
				'id' => $vo ['id'],
				'fid' => $vo ['pid'],
				'token' => $vo ['token'],
				'name' => $vo ['title'],
				'orderss' => 0,
				'picurl' => get_cover_url ( $vo ['icon'] ),
				'url' => $vo ['url'],
				'status' => "1",
				'RadioGroup1' => "0",
				'vo' => array (),
				'k' => $k 
		);
		return $arr;
	}
	function coming_soom() {
		$this->display ();
	}
	function tvs1_video() {
		$this->display ();
	}
	
	/*
	 * 兼容小猪CMS模板
	 *
	 * 移植方法：
	 * 1、把 tpl\static\tpl 目录下的所有文档复制到 weiphp的 Addons\WeiSite\View\default\pigcms 目录下
	 * 2、把 tpl\Wap\default 目录下的所有文档也复制到 weiphp的 Addons\WeiSite\View\default\pigcms 目录下
	 * 3、把 tpl\User\default\common\ 目录下的所有图片文件复制到 weiphp的 Addons\WeiSite\View\default\pigcms 目录下
	 * 4、把 PigCms\Lib\ORG\index.Tpl.php 文件复制到 weiphp的 Addons\WeiSite\View\default\pigcms 目录下
	 * 5、把pigcms 目录下所有文档代码里的 Wap/Index/lists 替换成 Home/Addons/execute?_addons=WeiSite&_controller=WeiSite&_action=lists
	 * 6、把pigcms 目录下所有文档代码里的 Wap/Index/index 替换成 Home/Addons/execute?_addons=WeiSite&_controller=WeiSite&_action=index
	 */
	function pigcms_init() {
		// dump ( 'pigcms_init' );
		C ( 'TMPL_L_DELIM', '{pigcms:' );
		// C ( 'TMPL_FILE_DEPR', '_' );
		
		define ( 'RES', ONETHINK_ADDON_PATH . 'WeiSite/View/default/pigcms/common' );
		
		$public_info = get_token_appinfo ();
		$manager = get_userinfo ( $public_info ['uid'] );
		
		// 站点配置
		$data ['f_logo'] = get_cover_url ( C ( 'SYSTEM_LOGO' ) );
		$data ['f_siteName'] = C ( 'WEB_SITE_TITLE' );
		$data ['f_siteTitle'] = C ( 'WEB_SITE_TITLE' );
		$data ['f_metaKeyword'] = C ( 'WEB_SITE_KEYWORD' );
		$data ['f_metaDes'] = C ( 'WEB_SITE_DESCRIPTION' );
		$data ['f_siteUrl'] = SITE_URL;
		$data ['f_qq'] = '';
		$data ['f_qrcode'] = '';
		$data ['f_ipc'] = C ( 'WEB_SITE_ICP' );
		$data ['reg_validDays'] = 30;
		
		// 用户信息
		$data ['user'] = array (
				'id' => $GLOBALS ['myinfo'] ['uid'],
				'openid' => get_openid (),
				'username' => $GLOBALS ['myinfo'] ['nickname'],
				'mp' => $public_info ['token'],
				'password' => $GLOBALS ['myinfo'] ['password'],
				'email' => $GLOBALS ['myinfo'] ['email'],
				'createtime' => $GLOBALS ['myinfo'] ['reg_time'],
				'lasttime' => $GLOBALS ['myinfo'] ['last_login_time'],
				'status' => 1,
				'createip' => $GLOBALS ['myinfo'] ['reg_ip'],
				'lastip' => $GLOBALS ['myinfo'] ['last_login_ip'],
				'smscount' => 0,
				'inviter' => 1,
				'gid' => 5,
				'diynum' => 0,
				'activitynum' => 0,
				'card_num' => 0,
				'card_create_status' => 0,
				'money' => 0,
				'moneybalance' => 0,
				'spend' => 0,
				'viptime' => $GLOBALS ['myinfo'] ['last_login_time'] + 86400,
				'connectnum' => 0,
				'lastloginmonth' => 0,
				'attachmentsize' => 0,
				'wechat_card_num' => 0,
				'serviceUserNum' => 0,
				'invitecode' => '',
				'remark' => '' 
		);
		
		// 微网站配置信息
		$data ['homeInfo'] = array (
				'id' => $manager ['uid'],
				'token' => $public_info ['token'],
				'title' => $this->config ['title'],
				'picurl' => get_cover_url ( $this->config ['cover'] ),
				// 'apiurl' => "",
				// 'homeurl' => "",
				'info' => $this->config ['info'],
				// 'musicurl' => "",
				// 'plugmenucolor' => "#5CFF8D",
				'copyright' => $manager ['copy_right'],
				// 'radiogroup' => "12",
				// 'advancetpl' => "0"
				'logo' => get_cover_url ( $this->config ['cover'] ) 
		);
		
		// 背景图
		$bgarr = $this->config ['background_arr'];
		$data ['flashbgcount'] = count ( $bgarr );
		foreach ( $bgarr as $bg ) {
			$data ['flashbg'] [] = array (
					'id' => $bg,
					'token' => $public_info ['token'],
					'img' => get_cover_url ( $bg ),
					'url' => "javascript:void(0)",
					'info' => "背景图片",
					'tip' => '2' 
			);
		}
		// $data ['flashbg'] [0] = array (
		// 'id' => $this->config ['background_id'],
		// 'token' => $public_info ['token'],
		// 'img' => $this->config ['background'],
		// 'url' => "javascript:void(0)",
		// 'info' => "背景图片",
		// 'tip' => '2'
		// );
		$data ['flashbgcount'] = count ( $data ['flashbg'] );
		$map ['token'] = get_token ();
		$map ['is_show'] = 1;
		// 幻灯片
		$slideshow = M ( 'weisite_slideshow' )->where ( $map )->order ( 'sort asc, id desc' )->select ();
		foreach ( $slideshow as $vo ) {
			$data ['flash'] [] = array (
					'id' => $vo ['id'],
					'token' => $vo ['token'],
					'img' => get_cover_url ( $vo ['img'] ),
					'url' => $vo ['url'],
					'info' => $vo ['title'],
					'tip' => '1' 
			);
		}
		$data ['num'] = count ( $data ['flash'] );
		
		// 底部栏
		$this->_footer ( 'pigcms' );
		
		// 设置版权信息
		$data ["iscopyright"] = 0;
		$data ["copyright"] = $data ["siteCopyright"] = empty ( $manager ['copy_right'] ) ? C ( 'COPYRIGHT' ) : $manager ['copy_right'];
		// 分享
		$data ['shareScript'] = '';
		
		$data ['token'] = $public_info ['token'];
		$data ['wecha_id'] = $public_info ['wechat'];
		
		$this->assign ( $data );
		
		// 模板信息
		if (file_exists ( ONETHINK_ADDON_PATH . _ADDONS . '/View/default/pigcms/index.Tpl.php' )) {
			$pigcms_temps = require_once ONETHINK_ADDON_PATH . _ADDONS . '/View/default/pigcms/index.Tpl.php';
			foreach ( $pigcms_temps as $k => $vo ) {
				$temps [$vo ['tpltypename']] = $vo;
			}
		}
		
		if (file_exists ( ONETHINK_ADDON_PATH . _ADDONS . '/View/default/pigcms/cont.Tpl.php' )) {
			$pigcms_temps = require_once ONETHINK_ADDON_PATH . _ADDONS . '/View/default/pigcms/cont.Tpl.php';
			foreach ( $pigcms_temps as $k => $vo ) {
				$temps [$vo ['tpltypename']] = $vo;
			}
		}
		$tpl = array (
				'id' => $public_info ['id'],
				'routerid' => "",
				'uid' => $public_info ['uid'],
				'wxname' => $public_info ['public_name'],
				'winxintype' => $public_info ['type'],
				'appid' => $public_info ['appid'],
				'appsecret' => $public_info ['secret'],
				'wxid' => $public_info ['id'],
				'weixin' => $public_info ['wechat'],
				'headerpic' => get_cover_url ( $GLOBALS ['myinfo'] ['headface_url'] ),
				'token' => $public_info ['token'],
				'pigsecret' => $public_info ['token'],
				'province' => $GLOBALS ['myinfo'] ['province'],
				'city' => $GLOBALS ['myinfo'] ['city'],
				'qq' => $GLOBALS ['myinfo'] ['qq'],
				// 'wxfans' => "0",
				// 'typeid' => "8",
				// 'typename' => "服务",
				// 'tongji' => "",
				// 'allcardnum' => "0",
				// 'cardisok' => "0",
				// 'yetcardnum' => "0",
				// 'totalcardnum' => "0",
				// 'createtime' => "1440150418",
				// 'updatetime' => "1440150418",
				// 'transfer_customer_service' => "0",
				// 'openphotoprint' => "0",
				// 'freephotocount' => "3",
				// 'oauth' => "0",
				'color_id' => 0,
				
				'tpltypeid' => $temps [$this->config ['template_index']] ['tpltypeid'],
				'tpltypename' => $this->config ['template_index'],
				
				'tpllistid' => $temps [$this->config ['template_lists']] ['tpltypeid'],
				'tpllistname' => $this->config ['template_lists'],
				
				'tplcontentid' => $temps [$this->config ['template_detail']] ['tpltypeid'],
				'tplcontentname' => $this->config ['template_detail'] 
		);
		$this->assign ( 'tpl', $tpl );
		$this->assign ( 'wxuser', $tpl );
	}
	function pigcms_index() {
		$this->pigcms_init ();
		
		$cate = $this->_pigcms_cate ( 0 );
		$this->assign ( 'info', $cate );
	}
	function pigcms_lists($cate_id) {
		$this->pigcms_init ();
		
		$map ['token'] = get_token ();
		$cateArr = M ( 'weisite_category' )->where ( $map )->getField ( 'id,title' );
		
		$thisClassInfo = array ();
		if ($cate_id) {
			$map ['cate_id'] = $cate_id;
			
			$thisClassInfo = $this->_deal_cate ( $cateArr [$cate_id] );
		}
		
		$data = M ( 'custom_reply_news' )->where ( $map )->order ( 'sort asc, id DESC' )->select ();
		foreach ( $data as $vo ) {
			$info [] = array (
					'id' => $vo ['id'],
					'uid' => 0,
					'uname' => $vo ['author'],
					'keyword' => $vo ['keyword'],
					'type' => 2,
					'text' => $vo ['intro'],
					'classid' => $vo ['cate_id'],
					'classname' => $vo [''],
					'pic' => get_cover_url ( $vo ['cover'] ),
					'showpic' => 1,
					'info' => strip_tags ( htmlspecialchars_decode ( mb_substr ( $vo ['content'], 0, 10, 'utf-8' ) ) ),
					'url' => $this->_getNewsUrl ( $vo ),
					'createtime' => $vo ['cTime'],
					'uptatetime' => $vo ['cTime'],
					'click' => $vo ['view_count'],
					'token' => $vo ['token'],
					'title' => $vo ['title'],
					'usort' => $vo ['sort'],
					'name' => $vo ['title'],
					'img' => get_cover_url ( $vo ['cover'] ) 
			);
		}
		
		$this->assign ( 'info', $info );
		$this->assign ( 'thisClassInfo', $thisClassInfo );
	}
	function pigcms_detail() {
		$this->pigcms_init ();
		
		$cate = $this->_pigcms_cate ( 0 );
		$this->assign ( 'info', $cate );
		
		$map ['id'] = I ( 'get.id', 0, 'intval' );
		$res = M ( 'custom_reply_news' )->where ( $map )->find ();
		if ($res ['is_show'] == 0) {
			unset ( $res ['cover'] );
		}
		$res = $this->_deal_news ( $res, 1 );
		$this->assign ( 'res', $res );
		M ( 'custom_reply_news' )->where ( $map )->setInc ( 'view_count' );
		
		$map2 ['cate_id'] = $res ['cate_id'];
		$map2 ['id'] = array (
				'exp',
				'!=' . $map ['id'] 
		);
		$lists = M ( 'custom_reply_news' )->where ( $map2 )->order ( 'id desc' )->limit ( 5 )->select ();
		foreach ( $lists as &$new ) {
			$new = $this->_deal_news ( $new );
		}
		
		$this->assign ( 'lists', $lists );
	}
	function _pigcms_cate($pid = null) {
		$map ['token'] = get_token ();
		$map ['is_show'] = 1;
		$pid === null || $map ['pid'] = $pid; // 获取一级分类
		
		$category = M ( 'weisite_category' )->where ( $map )->order ( 'sort asc, id desc' )->select ();
		$count = count ( $category );
		foreach ( $category as $k => $vo ) {
			$param ['cate_id'] = $vo ['id'];
			$url = empty ( $vo ['url'] ) ? $vo ['url'] = addons_url ( 'WeiSite://WeiSite/lists', $param ) : $vo ['url'];
			$pid = intval ( $vo ['pid'] );
			$res [$pid] [$vo ['id']] = $this->_deal_cate ( $vo, $count - $k );
		}
		
		foreach ( $res [0] as $vv ) {
			if (! empty ( $res [$vv ['id']] )) {
				$vv ['sub'] = $res [$vv ['id']];
				unset ( $res [$vv ['id']] );
			}
		}
		
		return $res [0];
	}
	function _deal_cate($vo, $key = 1) {
		return array (
				'id' => $vo ['id'],
				'fid' => $vo ['pid'],
				'name' => $vo ['title'],
				'info' => $vo ['title'],
				'sorts' => $vo ['sort'],
				'img' => get_cover_url ( $vo ['icon'] ),
				'url' => $url,
				'status' => 1,
				'path' => empty ( $vo ['pid'] ) ? 0 : '0-' . $vo ['pid'],
				'tpid' => 1,
				'conttpid' => 1,
				'sub' => array (),
				'key' => $key,
				'token' => $vo ['token'] 
		);
	}
	function _deal_news($vo, $type = 0) {
		$map ['id'] = $vo ['cate_id'];
		return array (
				'id' => $vo ['id'],
				'uid' => 0,
				'uname' => $vo ['author'],
				'keyword' => $vo ['keyword'],
				'type' => 2,
				'text' => $vo ['intro'],
				'classid' => $vo ['cate_id'],
				'classname' => empty ( $vo ['cate_id'] ) ? '' : M ( 'weisite_category' )->where ( $map )->getField ( 'title' ),
				'pic' => get_cover_url ( $vo ['cover'] ),
				'showpic' => 1,
				'info' => $type == 0 ? strip_tags ( htmlspecialchars_decode ( mb_substr ( $vo ['content'], 0, 10, 'utf-8' ) ) ) : $vo ['content'],
				'url' => $this->_getNewsUrl ( $vo ),
				'createtime' => $vo ['cTime'],
				'uptatetime' => $vo ['cTime'],
				'click' => $vo ['view_count'],
				'token' => $vo ['token'],
				'title' => $vo ['title'],
				'usort' => $vo ['sort'],
				'name' => $vo ['title'],
				'img' => get_cover_url ( $vo ['cover'] ) 
		);
	}
	function _getNewsUrl($info) {
		$param ['token'] = get_token ();
		$param ['openid'] = get_openid ();
		
		if (! empty ( $info ['jump_url'] )) {
			$url = replace_url ( $info ['jump_url'] );
		} else {
			$param ['id'] = $info ['id'];
			$url = U ( 'detail', $param );
		}
		return $url;
	}
	/* 预览 */
	function preview() {
		$publicid = get_token_appinfo ( '', 'id' );
		$url = addons_url ( 'WeiSite://WeiSite/index', array (
				'publicid' => $publicid 
		) );
		$this->assign ( 'url', $url );
		
		$config = get_addon_config ( 'WeiSite' );
		
		$config ['background_arr'] = explode ( ',', $config ['background'] );
		$config ['background'] = $config ['background_arr'] [0];
		$this->assign ( 'data', $config );
		
		$this->display ();
	}
	function preview_cms() {
		$publicid = get_token_appinfo ( '', 'id' );
		$url = addons_url ( 'WeiSite://WeiSite/lists', array (
				'publicid' => $publicid,
				'from' => 'preview' 
		) );
		$this->assign ( 'url', $url );
		
		$this->display ();
	}
	function preview_old() {
		$publicid = get_token_appinfo ( '', 'id' );
		$url = addons_url ( 'WeiSite://WeiSite/index', array (
				'publicid' => $publicid 
		) );
		$this->assign ( 'url', $url );
		$this->display ( SITE_PATH . '/Application/Home/View/default/Addons/preview.html' );
	}
}
