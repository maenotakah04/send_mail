<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>メールを送るよ</title>
</head>
<body>
<?php

if (isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['comment'])){

// PHPMailerライブラリ
require './phpmailer/Exception.php';
require './phpmailer/PHPMailer.php';
require './phpmailer/SMTP.php';

//送信処理
$mail = new PHPMailer\PHPMailer\PHPMailer(true);          // Passing `true` enables exceptions
try {
    //Server settings
    $mail->CharSet = 'utf-8';                             //日本語対応
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = '<gmailアドレス>';                 // SMTP username
    $mail->Password = '<gmailパスワード>';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('<gmailアドレス(送信者アドレス)>');
    $mail->addAddress($_POST['email']);     // Add a recipient
    $mail->addReplyTo('<gmailアドレス(返信先アドレス>');

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['comment'];
    $mail->send();

    //送信結果表示
    echo '<p>以下の内容で送信しました。</p>';
    echo '<p>宛先</p>';
    echo '<p>'.$_POST['email'].'</p>';
    echo '<p>件名</p>';
    echo '<p>'.$_POST['subject'].'</p>';
    echo '<p>本文</p>';
    echo '<p>'.$_POST['comment'].'</p>';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
} else {
    echo "<p>宛先メールアドレスと本文を入力してください。</p>";
}
?>

<!-- フォーム -->
<form action="sendmail.php" method="post">
  <label class="label" for="e-mail">宛先メールアドレス</label>
  <input id="e-mail" type="email" name="email">
  <label class="label" for="subject">件名</label>
  <input id="subject" type="text" name="subject">
  <label class="label" for="message">本文</label>
  <textarea rows="4" id="message" placeholder="ご意見をお寄せ下さい。" name="comment"></textarea>
  <input type="submit">
</form>

<!-- フォームスタイル -->
<style>
form label {
 display: block;
}
form input{
  display: block;
  width:300px;
}
form textarea {
  display: block;
  width:300px;
  height:200px;
}
form input[type=submit]{
 margin-top:10px;
  width:300px;
}
</style>

</body>
</html>