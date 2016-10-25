<?php
        	
namespace Addons\BorrowBook\Model;
use Home\Model\WeixinModel;
        	
/**
 * BorrowBook的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'BorrowBook' ); // 获取后台插件的配置参数	
		//dump($config);
		//第一步：获取回复的内容
		$content = $dataArr["Content"];
		//$content = strtok($dataArr["content"],"##") ;
		//第二步：根据record获取到借书人和主人的消息
		$openid = get_openid();
		$uid = M("public_follow")->where("openid="."'".$openid."'")->getField("uid");
		$result = M("borrow_apply")->where("ownner_id=".$uid)->select();
		foreach($result as $k){
			$openidArr2 = M("public_follow")->where("uid=".$k["apply_id"])->getField("openid");
		
		
		
		//$content = "有人向你请求借这书本，"."你可以回复##+内容+##和回复microbye！您的回复将会发送给microbye，请注意回复条数限制为3条，3条后不可再回复。";
			$send = A('Addons://WeiSite/SendMessage');
			$openidArr= $send->_get_user_openid(1,0,$openidArr2);	
			$this->_send_by_openid($content,$openidArr);
		}
		
		$this->replyText("消息已发送".$result[0]["apply_id"]);
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
			
			//dump($openidArr);
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
        	