$(function(){

	//����ύ��������
	$('body').delegate('.comment-submit','click',function(){	
		var content = $.trim($(this).parent().prev().children("textarea").val());//���ݲ��ֽṹ��ȡ��ǰ��������
		$(this).parent().prev().children("textarea").val("");//��ȡ�����ݺ���������
		if(""==content){
			alert("�������ݲ���Ϊ��!");		
		}else{
			var cmdata = new Object();
			cmdata.parent_id = $(this).attr("parent_id");//�ϼ�����id
			cmdata.content = content;
			cmdata.nickname = "�ο�";//����������
			cmdata.head_pic = "/Public/images/default.jpg";//����������				
			var replyswitch = $(this).attr("replyswitch");//��ȡ�ظ�����������
			
			$.ajax({
				type:"POST",
				url:"/index.php/home/index/addComment",
				data:{
					comment:JSON.stringify(cmdata)				
				},
				dataType:"json",			
				success:function(data){
					if(typeof(data.error)=="undefined"){
						$(".comment-reply").next().remove();//ɾ���Ѵ��ڵ����лظ�div	
						//������������						
						$(".comment-num").children("span").html(data.num+"������");
						//��ʾ��������
						var newli = "";						
						if(cmdata.parent_id == "0"){
						 //�������һ������ʱ����ӵ�һ��ul�б���						 
						 newli = "<li comment_id='"+data.id+"'><div ><div><img class='head-pic'  src='"+data.head_pic+"' alt=''></div><div class='cm'><div  class='cm-header'><span>"+data.nickname+"</span><span>"+data.create_time+"</span></div><div class='cm-content'><p>"+data.content+"</p></div><div class='cm-footer'><a class='comment-reply' comment_id='"+data.id+"'  href='javascript:void(0);'>�ظ�</a></div></div></div><ul class='children'></ul></li>";							
							$(".comment-ul").prepend(newli);
						}else{
						 //������ӵ���Ӧ�ĺ���ul�б���							 
						 	if('off'==replyswitch){//������ظ��ر������ڣ����������۲����ṩ�ظ�����						 	
						 		newli = "<li comment_id='"+data.id+"'><div ><div><img class='head-pic'  src='"+data.head_pic+"' alt=''></div><div class='children-cm'><div  class='cm-header'><span>"+data.nickname+"</span><span>"+data.create_time+"</span></div><div class='cm-content'><p>"+data.content+"</p></div><div class='cm-footer'></div></div></div><ul class='children'></ul></li>";
						 	}else{//�������۵Ļظ���ťҪ��ӻظ��ر�������					 	
						 		newli = "<li comment_id='"+data.id+"'><div ><div><img class='head-pic'  src='"+data.head_pic+"' alt=''></div><div class='children-cm'><div  class='cm-header'><span>"+data.nickname+"</span><span>"+data.create_time+"</span></div><div class='cm-content'><p>"+data.content+"</p></div><div class='cm-footer'><a class='comment-reply' comment_id='"+data.id+"'  href='javascript:void(0);' replyswitch='off' >�ظ�</a></div></div></div><ul class='children'></ul></li>";
						 	}						 	
						 	$("li[comment_id='"+data.parent_id+"']").children("ul").prepend(newli);
						}

					}else{
						//�д�����Ϣ
						alert(data.error);
					}
					
				}
			});
		}
		

	});

	

	//���"�ظ�"��ť��ʾ�����ػظ������
	$("body").delegate(".comment-reply","click",function(){
		if($(this).next().length>0){//�жϳ��ظ�div�Ѿ�����,ȥ����
		 	$(this).next().remove();
		 }else{//��ӻظ�div
		 	$(".comment-reply").next().remove();//ɾ���Ѵ��ڵ����лظ�div	
		 	//��ӵ�ǰ�ظ�div
		 	var parent_id = $(this).attr("comment_id");//Ҫ�ظ�������id
		 	
		 	var divhtml = "";
		 	if('off'==$(this).attr("replyswitch")){//�������ۻظ����������۲����ṩ�ظ�����,���ر����Ը��ӵ�"�ύ�ظ�"��ť"
		 		divhtml = "<div class='div-reply-txt' style='width:98%;padding:3px;' replyid='2'><div><textarea class='txt-reply' replyid='2' style='width: 100%; height: 60px;'></textarea></div><div style='margin-top:5px;text-align:right;'><a class='comment-submit'  parent_id='"+parent_id+"' style='font-size:14px;text-decoration:none;background-color:#63B8FF;' href='javascript:void(0);' replyswitch='off' >�ύ�ظ�</a></div></div>";
		 	}else{
		 		divhtml = "<div class='div-reply-txt' style='width:98%;padding:3px;' replyid='2'><div><textarea class='txt-reply' replyid='2' style='width: 100%; height: 60px;'></textarea></div><div style='margin-top:5px;text-align:right;'><a class='comment-submit'  parent_id='"+parent_id+"' style='font-size:14px;text-decoration:none;background-color:#63B8FF;' href='javascript:void(0);'>�ύ�ظ�</a></div></div>";
		 	}		 	
			$(this).after(divhtml);
		 }
	});

})