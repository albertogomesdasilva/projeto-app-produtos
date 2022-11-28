<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProductStoreRequest;

class AdminProductController extends Controller
{
 public function index()

   { 
     $products = Product::all();

    return view('admin.products', compact('products'));
   }
 
 // Exibir a página de editar
   public function edit(Product $product)
   {

    return view('admin.product_edit', [
      'product' => $product
    ]);
   }

   // Recebe a Requisição de Update PUT
  //  public function update(Product $product, Request $request)
   public function update(Product $product, ProductStoreRequest $request)
   {
    // $input = $request->validate([
    $input = $request->validated(
      // [
            
      // 'name' => 'string|required',
      // 'price' => 'string|required',
      // 'sctock' => 'integer|nullable',
      // 'cover' => 'file|nullable',
      // 'description' => 'string'
      
      // ]
    );

      
      if (!empty($input['cover']) && $input['cover']->isValid()) {

        Storage::delete($product->cover ?? '');   // Apaga a imagem anterior quando estiver editando...

        $file = $input['cover'];
        // $path = $file->store('local');
        $path = $file->store('public/products');
        $input['cover'] = $path;

        // dd($path);
      }



      $product->fill($input);
      $product->save();

      // dd($input);

      return Redirect::route('admin.products');
  }

// Exibe a página de Criar
   public function create()
   {
    return view('admin.product_create');
   }


   // Recebe a requisição de criar POST
  //  public function store(Request $request)
   public function store(ProductStoreRequest $request)
   {


    // $input = $request->validate([
    $input = $request->validated(
      // [
      //   'name' => 'string|required',
      //   'price' => 'string|required',
      //   'sctock' => 'integer|nullable',        ESTE CONTEÚDO FOI PARA App\Http\Requests\ProductStoreRequest.php (php artisan make:request ProductStoreRequest)
      //   'cover' => 'file|nullable',
      //   'description' => 'string'  
                     
      //       ]
          );
      
            
            $input['slug'] = ($input['name']);

            if (!empty($input['cover']) && $input['cover']->isValid()) {

              $file = $input['cover'];
              // $path = $file->store('local');
              $path = $file->store('public/products');
              $input['cover'] = $path;

              // dd($path);
            }
            
            // $input['slug'] = str_slug($input['name']);
            //dd($input);  // Verificar se o formulário de criação está enviando para a rota correta... basta clicar em enviar

     Product::create($input);

     return Redirect::route('admin.products');
   }


   public function destroy(Product $product)
   {
    $product->delete();

    Storage::delete($product->cover ?? '');

    return Redirect::route('admin.products');
   }

   // Apagar a imagem
   public function destroyImage(Product $product)
   {
        Storage::delete($product->cover ?? '');

        $product->cover = null;

        $product->save();

       return Redirect::back();
   }

}
