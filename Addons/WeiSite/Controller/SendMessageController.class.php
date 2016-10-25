<?php

namespace Addons\WeiSite\Controller;

use Home\Controller\MessageController;

class SendMessageController extends MessageController{
	var $config;
	function _initialize() {
		parent::_initialize ();
		$this->assign('nav',null);
		$config = getAddonConfig ( 'WeiSite' );
		$config ['cover_url'] = get_cover_url ( $config ['cover'] );
		$config['background_arr']=explode(',', $config['background']);
		$config ['background_id'] = $config ['background_arr'][0];
		$config ['background'] = get_cover_url ( $config ['background_id'] );
		$this->config = $config;
		$this->assign ( 'config', $config );
		//dump ( $config );
		// dump(get_token());
		
		// 定义模板常量
		$act = strtolower ( _ACTION );
		$temp = $config ['template_' . $act];
		$act = ucfirst ( $act );
		$this->assign ( 'page_title', $config ['title'] );
		define ( 'CUSTOM_TEMPLATE_PATH', ONETHINK_ADDON_PATH . 'WeiSite/View/default/Template' );
	}
	
	/*问问同事功能，用户进入一个表单页面，填写知己查找的书本信息，自己的联系信息。
	，提交后发送给全部用户，限制提问的频率为每周3次
	*/
	
