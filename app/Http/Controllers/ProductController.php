<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
use App\Mail\SendMailPrice;
use Inertia\Response;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        // return Inertia::render('Product/ProductList', [
        //     'product' => Product::all()
        // ]);

        $page = $request->query('page', 1);
        $perPage = $request->query('perPage', 10);

        $products = Product::orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return Inertia::render('Product/ProductList', [
            'product' => $products,
        ]);
    }


    public function send(Request $request)
    {
        $data = $request->all(); // obtiene todos los datos enviados en la solicitud
        return dd($data);
        die();
        // Mail::to("luiz-fer@outlook.es")->send(new SendMailPrice());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
