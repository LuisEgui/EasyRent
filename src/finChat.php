<?php 
		if (file_exists('msg.txt')) {
		   $f = fopen('msg.txt',"w+");
           fwrite($f,"");
           fclose($f);
		} 
?>	
