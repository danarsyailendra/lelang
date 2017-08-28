<?php

require_once('smtp.class.php');
require_once('phpmailer.class.php');
    
function send_mail($to, $cc, $from, $pass, $name) {
		
    $body = "   <p><h1>REMINDER</h1></p>
        <p>Dear " . $name . "</p>
                <p>Berkaitan dengan adanya agenda lelang barang-barang di lantai 33 dan 37, maka bersama ini diinformasikan bahwa:<br>
                <ol>
                <li>Lelang akan dilaksanakan secara online dengan alamat http://10.15.16.51/lelang 
                                    (koneksi LAN kantor) atau http://118.97.63.84/lelang (koneksi diluar kantor)</li>
		<li>Username : $to</li>
                <li>Password : $pass</li></ol></p>
				<p>Demikian informasi dari kami dan terimakasih atas partisipasinya</p>
				
				<br><br>
				
				<p>
                                    Best Regards,<br>
                                    GA Manager
                                </p>";
					
		
		
	
    $mail = new PHPMailer();

	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = "mail.metra.co.id";
	//$mail->Host = "10.9.9.2";	
	$mail->Port = 25;
	$mail->Username = "support@metra.co.id";
	$mail->Password = "Metra123";
	
	$arr_to = explode(",", $to);
    foreach ($arr_to as $v_to) {
		$mail->addAddress(trim($v_to));
	}	
	
	$arr_cc = explode(",", $cc);
    foreach ($arr_cc as $v_cc) {
		$mail->addCC(trim($v_cc));
	}
	
	$mail->SetFrom($from, $from);
	$mail->Subject = '[REMINDER] Informasi Lelang barang-barang lantai 33 dan 37';
	
	$mail->MsgHTML($body);
	
	
	if (!$mail->send()) {
        $response = array("STATUS" => "Error", "INFO" => $mail->ErrorInfo);
	} else {
        $response = array("STATUS" => "OK", "INFO" => "Sent " . date("d M Y, H:i:s"));
	}
		
	return $response;
}


?>



