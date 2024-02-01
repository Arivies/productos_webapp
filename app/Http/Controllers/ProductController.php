<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Validator;

class ProductController extends Controller
{

/*
    public function __construct(Request $tkn)
    {
        $this->tkn=session('access_token');
        dd($token);

        if(!$tkn){
            $this->middleware('can:products.index')->only(['index']);
            $this->middleware('can:products.create')->only(['create','store']);
            $this->middleware('can:products.edit')->only(['edit','update']);
            $this->middleware('can:products.show')->only(['show']);
            $this->middleware('can:products.destroy')->only(['destroy']);
        }
    }
*/



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Product::latest()->paginate(5);

        return view('products.index',compact('productos'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*Obtiene el objeto request, valida los datos enviados*/
        $validate=Validator::make($request->all(),([
               'nombre'=>'required|string|max:255',
               'img1'=>'required|image|mimes:jpeg,png,jpg,gif|max:3048',
               'img2'=>'required|image|mimes:jpeg,png,jpg,gif|max:3048',
               'video' =>'required|mimes:mp4,mov,avi,ogg,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv',
            ]));

        /*Si falla la validacion retorna mensaje de error*/
        if($validate->fails()){
          /*  $errors = $validate->errors();
            dd($errors->all());*/
            return redirect()->route('productos.create')->with('error','error en la captura de datos')
            ->withErrors($validate);
        }

        /*Se asigna el elemento file del objeto request para darle formato al nombre del archivo
        para que sea unico*/
        $imagen1 = $request->file('img1');
        $imagen2 = $request->file('img2');
        $video = $request->file('video');

        $nombreArchivo1 = time().'_img1.'.$imagen1->getClientOriginalExtension();
        $nombreArchivo2 = time().'_img2.'.$imagen2->getClientOriginalExtension();
        $nombreVideo = time().'_video.'.$video->getClientOriginalExtension();

        /*Se define el path donde se almacenara */
        $url_img= public_path("media/images/");
        $url_video= public_path("media/videos/");

        /*Se mueve el archivo enviado desde el formulario al servidor  */
        $imagen1->move($url_img,$nombreArchivo1);
        $imagen2->move($url_img,$nombreArchivo2);
        $video->move($url_video,$nombreVideo);

        /*Se crea objeto de Producto para guardar los datos y se asigna el nuevo nombre
        se los archivos para guardarlos en la base de datos*/
        $product = new Product();
        $product->nombre=$request->nombre;
        $product->img1=$nombreArchivo1;
        $product->img2=$nombreArchivo2;
        $product->video=$nombreVideo;
        $product->save();
        return redirect()->route('productos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $producto)
    {
        return view('products.show',compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $producto)
    {
        return view('products.edit',compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $producto)
    {

        /*Obtiene el objeto request, valida los datos enviados*/
        $validate=Validator::make($request->all(),([
            'nombre'=>'string|max:255',
            'img1'=>'image|mimes:jpeg,png,jpg,gif|max:3048',
            'img2'=>'image|mimes:jpeg,png,jpg,gif|max:3048',
            'video' =>'mimes:mp4,mov,avi,ogg,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv',
         ]));

            /*Si falla la validacion retorna mensaje de error*/
            if($validate->fails()){
                /*$errors = $validate->errors();
                dd($errors->all());*/

                return redirect()->route('productos.edit',$producto->id)->with('error','error en la captura de datos')
                ->withErrors($validate);
            }

            /*Se asigna el elemento file del objeto request para darle formato al nombre del archivo
            para que sea unico*/
            $url_img= public_path("media/images/");
            $url_video= public_path("media/videos/");

            /*Se agrega al formulario un campo con el nombre de la imagen  y video
            para verificar si este no se cargo uno diferente no se actualice
            en caso contrario se valida que el nuevo archivo sea de tipo file, se da formato al nombre
            se mueve al servidor y el archivo anterior se elimina*/
            $nombreArchivo1 = $request->ant_img1;
            if($request->hasFile('img1')){
                $imagen1 = $request->file('img1');
                $nombreArchivo1 = time().'_img1.'.$imagen1->getClientOriginalExtension();
                $imagen1->move($url_img,$nombreArchivo1);
                $rutaArchivo = public_path('media/images/' . $request->ant_img1);
                File::delete($rutaArchivo);
            }

            $nombreArchivo2 = $request->ant_img2;
            if($request->hasFile('img2')){
                $imagen2 = $request->file('img2');
                $nombreArchivo2 = time().'_img2.'.$imagen2->getClientOriginalExtension();
                $imagen2->move($url_img,$nombreArchivo2);
                $rutaArchivo = public_path('media/images/' . $request->ant_img2);
                File::delete($rutaArchivo);
            }

            $nombreVideo = $request->ant_video;
            if($request->hasFile('video')){
                $video = $request->file('video');
                $nombreVideo = time().'_video.'.$video->getClientOriginalExtension();
                $video->move($url_video,$nombreVideo);
                $rutaArchivo = public_path('media/videos/' . $request->ant_video);
                File::delete($rutaArchivo);
            }
            /*Se crea array con los nombres de los archivos para asociarlos al objeto que se actualizara */
            $resp = request()->except(['_token','_method','id', 'ant_img1','ant_img2','ant_video']);
            $resp['img1']=$nombreArchivo1;
            $resp['img2']=$nombreArchivo2;
            $resp['video']=$nombreVideo;
            $producto->update($resp);
            return redirect()->route('productos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $producto)
    {
        /*Se elimina el registro y los archivos fisicamente */
        unlink(public_path('/media/images/'.$producto->img1));
        unlink(public_path('/media/images/'.$producto->img2));
        unlink(public_path('/media/videos/'.$producto->video));

        $producto->delete();
        return redirect()->route('productos.index');
    }
}
