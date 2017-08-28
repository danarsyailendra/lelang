<?php
if(file_exists("mail.class.php"))
	include_once("mail.class.php");
	
$to="danar.arga@metra.co.id";
$cc="";
$from="iyan.yudhistira@metra.co.id";
$notes="tes mis public";
	
//par=to|type|body_include?|docid/project_name|subject|body,
//par=10|RFI|0|70110|revisi|revisi,	

$par='10|RFI|1|TES MIS PUBLIC|revisi|revisi';	
$mail=send_mail($to,$cc,$from,$notes,$par,'CO');

echo 'STATUS: '.$mail['STATUS'].' '.$mail['INFO'];

?>



