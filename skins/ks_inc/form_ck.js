function form_c(){
		var str="";
		$(".formstrck").each(function(index, element) {
		   var s_arr=$(this).attr("id").split("|%|");
		   var obj=$("#"+s_arr[1]);
		   if(s_arr[2]==1||s_arr[2]==2||s_arr[2]==10||s_arr[2]==9){
		   		if (obj.val()==""){
					if(s_arr[2]==9){
						$.dialog.alert("���ϴ�"+s_arr[0]+"!",function(){$(obj).focus();});
					}else{
						$.dialog.alert("������"+s_arr[0]+"!",function(){$(obj).focus();});
					} 
					str="n";
		   		}
		   }
        });
		if(str=="n"){
			return false;	
		}
}