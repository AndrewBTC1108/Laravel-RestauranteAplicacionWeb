<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total'
    ];

    //relacion inversa, con el fin de obtener el Usuario al que pertenece un Pedido
    public function user()
    {
        //pertenece a
        return $this->belongsTo(User::class);
    }

    //relacion de muchos a muchos, muchos productos pertenecen a un solo pedido
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedido_productos')->withPivot('cantidad'); //agregar al objeto cantidad
    }
}