	function ask(){
		//处理ajax  post过来的数据，首先根据id获得用户的openid.
		$ownner = $_POST['ownner']; //书主的id
		$book = $_POST['name'];//书本名字
		$bookid = $_POST['book_id'];//书本id
		$userid = $_POST['userid']; //借书人id
		//获取书主人的openid用于消息发送
		$openid = M( 'public_follow' )->where("uid=".$ownner)->getField("openid");
		$curent_time = time();
		
		//获取用户借书信息和当前时间
		$user = M("public_follow")->where("uid = ".$userid)->find();
		
		$data["record"] = $ownner.$bookid.$userid;
		$data["book_id"] = $bookid;
		$data["apply_id"] = $userid;
		$data["ownner_id"] = $ownner;
		$data["create_time"] = $curent_time;
		/*验证用户是否有借书的权限
		
		检测方式:
		获取到用户的openid ，和uid，检查上次借书的时间和提交次数处理如下：
		1.上次提交时间距离现在大于24小时，可以提交，提交后次数清0后加，时间更新.
		2.上次提交时间距离现在小于24小时，检测次数是否大于等于3，是不允许提交，否允许提交。提交后次数+1。时间不变
		*/
		
		//$data["status"] = 1;
		//$data["info"] = "hpweixin.microbye.com/index.php?s=/addon/WeiSite/WeiSite/borrow/ownner/".$ownner."/userid/".$userid."/book/".$book."/bookid/".$book_id."/token/gh_b5826b7a409f";
		//$this->ajaxReturn($data,'JSON');
		if($userid==""){
			$data["status"] = 1;
			$data["info"] = '请在微信中打开'.$userid;	
			$this->ajaxReturn($data,'JSON');
		}
		if($ownner==$userid){
			$data["status"] = 1;
			$data["info"] = '大侠，这书不就是你的么？';	
			$this->ajaxReturn($data,'JSON');
		}
		//获取用户建议信息和当前时间
		if(($curent_time-$user['last_borrow_time'])>=86400){
			$user['last_borrow_time'] = $curent_time;
			$user['borrow_times'] = 0;
			M("public_follow")->where("uid = ".$userid)->save($user);
			/*验证通过建立一条借书记录，为了保证记录的唯一，采用：借书人id+书8/籍id+书主人id					的形式表示,用户在回复的时候必须带上这一条记录定位回复*/
			
			$data["state"] = 1; //表示该记录生效中，可以根据该记录确定借书状态。
			//判断记录是否存在，并且状态为1的话表示该借书请求已经被处理了,不能够借这本书
			if(M("borrow_apply")->where($data)->find())	{
				$data["status"] = 1;
				$data["info"] = '你已经借过这本书了';	
				$this->ajaxReturn($data,'JSON');
			}
			else{
				//用户还没借过这本书
				$data["state"] = 0;
				if(M("borrow_apply")->where($data)->find() == null){
					M("borrow_apply")->add($data);
				}				
				$content = "大侠你好，有人向你请求借《".$book."》，是否愿意拔刀相助？你可以回复你的联系方式和他建立联系哦！";
				/*组装图文数据*/
			
				$art ['title'] = "有人根据您的推荐，想借《".$book."》这本书,是否愿意认识这位志同道合的朋友？";
				$art ['description'] = "可提供手机号码以便这位朋友联系您。";
				$art ['url'] = "hpweixin.microbye.com/index.php?s=/addon/WeiSite/WeiSite/borrow/ownner/".$ownner."/userid/".$userid."/book/".$book."/bookid/".$bookid."/token/gh_b5826b7a409f";		
				// 获取封面图片URL
				$art ['picurl'] = "http://img2.3lian.com/2014/c8/59/d/39.jpg";			
				$message = D("SendMessage")->replyNews($ownner,$art);
				
				$data["status"] = 1;
				$data["info"] = "借阅消息已发出,请不要重复借阅";
				$this->ajaxReturn($data,'JSON');
			}
		}
		else if(($curent_time-$user['last_borrow_time'])<86400){
			if($user['borrow_times']>=3){
				$data['status'] = 0;
				$data['info'] = "sorry，今日次数已经用完，亲！";
				$this->ajaxReturn($data,'JSON');
			}
			else{
				$user['borrow_times']+=1;
				$data["state"] = 1; //表示该记录生效中，可以根据该记录确定借书状态。
				M("public_follow")->where("uid = ".$userid)->save($user);
				if(M("borrow_apply")->where($data)->find())	{
					$data["status"] = 1;
					$data["info"] = '你已经借过这本书了';	
					$this->ajaxReturn($data,'JSON');
				}
				else{
					//用户还没借过这本书
					$data["state"] = 0;
					if(M("borrow_apply")->where($data)->find() == null){
						M("borrow_apply")->add($data);
					}	
					
					//M("borrow_apply")->add($data);
					//M("borrow_apply")->save($data);
					$record = $ownner.$bookid.$userid;
					$content = "大侠你好，有人向你请求借《".$book."》，是否愿意拔刀相助？你可以回复你的联系方式和他建立联系哦！";
				//$openidArr= $this->_get_user_openid(1,0,$openid);
				/*组装图文数据*/
			
					$art ['title'] = "大侠你好，有人向你借《".$book."》这本书";
					$art ['description'] = "侠义相借，请点击进入";
					$art ['url'] = "hpweixin.microbye.com/index.php?s=/addon/WeiSite/WeiSite/borrow/ownner/".$ownner."/userid/".$userid."/book/".$book."/bookid/".$bookid."/token/gh_b5826b7a409f";		
					// 获取封面图片URL
					$art ['picurl'] = "http://img2.3lian.com/2014/c8/59/d/39.jpg";			
					
					$message = D("SendMessage")->replyNews($ownner,$art);
					//D("SendMessage")->replyText($ownner,$art['url']);
					$data["status"] = 1;
					$data["info"] = "借阅消息已发出,请不要重复借阅";
					$this->ajaxReturn($data,'JSON');	
				}
			}
		}
	}
	
