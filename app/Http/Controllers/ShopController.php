<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Category;
use Intervention\Image\ImageManagerStatic as Image;

class ShopController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // Get most popular products
        $allProducts = Product::all();

        // Show the most popular products

        return view ('shop.index', compact('allProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all the categories to show on the form
        $allCategories = Category::pluck('name','id');

        return view('shop.create', compact('allCategories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Validate the data
        $this->validate($request, [
            'name'          => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric|max:9999.99',
            'stock'         => 'required|integer|max:65535',
            'categories_id' => 'required|exists:categories,id',
            'image'         => 'required|image',
            'alt_text'      => 'required|min:10'

            ]);

        // configure with favored image driver (gd by default)
        
        // Make a copy of the file that was uploaded
            $image = Image::make($request->image);

            switch($image->mime){
                case 'image/jpeg':
                case 'image/jpg':
                    break;
                    $fileExtension = '.jpg';
                break;

                case 'image/png':
                    $fileExtension = '.png';
                break;

                case 'image/gif':
                    $fileExtension = '.gif';
                break;

            $filename = uniqid().$fileExtension;

            // Save Image
            $image->save("image/products/$filename");

            $newProduct = $request->all();
            $newProduct['image'] = $filename;

            // Save the data
            $product = Product::create($newProduct);

        // Redirect away to the new product
        return redirect('shop/'.$product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('shop.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // Find the product to be edited
        $product    = Product::findOrFail($id);
        $categories = Category::pluck('name','id');
        
        // Show an edit form
        return view('shop.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // Validation
        $this->validate($request, [
            'name'          => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric|max:9999.99',
            'stock'         => 'required|integer|max:65535',
            'categories_id' => 'required|exists:categories,id',
            'image'         => 'image',
            'alt_text'      => 'required|min:10'

            ]);
        // find the product that is being updated
        $product = Product::findOrFail($id);


        // Override the values with new ones
        $product->name = $request['name'];
        $product->description = $request['description'];
        $product->price = $request['price'];
        $product->stock = $request['stock'];
        $product->categories_id = $request['categories_id'];

        // did the user upload an image

        if ($request->hasFile('image')){


            $image = Image::make($request->image);
            $filename = uniqid().'.jpg';
            $image->save("image/blog/$filename");
            // Make sure the file has successfully uploaded

            // Remove the old image
            unlink('image/blog/'.$product->image);

            // Save the new filename
            $product->image = $filename;



        }

        // Save
        $product->save();

        // Redirect back to product page
        return redirect("/shop/$id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
