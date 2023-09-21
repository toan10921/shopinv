<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use App\Models\Product_Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //  // produc all brands with pagination
        $products = Product::orderBy('updated_at','desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all brands
        $brands = Brand::all();
        return view('admin.products.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // validate request
            $request->validate([
                'name' => 'required|max:255',
                'brand_id' => 'required|exists:brands,id',
                'price' => 'required|numeric|max:100000',
                // 'desc' => 'required',
            ]);
            if (empty($request->desc)) {
                $request->desc = '';
            }
            $thumbnail  = '';
            // $name = '';
            // check if have file image
            if ($request->hasFile('image')) {
                // get file image
                $image = $request->file('image');
                // check allow file type jpg,png,gif
                $allowed = ['jpg', 'png', 'gif'];
                $extension = $image->getClientOriginalExtension();
                if (!in_array($extension, $allowed)) {
                    return redirect()->back()->with('error', 'File type not allowed.');
                }
                // get file name
                $thumbnail = $image->getClientOriginalName();
                // add unique string to file name

                $thumbnail = time() . '_' . $thumbnail;
                // insert record to image table
                // if do not have folder uploads , create new one
                if (!is_dir(public_path('storage/uploads'))) {
                    mkdir(public_path('storage/uploads'));
                }
                $res = $image->move(public_path('storage/uploads'), $thumbnail);
                if (!$res) {
                    return redirect()->back()->with('error', 'Upload image failed.');
                }
            }

            $product = null;
            // create product
            if ($thumbnail != '') {

                $product = Product::create([
                    'name' => $request->name,
                    'brand_id' => $request->brand_id,
                    'price' => $request->price,
                    'desc' => $request->desc,
                    'thumbnail' => $thumbnail,
                ]);
            } else {
                $product = Product::create([
                    'name' => $request->name,
                    'brand_id' => $request->brand_id,
                    'price' => $request->price,
                    'desc' => $request->desc,
                    'image' => 'no-image.jpg'
                ]);
            }
            if (!$product) {
                return redirect()->back()->with('error', 'Create product failed.');
            }
            if (!empty($request->hasFile('image_galleries'))) {
                $image_galleries = $request->file('image_galleries');
                foreach ($image_galleries as $img_gallery) {
                    $allowed = ['jpg', 'png', 'gif'];
                    $extension = $img_gallery->getClientOriginalExtension();
                    if (!in_array($extension, $allowed)) {
                        return redirect()->back()->with('error', 'File type not allowed.');
                    }
                    // get file name
                    $name = $img_gallery->getClientOriginalName();
                    // add unique string to file name
                    $name = time() . '_' . $name;
                    // insert record to image table
                    // if do not have folder uploads , create new one
                    if (!is_dir(public_path('storage/uploads'))) {
                        mkdir(public_path('storage/uploads'));
                    }
                    $res = $img_gallery->move(public_path('storage/uploads'), $name);
                    if (!$res) {
                        return redirect()->back()->with('error', 'Upload image failed.');
                    }
                    $image = Image::create([
                        'image_path' => $name,
                    ]);
                    Product_Image::create([
                        'product_id' => $product->id,
                        'image_id' => $image->id,
                    ]);
                }
            }
            DB::commit();
            // redirect to index
            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            exit;
            return redirect()->back()->with('error', 'Create product failed.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::find($id);
        $brands = Brand::all();
        $image_galleries = Product_Image::where('product_id', $id)->join('images', 'product_images.image_id', '=', 'images.id')->get();

        return view('admin.products.edit', compact('product', 'brands','image_galleries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        try {
            DB::beginTransaction();
            $request->validate([
                'name' => 'required|max:255',
                'brand_id' => 'required|exists:brands,id',
                'price' => 'required|numeric|max:100000',
                // 'desc' => 'required',
            ]);
            if (empty($request->desc)) {
                $request->desc = '';
            }
            $thumbnail  = '';
            $product = Product::find($id);
            // check if have file image
            if ($request->hasFile('image')) {
                // get file image
                $image = $request->file('image');
                // check allow file type jpg,png,gif
                $allowed = ['jpg', 'png', 'gif'];
                $extension = $image->getClientOriginalExtension();
                if (!in_array($extension, $allowed)) {
                    return redirect()->back()->with('error', 'File type not allowed.');
                }
                // get file name
                $thumbnail = $image->getClientOriginalName();
                // add unique string to file name

                $thumbnail = time() . '_' . $thumbnail;
                // insert record to image table
                // if do not have folder uploads , create new one
                if (!is_dir(public_path('storage/uploads'))) {
                    mkdir(public_path('storage/uploads'));
                }
                $res = $image->move(public_path('storage/uploads'), $thumbnail);
                if (!$res) {
                    return redirect()->back()->with('error', 'Upload image failed.');
                }
            }
            if ($thumbnail != '') {
                $product->thumbnail = $thumbnail;
            }
            $product->name = $request->name;
            $product->brand_id = $request->brand_id;
            $product->price = $request->price;
            $product->desc = $request->desc;


            if (!empty($request->hasFile('image_galleries'))) {
                $image_galleries = $request->file('image_galleries');
                 // drop old Product_Image before add new
                 Product_Image::where('product_id', $id)->delete();
                foreach ($image_galleries as $img_gallery) {
                    $allowed = ['jpg', 'png', 'gif'];
                    $extension = $img_gallery->getClientOriginalExtension();
                    if (!in_array($extension, $allowed)) {
                        return redirect()->back()->with('error', 'File type not allowed.');
                    }
                    // get file name
                    $name = $img_gallery->getClientOriginalName();
                    // add unique string to file name
                    $name = time() . '_' . $name;
                    // insert record to image table
                    // if do not have folder uploads , create new one
                    if (!is_dir(public_path('storage/uploads'))) {
                        mkdir(public_path('storage/uploads'));
                    }
                    $res = $img_gallery->move(public_path('storage/uploads'), $name);
                    if (!$res) {
                        return redirect()->back()->with('error', 'Upload image failed.');
                    }

                    $image = Image::create([
                        'image_path' => $name,
                    ]);
                    Product_Image::create([
                        'product_id' => $product->id,
                        'image_id' => $image->id,
                    ]);
                }
            }

            $product->save();
            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        }catch(Exception $e){
            DB::rollBack();
            echo $e->getMessage();
            exit;
            return redirect()->back()->with('error', 'Update product failed.');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $product = Product::find($id);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }
            $product_images = Product_Image::where('product_id', $id)->delete();
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        }catch(Exception $e){
            echo $e->getMessage();
            exit;
        }
    }

    public function homePage(){
        $products = Product::orderBy('updated_at','desc')->paginate(10);
        return view('frontpage.home', compact('products'));
    }

    public function singleProduct(string $id){
        $product = Product::find($id);
        $brand = Brand::find($product->brand_id);
        $image_galleries = Product_Image::where('product_id', $id)->join('images', 'product_images.image_id', '=', 'images.id')->get();
        return view('frontpage.products.single', compact('product','image_galleries','brand'));
    }
}
