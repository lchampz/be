<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = "PEDIDO";
    protected $primaryKey = "PEDIDO_ID";
    public $timestamps = false;

    protected $fillable = [
        'USUARIO_ID',
        'ENDERECO_ID',
        'STATUS_ID',
        'PEDIDO_DATA'
    ];

    public function Usuario() {
        return $this->belongsTo(Usuario::class, "USUARIO_ID", "USUARIO_ID");
    }

    public function Endereco() {
        return $this->belongsTo(Endereco::class, "ENDERECO_ID", "ENDERECO_ID");
    }

    public function Status() {
        return $this->belongsTo(StatusPedido::class, "STATUS_ID", "STATUS_ID");
    }

}
