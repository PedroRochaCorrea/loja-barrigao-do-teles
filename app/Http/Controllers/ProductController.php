<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Trata a imagem enviada e remove a antiga se existir
    private function handleImage($request, $product = null)
    {
        if ($request->hasFile('photo')) {
            if ($product && $product->photo) {
                Storage::disk('public')->delete($product->photo);
            }
            return $request->file('photo')->store('products', 'public');
        }
        return null;
    }

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => ['required', 'regex:/^\d{1,3}(\.\d{3})*,\d{2}$/'],
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['price'] = str_replace(['.', ','], ['', '.'], $data['price']);
        $data['photo'] = $this->handleImage($request);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => ['required', 'regex:/^\d{1,3}(\.\d{3})*,\d{2}$/'],
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $data = $request->all();
        $data['price'] = str_replace(['.', ','], ['', '.'], $data['price']);

        // Só altera a imagem se o usuário enviar uma nova
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->handleImage($request, $product);
        } else {
            unset($data['photo']); // mantém a imagem atual
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (!$product->category_id) {
            return redirect()->route('products.index')->with('error', 'Este produto não está associado a nenhuma categoria!');
        }

        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
    }

    public function publicIndex()
    {
        $produtos = Product::all();
        return view('cliente.produtos', compact('produtos'));
    }
}
