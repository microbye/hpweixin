<?php

namespace Liuyan\Controller;
use Think\Controller;

class LiuyanController extends Controller {
    
	public function liuyan(){  
    	//$num =  M('comment')->count(); //��ȡ��������
    	//$this->assign('num',$num);
        //$data=array();
    	//$data=$this->getCommlist();//��ȡ�����б�
    	//$this->assign("commlist",$data);
        //$this->display('liuyan');
		$this->display();
    }

    /**
	*�������
    */
    public function addComment(){

    	/*$data=array();
    	if((isset($_POST["comment"]))&&(!empty($_POST["comment"]))){
    		$cm = json_decode($_POST["comment"],true);//ͨ���ڶ�������true����json�ַ���ת��Ϊ��ֵ������
    		$cm['create_time']=date('Y-m-d H:i:s',time());
    		$newcm = M('comment');
    		$id = $newcm->add($cm);

    		$cm["id"] = $id;
    		$data = $cm;

    		$num =  M('comment')->count();//ͳ����������
    		$data['num']= $num;

    	}else{
    		$data["error"] = "0";
    	}
    	

    	echo json_encode($data);*/
    }

    

    /**
	*�ݹ��ȡ�����б�
    */
    protected function getCommlist($parent_id = 0,&$result = array()){    	
    /*	$arr = M('comment')->where("parent_id = '".$parent_id."'")->order("create_time desc")->select();   
    	if(empty($arr)){
    		return array();
    	}
    	foreach ($arr as $cm) {  
    		$thisArr=&$result[];
    		$cm["children"] = $this->getCommlist($cm["id"],$thisArr);    
    		$thisArr = $cm; 				    	    		
    	}
    	return $result;*/
    }

}