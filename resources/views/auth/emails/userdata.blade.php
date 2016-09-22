{{-- resources/views/emails/userdata.blade.php --}}

Hello.<br/><br/>

Gracias por utilizar PortalHook!<br/><br/>

Su usuario para administrar su Portal ha sido creado satisfactoriamente. Estas son tus credenciales:<br/><br/>

<b>Username:</b> {{ $user->username}}<br/>
<b>Password:</b> {{$pass}}<br/><br/>

Esperamos que el Dashboard de Administración sea de su agrado.<br/><br/>

Feliz Dia.<br/><br/>

<img src="<?php echo $message->embed('img/logofinal.png'); ?>" style="height: 50px;">
