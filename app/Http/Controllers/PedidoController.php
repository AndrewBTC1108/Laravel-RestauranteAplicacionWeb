<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoCollection;
use Carbon\Carbon;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Al ser json y como hay una relacion, para añadirlo se hace con un with y se le coloca el metodo de relacion
        return new PedidoCollection(Pedido::with('user')->with('productos')->where('estado', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Almacenar un pedido
        $pedido = new Pedido; //instanciamos clase Pedido
        $pedido->user_id = Auth::user()->id; //obtener el id
        $pedido->total = $request->total; //el request va a tener los datos del front, escribimos taly como esta en react, total
        $pedido->save();

        // otra forma
        // $pedido = Pedido::create([
        //     'user_id' => Auth::user()->id,
        //     'total' => $request->total
        // ]);

        //obtener el ID del pedido
        $id = $pedido->id;
        //obtener los Productos
        $productos = $request->productos;
        //Fomratear un arreglo
        //Assosiative Array
        $pedido_producto = [];

        //iteramos para ir contruyendo el arrelgo formateado
        //como usaremos insert, no creara el created_at,como si lo hace con save()
        foreach($productos as $producto) {
            //insertamos los datos al array
            $pedido_producto[] = [
                'pedido_id' => $id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        //Almacenar en la BD
        //insert permite insertar un arreglo que es lo que estamos construyendo
        PedidoProducto::insert($pedido_producto);

        return [
            'message' => 'Pedido realizado correctamente, estara listo en unos minutos'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
        $pedido->estado = 1;
        $pedido->save();
        return [
            'pedido' => $pedido
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
