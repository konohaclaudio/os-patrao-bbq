<?php

if(!$_POST) exit;

// Email address verification, do not edit.
function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

// Obtém os dados do formulário
$form_name     = $_POST['form_name'];
$email         = $_POST['email'];
$phone         = $_POST['phone'];
$no_of_persons = $_POST['no_of_persons'];
$event_date    = $_POST['event_date']; // Nome do campo 'date-picker' ajustado para 'event_date'
$occasion      = $_POST['occasion'];
$comments      = $_POST['comments'];

// Validação dos campos
if(trim($form_name) == '') {
	echo '<div class="error_message">Atenção! Você deve inserir seu nome.</div>';
	exit();
}  else if(trim($email) == '') {
	echo '<div class="error_message">Atenção! Por favor, insira um endereço de e-mail válido.</div>';
	exit();
} else if(!isEmail($email)) {
	echo '<div class="error_message">Atenção! O endereço de e-mail inserido é inválido, por favor tente novamente.</div>';
	exit();
} else if(trim($event_date) == '') {
    echo '<div class="error_message">Atenção! Por favor, insira a data do seu evento.</div>';
    exit();
}


// Configuração do e-mail
$address = "seuemail@exemplo.com"; // **IMPORTANTE**: Substitua este e-mail pelo e-mail de destino

$e_subject = 'Orçamento para Evento - Contato de ' . $form_name;

$e_body = "Você foi contatado por $form_name." . PHP_EOL . PHP_EOL;
$e_body .= "Detalhes do Contato:" . PHP_EOL;
$e_body .= "Nome: $form_name" . PHP_EOL;
$e_body .= "E-mail: $email" . PHP_EOL;
$e_body .= "Telefone/WhatsApp: $phone" . PHP_EOL;
$e_body .= "Número de Convidados: $no_of_persons" . PHP_EOL;
$e_body .= "Data do Evento: $event_date" . PHP_EOL;
$e_body .= "Tipo de Evento: $occasion" . PHP_EOL . PHP_EOL;
$e_body .= "Mensagem:" . PHP_EOL;
$e_body .= "\"$comments\"" . PHP_EOL . PHP_EOL;

$msg = wordwrap( $e_body, 70 );

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

if(mail($address, $e_subject, $msg, $headers)) {
	echo "<fieldset>";
	echo "<div id='success_page'>";
	echo "<h1>Solicitação Enviada com Sucesso.</h1>";
	echo "<p>Obrigado, <strong>$form_name</strong>. Sua mensagem foi enviada para nossa equipe. Em breve entraremos em contato.</p>";
	echo "</div>";
	echo "</fieldset>";
} else {
	echo 'ERRO! Não foi possível enviar a mensagem.';
}

?>
