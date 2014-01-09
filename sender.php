<html>
	<head></head>
	<body>
		<form action="<?php echo basename(__FILE__);  ?>" method="post">
<?php

$file = "20130326.html";

if (isset($_POST["validate_send"])) {
	require(dirname(__FILE__) . DIRECTORY_SEPARATOR . "phpmailer" . DIRECTORY_SEPARATOR . "class.phpmailer.php");
	
	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465;
	$mail->Username = "anichols@acsc.net";
	$mail->Password = "AndersonHJHS11";
	
	$mail->SetFrom("anichols@ascs.net", "Annie Nichols");
	$mail->Subject = "Talk It Out! - Practical Applications for AAC Use";
	
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
	$mail->MsgHTML(file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . $file));
	
	$fh = fopen(dirname(__FILE__) . DIRECTORY_SEPARATOR . "recipients.rcpt", "r");
	
	if ($fh) {
		while (($buffer = fgets($fh, 4096)) !== false) {
			$mail->AddAddress($buffer);
			if(!$mail->Send()) {
				echo "Message was not sent.";
				echo "Mailer error: " . $mail->ErrorInfo;
			} else {
				echo "Message has been sent: {$buffer}.<br>";
			}
			$mail->ClearAddresses();
		}
		if (!feof($fh)) {
			echo "Error: unexpected fgets() fail\n";
		}
		fclose($fh);
	}
} else {
	echo "<p>Sending <a href=\"{$file}\" target=\"_blank\">{$file}</a>. Does that file name seem to match todays date?</p>";
	echo "<input type=\"submit\" value=\"Send Newsletter\" name=\"validate_send\">";
}

?>
		</form>
	</body>
</html>