<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';
	require 'phpmailer/src/SMTP.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	/*
	$mail->isSMTP();                                            //Send using SMTP
	$mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	$mail->Username   = 'user@example.com';                     //SMTP username
	$mail->Password   = 'secret';                               //SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
	$mail->Port       = 465;                 
	*/

	//От кого письмо
	$mail->setFrom('info@vaskeptik.site', 'Client'); // Указать нужный E-mail
	//Кому отправить
	$mail->addAddress('code@vaskeptik.site'); // Указать нужный E-mail
	//Тема письма
	$mail->Subject = 'Привіт! Є робота!';

	//Тело письма
	$body = '<h1>Нова заявка!</h1>';

	if(trim(!empty($_POST['Email']))){
		$body.='<p><strong>E-mail:</strong> '.$_POST['Email'];
	}	
	if(trim(!empty($_POST['Phone']))){
		$body.='<p><strong>Телефон:</strong> '.$_POST['Phone'];
	}	
	if(trim(!empty($_POST['textArea']))){
		$body.='<p><strong>Сообщение:</strong> '.$_POST['textArea'].'</p>';
	}
	
	/*
	//Прикрепить файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//путь загрузки файла
		$filePath = __DIR__ . "/files/sendmail/attachments/" . $_FILES['image']['name']; 
		//грузим файл
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Фото в приложении</strong>';
			$mail->addAttachment($fileAttach);
		}
	}
	*/

	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Ошибка';
	} else {
		$message = 'Данные отправлены!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>