	//发送同意借书的信息
	function reply(){
		$ownner = $_POST['ownner']; //书主的id
		$book = $_POST['name'];//书本名字
		$bookid = $_POST['bookid'];//书本id
		$userid = $_POST['userid']; //借书人id
		$info = $_POST['mes'];
		if($info==""){
			$data["status"] = 1;
			$data["info"] = "请输入联系信息！";
			$this->ajaxReturn($data,'JSON');
		}
		//为了应对几个人同时借一本书，书主人同时收到几个请求
		if(M('books')->where("id = ".$bookid)->getField("available") == 0){
			$data["status"] = 1;
			$data["info"] = "不好意思，此书已借出，不可再操作";
			$this->ajaxReturn($data,'JSON');
		}
		
		$record = $ownner.$bookid.$userid;
		$list = M("borrow_apply")->where("record = ".$record)->find();
		if($list ==null){
			$data["status"] = 1;
			$data["info"] = "过期回复，请返回";
			$this->ajaxReturn($data,'JSON');
		}
		if($list["state"] == 1){
			$data["status"] = 1;
			$data["info"] = "大侠别调皮！书已借出去了！";
			$this->ajaxReturn($data,'JSON');
		}
		else {
		//判断能否回复，首先查询数据库是否有此条记录，并且state为1，检车是否为空，联系方式是不是为空		
			$list['state'] = 1;
			$list['reply_info'] = $info;
			//保存借书记录，同时将这本已经借出去的信息保存到数据库。
			M("borrow_apply")->where("record = ".$record)->save($list);
			$borrow_book['book_id'] = $list['book_id'];
			$borrow_book['borrow_time'] = time();
			M('borrowed_books')->add($borrow_book);
			M('books')->where('id = '.$bookid)->setField('available',0);
			$content = "《".$book."》这本书的主人回复你了,赶紧联系TA!联系方式：".$info;
			$message = D("SendMessage")->replyText($userid,$content);
			$data["status"] = 1;
			/*用户同意借书增加积分*/
			$credit['uid'] = $data['userid'];
			$credit['cTime'] = time();
			$credit['experience'] = 10;	
			$credit['score'] =20; 
			$credit['credit_name'] = 'agree';
			$credit['credit_title'] = '同意借书';				
			$credit['admin_uid'] = 0;
			$credit['token'] = get_token();
			if(D("Common/Credit")->addCredit($credit)){			
				$data["info"] = "消息已发出,请不要重复提交";
				$this->ajaxReturn($data,'JSON');	
			}
			else{				
				$data["info"] = "消息发出失败";
				$this->ajaxReturn($data,'JSON');	
			}
			
		}
	}
	//将用户的书本名字+用户的openid发送给其他用户
	function _send_by_openid($content,$openidArr){
		echo get_openid();
		
		//$this->assign ('normal_tips', '娓╅Θ鎻愮ず<br/>瀹㈡湇缇ゅ彂鎺ュ彛鏄寚锛氱鐞嗚€呭彲浠ョ粰 鍦?8灏忔椂鍐呬富鍔ㄥ彂娑堟伅缁欏叕浼楀彿鐨勭敤鎴风兢鍙戞秷鎭?锛屽彂閫佹鏁版病鏈夐檺鍒讹紱濡傛灉娌℃湁鎴愬姛鎺ユ敹鍒版秷鎭殑鐢ㄦ埛锛屽垯鍦ㄤ粬涓诲姩鍙戞秷鎭粰鍏紬鍙锋椂锛屽啀閲嶆柊鍙戠粰璇ョ敤鎴枫€? );
	    	
// 		$this->assign ( 'noraml_tips', '当用户发消息给认证公众号时，管理员可以在48小时内给用户回复信息' );
			$data ['ToUserName'] = get_token ();
			$data ['cTime'] = time ();
			$data ['msgType'] = "text";
			$data ['manager_id'] = $this->mid;
			$data ['content'] = $content;
			$data ['send_type'] = "";
			$data ['group_id'] = "";
			$data ['send_openids'] = "";
			//	$this->error ( '指定的Openid值不能为空' );
			//}
			//if ($data['msgType']=='appmsg'){
			//    $data['msgType']='news';
			//}
			$map1 ['ToUserName'] = get_token ();
			 //将所有用户的openid放到数组中
			
			dump($openidArr);
			foreach ( $openidArr as $k => $v ) {
			$data ['news_group_id'] = "1";
					if (empty ( $data ['news_group_id'] )) {
						$this->error ( '无法发送' );
					}
					$result = D ( 'Common/Custom' )->replyText ( $k, $data ['content'] );
					//$result = D ( 'Common/Custom' )->replyNews ( $k, $data ['news_group_id'] );
			}
			
	}
}
