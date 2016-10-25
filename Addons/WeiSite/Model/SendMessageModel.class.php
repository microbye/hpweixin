<?php

namespace Addons\WeiSite\Model;

use Think\Model;

/**
 * WeiSiteģ��
 */
class SendMessageModel extends Model {
	protected $autoCheckFields =false;
	//�ظ��ı���Ϣ
	 function replyText($uid, $content) {
		$param ['text'] ['content'] = $content;
		return $this->_replyData ( $uid, $param, 'text' );
	}
	
	//�ظ�ͼ����Ϣ��
	public function replyNews($uid, $art) {
		$articles [] = $art;
		$param ['news'] ['articles'] = $articles;
		return $this->_replyData ( $uid, $param, 'news' );
	}
	
	/* ���ͻظ���Ϣ��΢��ƽ̨ */
	function _replyData($uid, $param, $msg_type) {
		$map ['token'] = get_token ();
		$map ['uid'] = $uid;
		
		$param ['touser'] = M ( 'public_follow' )->where ( $map )->getField ( 'openid' );
		$param ['msgtype'] = $msg_type;
		
		$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . get_access_token ();
		//$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=nmrqwTrj60SRPAr7KhBw0qd6vHBf0pSv2uJZ4tLWdTydaafKbjwCY9MXsT9ZwjrhNwyGoKWxXsrGrQW7apwZhTBvl5oChvwsSkfYQCEBQFsVDJcAGAOWC";
		// dump($param);
		// die;
		$result ['status'] = 0;
		$result ['msg'] = '�ظ�ʧ��';
		$res = post_data ( $url, $param );
		if ($res ['errcode'] != 0) {
			$result ['msg'] = error_msg ( $res );
		} else {
			$data ['ToUserName'] = get_token ();
			$data ['FromUserName'] = $param ['touser'];//"odY1cxDecvyPuB86HZTvGAQhhit0";//
			$data ['CreateTime'] = NOW_TIME;
			$data ['Content'] = isset ( $param ['text'] ['content'] ) ? $param ['text'] ['content'] : json_encode ( $param );
			$data ['MsgId'] = get_mid(); // ���ֶα������ԱID
			$data ['type'] = 1;
			$data ['is_read'] = 1;
			M ( 'weixin_message' )->add ( $data );
			
			$result ['status'] = 1;
			$result ['msg'] = '�ظ��ɹ�';
		}
		return $result['msg'];
	}
}
