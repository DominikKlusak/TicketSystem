<?php


function how_len($text, $limit) {
    
    $text = trim($text);
    $text = strip_tags($text);
    
    $how = strlen($text);
    
    if ($how > $limit) {
        $text = substr($text, 0, $limit - 3) . '...';
    }
    
    return $text;
}



function sendMail($temat, $tresc, $email) {
	
	$sent = false;

	
		
	if ($temat != "" && $tresc != "")
	{
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			require_once('phpmailer/PHPMailerAutoload.php');
			$mail = new PHPMailer();
                $mail->IsSMTP(); 
                $mail->IsHTML(true);
                $mail->Host = "poczta.interia.pl";
                $mail->From = "mojnowysklep1@interia.pl";
                $mail->AddAddress($email);
                //$mail->SMTPDebug = true;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';
                $mail->Port = "465";
                $mail->Username = "mojnowysklep1@interia.pl";
                $mail->Password = "Pracamagisterska!!!!";
                $mail->setFrom("Nowy sklep");
                $mail->FromName = "Nowy sklep";
                $mail->Subject = $temat;
                $mail->CharSet = 'UTF-8';
                $mail->Body = $tresc;
                $mail->WordWrap = 50;
						
			if($mail->Send()) {
				$sent = true;							
			} else {
				$sent = $mail->ErrorInfo;
			}

		}
		
	}
	
	return $sent;
	
}



function validInput($str, $type)
{
	
	$str = trim($str);
	
	
	if ($type == 'string') {
		$str = filter_var($str, FILTER_SANITIZE_STRING);
		$valid =  preg_match('/^[a-zA-Z0-9ąćęńśłóźżĄĆĘŃŚÓŁŹŻ\+\&\;\-\.\,\/ ]+$/', $str);
	} else if ($type == 'int'){
		$str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
		$valid = preg_match("/^[0-9]+$/i", $str);
	} else if ($type == 'password') {
		
		$chars = preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,40}$/", $str);
								
		if(!$chars/*!$specialChars || !$lowercase || !$number || strlen($str) < 8*/) {
			$valid = false;
		} else { 
			$valid = true;
		}
		
	}
	else if ($type == 'email') {
		
		$str = filter_var($str, FILTER_SANITIZE_EMAIL);
		
		if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
			$valid = true;
		} else {
			$valid = false;
		}
	}
	
	else if ($type == 'pesel') {
		
		$str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
		if (preg_match("/^[0-9]+$/i", $str) && (strlen($str) == 11)) {
			$valid = true;
		} else {
			$valid = false;
		}

	}
	
	$x = ($valid) ? true : false;
	
	return $x;
	
}


function plCharset($string) {

$polskie = array('ę', 'Ę', 'ó', 'Ó', 'Ą', 'ą', 'Ś', 'ś', 'ł', 'Ł', 'ż', 'Ż', 'Ź', 'ź', 'ć', 'Ć', 'ń');
$miedzyn = array('e', 'E', 'o', 'O', 'A', 'a', 'S', 's', 'l', 'L', 'z', 'Z', 'Z', 'z', 'c', 'C', 'n');
$string = str_replace($polskie, $miedzyn, $string);


return $string;
}

function clean($str)
{       
		$str = utf8_decode($str);
		$str = str_replace("&nbsp;", " ", $str);
		$str = preg_replace('/\s+/', ' ',$str);
		$str = trim($str);
	return $str;
}


function generateRandomString($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
			for ($i = 0; $i < $length; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
	return $randomString;
}



?>