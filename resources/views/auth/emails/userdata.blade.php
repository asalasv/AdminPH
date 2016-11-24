{{-- resources/views/emails/userdata.blade.php --}}

¡Hola!<br/><br/>

Gracias por utilizar PortalHook<br/><br/>

Tu usuario para administrar el Portal de tu local comercial ha sido creado satisfactoriamente.<br/><br/>

<b>Username:</b> {{ $user->username}}<br/>
<b>Password:</b> {{$pass}}<br/><br/>

Esperamos que el Dashboard de Administración sea de tu agrado.<br/><br/>

Feliz Dia.<br/><br/>

<img src="<?php echo $message->embed('img/logofinal.png'); ?>" style="height: 50px;">
