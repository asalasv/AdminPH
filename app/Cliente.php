<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
       'id_cliente','nombre','tax_number','alias','direccion','email','tipo_contrato','telefono','telefono_rep','representante','email_rep','id_usuario_web','password','logo','certifica_email','emailing_activo','ssid_wifi','fecha_activacion','id_tipo_cliente','tiempo_sesion','web_redir','id_sector'
    ];

    public $timestamps = false;

    protected $primaryKey = 'id_cliente';

}
