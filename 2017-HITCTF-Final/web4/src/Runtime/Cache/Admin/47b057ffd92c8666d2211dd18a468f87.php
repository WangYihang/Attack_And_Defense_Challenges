<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台用户管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='/Public/css/admin-style.css' />
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/jquery/jquery-1.7.2.min.js"></script>
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/js/admin.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/editor/kindeditor-min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/editor/zh_CN.js"></script>
<script language="javascript">
$(document).ready(function(){
	$("#myform").submit(function(){
		if($gxlcms.form.empty('myform','ting_name') == false){
			return false;
		}
		if($("#ting_cid").val()==0){
			alert('请选择分类');
			return false;
		}
	});
	$("#tabs>a").click(function(){
		var no = $(this).attr('id');
		var n = $("#tabs>a").length;
		showtab('tabs',no,n);
		$("#tabs>a").removeClass("on");
		$(this).addClass("on");
		return false;
	});
	$("#getreid").click(function(){
			if($("#reid").val()!=''){
			window.open('index.php?s=Admin-Member-getComment-id-<?php echo ($ting_id); ?>-vid-'+$("#reid").val());
			}																			
	});	
	$("#getreurl").click(function(){					  
			if($("#ting_qreurl").val()!=''){
			var s = $("#ting_qreurl").val();
			s = s.replace(/\//g,"@");
			window.open('index.php?s=Admin-Member-getComment-id-<?php echo ($ting_id); ?>-url-'+s);
			}																			
	});	
	$("#anchorall").click(function(){					  
			if($("#anchor_reurl").val()!=''){
			var s = $("#anchor_reurl").val();
			s = s.replace(/\//g,"@");
			window.open('index.php?s=Admin-Getanchor-index-vid-<?php echo ($ting_id); ?>-url-'+s);
			}																			
	});
	$("#getseo").click(function(){					  
			if($("#ting_skeywords").val()!=''){
			$.post("index.php?s=Admin-Get-seo",{name:$("#ting_skeywords").val(),}, function(data){
				var o = eval("("+data+")");
				$("#ting_skeywords").val(o.keywords);
			});
			//alert(val(o));
		}
		else if ($("#ting_name").val()!=''){
			$.post("index.php?s=Admin-Get-seo",{name:$("#ting_name").val(),}, function(data){
				var o = eval("("+data+")");
				$("#ting_skeywords").val(o.keywords);
			});
}
	});	
		
	
		
});	

function changeCat(id){
	$.ajax({
		type:'get',
		url:'?s=Admin-Ting-Ajaxcat-id-'+id,
		success:function(html){
			$("#ting_cat_list").html(html);
		}
	})
}
</script>
</head>
<body class="body">
<!--图片预览框-->
<div id="showpic" class="showpic" style="display:none;"><img name="showpic_img" id="showpic_img" width="120" height="160"></div>

<?php if(($ting_id) > "0"): ?><form name="update" action="?s=Admin-Ting-Update" method="post" name="myform" id="myform">
<input type="hidden" name="ting_id" value="<?php echo ($ting_id); ?>">
<?php else: ?>
<form name="add" action="?s=Admin-Ting-Insert" method="post" name="myform" id="myform"><?php endif; ?> 
<div class="title">
	<div class="tabs" id="tabs"><a href="javascript:void(0)" class="on" id="1">作品<?php echo ($ting_templatename); ?><a href="javascript:void(0)" id="2">其它设置</a></div>
    <div class="right"><a href="?s=Admin-Ting-Show">返回作品管理</a></div>
</div>
<div class="form">
<table border="0" cellpadding="0" cellspacing="0" class="table" id="tabs1">
  <tr>
 <td class="tl">作品名称：</td>
    <td class="tr">    <input type="text" name="ting_name" id="ting_name" value="<?php echo ($ting_name); ?>" maxlength="255" error="* 名称不能为空" class="w300 ti_5">
    <label><select name="ting_cid" id="ting_cid" style="width:100px" onchange="changeCat(this.value)"><option value=0>选择分类</option><?php if(is_array($listting)): $i = 0; $__LIST__ = $listting;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $ting_cid): ?>selected<?php endif; ?>><?php echo ($ppting["list_name"]); ?></option><?php if(is_array($ppting['son'])): $i = 0; $__LIST__ = $ppting['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $ting_cid): ?>selected<?php endif; ?>>├ <?php echo ($ppting["list_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?></select></label>  <label><select name="ting_status"><option value="1">显示</option><option value="0" <?php if(($ting_status) == "0"): ?>selected<?php endif; ?>>隐藏</option></select></label> <label><select name="ting_language" id="ting_language" class="w70"><?php if(!empty($ting_language)): ?><option value='<?php echo ($ting_language); ?>'><?php echo ($ting_language); ?></option><?php endif; ?><option value=''>对白</option><?php if(is_array($ting_language_list)): $i = 0; $__LIST__ = $ting_language_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val); ?>"><?php echo ($val); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select></label> 作品时长：<label><input type="text" name="ting_length" id="ting_length" maxlength="3" value="<?php echo ($ting_length); ?>" class="w50 ct" title="单位：分钟"></label></td>
      
  </tr>

  <tr>

  <tr>
    <td class="tl">作品备注：</td>
    <td class="tr"><input type="text" name="ting_title" id="ting_title" maxlength="255" value="<?php echo ($ting_title); ?>" class="w300 ti_5"> 
	</td>
  </tr>
 <tr>
    <td class="tl">作品拼音：</td>
    <td class="tr"><input type="text" name="ting_letters" id="ting_letters" maxlength="255" value="<?php echo ($ting_letters); ?>" class="w300 ti_5"> 
	</td>
  </tr>
    <tr >
    <td class="tl" >更新日期：</td>
    <td class="tr" style="position:relative"><label><input type="text" name="ting_addtime" id="ting_addtime" value="<?php echo (date('Y-m-d H:i:s',$ting_addtime)); ?>" class="w120"> <input name="checktime" type="checkbox" style="border:none;width:auto; position:absolute; top:5px" value="1" <?php echo ($checktime); ?> title="勾选则使用系统当前时间"></label> 
&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;推送到百度<input name="insertseo" type="checkbox" style="border:none;width:auto; position:absolute; top:5px"  value="5" title="勾选推送到百度"></td></td>
  </tr>
  <tr >
    <td class="tl">作品主播：</td>
    <td class="tr" id="anchor_<?php echo ($ting_id); ?>" style="position:relative"><input type="text" name="ting_anchor" id="ting_anchor" maxlength="255" value="<?php echo ($ting_anchor); ?>" class="w300 ti_5" title="可使用半角逗号,分隔">&nbsp;&nbsp;<a  href="javascript:showanchors('<?php echo ($ting_id); ?>');"  ></a></td>
  </tr>
  <tr>
    <td class="tl">作品作者：</td>
    <td class="tr"><input type="text" name="ting_author" id="ting_author" maxlength="255" value="<?php echo ($ting_author); ?>" class="w300 ti_5"> 
	</td>
  </tr>                
  <tr>
    <td class="tl">海报剧照：</td>
    <td class="tr"><label style="float:left; margin-top:3px; margin-right:5px"><input type="text" name="ting_pic" id="ting_pic" maxlength="255" value="<?php echo ($ting_pic); ?>" class="w300 ti_5" onMouseOver="if(this.value)showpic(event,this.value,'<?php echo (C("upload_path")); ?>/');" onMouseOut="hiddenpic();"></label><iframe src="?s=Admin-Upload-Show-sid-ting" scrolling="no" topmargin="0" width="280" height="26" marginwidth="0" marginheight="0" frameborder="0" align="left" style="margin-top:3px; float:left"></iframe></span></td>
  </tr>
  <tr>
    <td class="tl">作品TAG：</td>
    <td class="tr"><input type="text" name="ting_keywords" id="ting_keywords"  maxlength="255" value="<?php echo ($ting_keywords); ?>" class="w300 xy_tag ti_5"> <img src="/Public/images/admin/edit.gif" onClick="javascript:showtags(1);" class="navpoint" ></td>
  </tr>
  <script language="javascript">
	var $urln=<?php echo count($ting_url);?>;
	function addurl(){
		var $old = $("#urllist>tr:last").html();
		$urln = $("#urllist>tr").length;
		$old = $old.replace("播放地址"+$urln,"播放地址"+($urln+1));
		$("#urllist>tr:last-child").after('<tr>'+$old+'</tr>');
		$("#urllist>tr:last #ting_play").val($("#ting_play:last option").val());
		$("#urllist>tr:last #ting_server").val($("#ting_server:last option").val());
		$("#urllist>tr:last textarea").val('');
	}
	  </script>
	 <script language="javascript">
	 var $urldn=<?php echo count($ting_ff);?>;
	function shangchuanurl(){
		var $old = $("#sclist>tr:last").html();
		
		$urln = $("#sclist>tr").length;
		$old = $old.replace($urln,($urln+1));
		$old = $old.replace("gvid-"+$urln,"gvid-"+($urln+1));
		$old = $old.replace("ting_zj"+$urln,"ting_zj"+($urln+1));
		$old = $old.replace("<tr style='display:none'>"+$urln,"<tr>"+($urln+1));
		$("#sclist>tr:last-child").after('<tr>'+$old+'</tr>');
		$("#sclist>tr:last #ting_play").val($("#ting_play:last option").val());
		$("#sclist>tr:last #ting_server").val($("#ting_server:last option").val());
		$("#sclist>tr:last textarea").val('');
	}
  </script>
  <!--地址列表 -->
  <tbody id="urllist">

  <?php if(is_array($ting_url)): $uu = 0; $__LIST__ = $ting_url;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$url): $mod = ($uu % 2 );++$uu; $playername=$ting_play[$uu-1];$serverdown=$ting_server[$uu-1]; ?>
  <tr>
    <td class="tl">播放地址<?php echo ($uu); ?><br /></td>
    <td class="tr" style="padding-bottom:5px"><select name="ting_play[]" id="ting_play" ><?php if(is_array($ting_play_list)): $i = 0; $__LIST__ = $ting_play_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$play): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $playername): ?>selected<?php endif; ?>><?php echo ($i); ?>.<?php echo ($key); ?>.<?php echo ($play[1]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select> <select name="ting_server[]" id="ting_server" style="width:140px"><option value="">不使用公共前缀</option><?php if(is_array($ting_server_list)): $i = 0; $__LIST__ = $ting_server_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$server): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $serverdown): ?>selected<?php endif; ?>><?php echo ($server); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select> <label style=" color:#666666">注：自定义分集名称用"$"分隔，一行一集播放地址，留空则删除该组地址。</label><br><textarea name='ting_url[]' style="width:98%;height:150px;color:#333333" ><?php echo ($url); ?></textarea></td>
  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    
  </tbody>
 <tbody id="sclist" >


  <tr style='display:none'>
    <td class="tl">上传地址<?php echo ($i); ?><br /></td>
    <td class="tr" style="padding-bottom:5px"><select name="ting_play[]" id="ting_play" ><?php if(is_array($ting_play_list)): $i = 0; $__LIST__ = $ting_play_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$play): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $playername): ?>selected<?php endif; ?>><?php echo ($i); ?>.<?php echo ($key); ?>.<?php echo ($play[1]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select> <select name="ting_server[]" id="ting_server" style="width:140px"><option value="">不使用公共前缀</option><?php if(is_array($ting_server_list)): $i = 0; $__LIST__ = $ting_server_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$server): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $serverdown): ?>selected<?php endif; ?>><?php echo ($server); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select> <label style=" color:#666666">注：自定义分集名称用"$"分隔，一行一集播放地址，留空则删除该组地址。</label><br><textarea name='ting_gxl[]'  id='ting_zj<?php echo ($i); ?>' style="width:98%;height:20px;color:#333333" ></textarea>
	
	<iframe src="?s=Admin-Upload-sc-sid-<?php echo ($ting_id); ?>-gvid-<?php echo ($i); ?>" scrolling="no" topmargin="0" width="280" height="35" marginwidth="0" marginheight="0" frameborder="0" align="left" style="margin-top:3px; float:left"></iframe></td>
  </tr> 



    
  </tbody>
  <!-- --> 
    <tr>
    <td class="tl">上传播放地址：</td>
    <td class="tr"><a href="javascript:shangchuanurl();" style="color:#FF0000;font-weight:bold;font-size:14px"><img src="/Public/images/admin/add.gif" border="0">继续添加上传文件</a>(上传成功后提交作品后自动更新到播放地址里)</td>
  </tr> 
  
   
     <tr>
    <td class="tl">作品简介：</td>
    <td class="tr padding-5050"><textarea name="ting_content" id="content" style="width:99%;height:300px;"><?php echo ($ting_content); ?></textarea></td>
  </tr>    
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table" id="tabs2" style="display:none">
  <tr>
    <td class="tl">推荐星级：</td>
    <td class="tr" id="abc"><input name="ting_stars" id="ting_stars" type="hidden" value="<?php echo ($ting_stars); ?>"><?php if(is_array($ting_starsarr)): $i = 0; $__LIST__ = $ting_starsarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ajaxstar): $mod = ($i % 2 );++$i;?><img src="/Public/images/admin/star<?php echo ($ajaxstar); ?>.gif" onClick="addstars('ting',<?php echo ($i); ?>);" id="star_<?php echo ($i); ?>" class="navpoint"><?php endforeach; endif; else: echo "" ;endif; ?></td>
  </tr>  
  <tr>
    <td class="tl">标题颜色：</td>
    <td class="tr" id="abc"><select name="ting_color" id="ting_color" class="w70">
    <?php if(!empty($ting_color)): ?><option value='<?php echo ($ting_color); ?>'><?php echo ($ting_color); ?></option><?php endif; ?><option value="">颜色</option>                               
    <option value='#000000' style='background-color:#000000' <?php if(($ting_color) == "#000000"): ?>selected<?php endif; ?>></option>
    <option value='#FFFFFF' style='background-color:#FFFFFF' <?php if(($ting_color) == "#FFFFFF"): ?>selected<?php endif; ?>></option>
    <option value='#008000' style='background-color:#008000' <?php if(($ting_color) == "#008000"): ?>selected<?php endif; ?>></option>
    <option value='#FFFF00' style='background-color:#FFFF00' <?php if(($ting_color) == "#FFFF00"): ?>selected<?php endif; ?>></option>
    <option value='#FF0000' style='background-color:#FF0000' <?php if(($ting_color) == "#FF0000"): ?>selected<?php endif; ?>></option>
    <option value='#0000FF' style='background-color:#0000FF' <?php if(($ting_color) == "#0000FF"): ?>selected<?php endif; ?>></option>
    <option value=''>无色</option></select></td>
  </tr>
  <tr>
    <td class="tl">首字母：</td>
    <td class="tr"><input type="text" name="ting_letter" id="ting_letter" value="<?php echo ($ting_letter); ?>" maxlength="1" class="w50"></td>
  </tr>
  <tr>
    <td class="tl">总人气：</td>
    <td class="tr"><input type="text" name="ting_hits" id="ting_hits" maxlength="15" value="<?php echo ($ting_hits); ?>" class="w50"></td>
  </tr>       
  <tr>
    <td class="tl">月人气：</td>
    <td class="tr"><input type="text" name="ting_hits_month" id="ting_hits_month" maxlength="15" value="<?php echo ($ting_hits_month); ?>" class="w50"></td>
  </tr> 
  <tr>
    <td class="tl">周人气：</td>
    <td class="tr"><input type="text" name="ting_hits_week" id="ting_hits_week" maxlength="15" value="<?php echo ($ting_hits_week); ?>" class="w50"></td>
  </tr>
  <tr>
    <td class="tl">日人气：</td>
    <td class="tr"><input type="text" name="ting_hits_day" id="ting_hits_day" maxlength="15" value="<?php echo ($ting_hits_day); ?>" class="w50"></td>
  </tr> 
  <tr>
    <td class="tl">评分值：</td>
    <td class="tr"><input type="text" name="ting_gold" id="ting_gold" value="<?php echo ($ting_gold); ?>" maxlength="4" class="w50"></td>
  </tr> 
  <tr>
    <td class="tl">评分人数：</td>
    <td class="tr"><input type="text" name="ting_golder" id="ting_golder" value="<?php echo ($ting_golder); ?>" maxlength="8" class="w50"></td>
  </tr> 
  <tr>
    <td class="tl">顶：</td>
    <td class="tr"><input type="text" name="ting_up" id="ting_up" value="<?php echo ($ting_up); ?>" maxlength="8" class="w50"></td>
  </tr>
  <tr>
    <td class="tl">踩：</td>
    <td class="tr"><input type="text" name="ting_down" id="ting_down" value="<?php echo ($ting_down); ?>" maxlength="8" class="w50"></td>
  </tr>
  <tr>
    <td class="tl">录入编辑：</td>
    <td class="tr"><input type="text" name="ting_inputer" id="ting_inputer" value="<?php echo ($ting_inputer); ?>" maxlength="15" class="w150"></td>
  </tr>   
  <tr>
    <td class="tl">独立模板：</td>
    <td class="tr"><input type="text" name="ting_skin" id="ting_skin" value="<?php echo ($ting_skin); ?>" maxlength="25" class="w150"></td>
  </tr>  
  <tr>
    <td class="tl">来源：</td>
    <td class="tr"><input type="text" name="ting_reurl" id="ting_reurl" value="<?php echo ($ting_reurl); ?>" maxlength="150" class="w300"></td>
  </tr>
      <tr>              
  <tr>
    <td class="tl">跳转URL：</td>
    <td class="tr"><input type="text" name="ting_jumpurl" id="ting_jumpurl" value="<?php echo ($ting_jumpurl); ?>" maxlength="150" class="w300"></td>
  </tr>  
</table>


<table border="0" cellpadding="0" cellspacing="0" class="table" id="tabs4" style="display:none">
  <td class="tl">作品拼音url：</td>
    <td class="tr"><input type="text" name="ting_letters" id="ting_letters" value="<?php echo ($ting_letters); ?>" maxlength="150" class="w300"></td>
  </tr>

</table>

<ul class="footer">
	<input type="submit" name="submit" value="提交"> <input type="reset" name="reset" value="重置">
</ul>
</div>
</form>



<style>
#dia_title{height:25px;line-height:25px}
.jqmWindow{height:500px;width:850px;top:5px;left:310px;overflow:hidden;}
</style>

</body>
</html>