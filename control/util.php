<?php
function panel($view,$data){
	if(file_exists("view/panel/{$view}.php")){
			ob_start();
			require_once "view/panel/{$view}.php";
			$page=ob_get_clean();
			foreach($data as $key=>$val){
				$page=str_replace("%".$key."%",$val,$page);
			}
			echo $page;
	}
}
function send($page,$view=null){
	if(empty($view)){
		$page=1;
		$view="home";
	}
	if($page){
		require_once "control/html/begin.htm";
		if(file_exists("view/page/{$view}.php")){
			require_once "view/page/{$view}.php";
		}
		else{
			require_once "view/page/404.php";
		}
		require_once "control/html/end.htm";
		$page=ob_get_clean();
		global $CONF;
		$page=str_replace("%DESCRIPTION%",$CONF["app.description"],$page);
		$page=str_replace("%FONT%",$CONF["app.font"],$page);
		if($view=="home"){
			echo str_replace("%TITLE%",$CONF["app.title"]." | ".$CONF["app.description"],$page);
		}
		else{
			if(empty($CONF["page.title"])){
				echo str_replace("%TITLE%",ucfirst($view)." | ".$CONF["app.title"],$page);
			}
			else{
				echo str_replace("%TITLE%",$CONF["page.title"]." | ".$CONF["app.title"],$page);
			}
		}
	}
	else{
		if(file_exists("view/json/{$view}.php")){
			require_once "view/json/{$view}.php";
		}
		else{
			send(1);
		}
	}
}
?>
