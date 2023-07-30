<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brands;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

use App\Http\Requests\ProductFormRequest;
use App\Models\ProductImage;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $brands = Brands::all();
        $categories = Category::all();
        return view('admin.products.create', compact('brands', 'categories'));
    }

    public function store(ProductFormRequest $request)
    {

        $validatedData = $request->validated();
        $brand = Brands::findOrFail($validatedData['brand_id']);
        $category = Category::findOrFail($validatedData['category']);

        if ($request->hasFile('pf_image')) {
            $image = $request->file('pf_image');
            $imageExtension = $image->getClientOriginalExtension();
            $newImageName = time() . '.' . $imageExtension;
        }

        if ($request->has('type')) {
            $productData['type'] = $request->input('type');
            $productType =  $productData['type'];
        } else {
            $productType = Null;
        }

        $product = $brand->products()->create([
            'brand_id' => $validatedData['brand_id'],
            'category' => $category->id,
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'type' => $productType,
            'orginal_price' => $validatedData['orginal_price'],
            'selling_price' => $validatedData['selling_price'],
            'quantity' => $validatedData['quantity'],
            'description' => $validatedData['description'],
            'meta_title' => $validatedData['meta_title'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'meta_description' => $validatedData['meta_description'],
            'pf_image' =>  $image->move('uploads/products', $newImageName),
        ]);

        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/products/';

            $i = 1;
            foreach ($request->file('image') as $imageFile) {
                $extention = $imageFile->getClientOriginalExtension();
                $filename = time() . $i++ . '.' . $extention;
                $imageFile->move($uploadPath, $filename);
                $finalImagePathName = $uploadPath . $filename;
                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalImagePathName,
                ]);
            }
        }

        return Redirect('admin/products')->with('message', 'Product Added Sucessfilly');
    }

    public function edit(int $product_id)
    {
        $brands = Brands::all();
        $categories = Category::all();
        $product = Product::findOrFail($product_id);

        return view('admin.products.edit', compact('brands', 'product', 'categories'));
    }

    public function update(ProductFormRequest $request, int $product_id)
    {
        $validatedData = $request->validated();
        $product = Product::findOrFail($product_id); // Find the product using its ID


        // Handle the image only if a new image file is uploaded
        if ($request->hasFile('pf_image')) {
            $path = 'uploads/products/' . $product->pf_image;

            if (File::exists($path)) {
                File::delete($path); // Delete the old image file
            }
            $pfimage = $request->file('pf_image');
            $imageExtension = $pfimage->getClientOriginalExtension();
            $newImageName = time() . '.' . $imageExtension;
            $pfimage->move('uploads/products', $newImageName); // Move the new image to the desired location
        }

        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/products/';

            // Delete the previous product images
            foreach ($product->productImages as $image) {
                $imagePath = $image->image;
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $image->delete();
            }

            // Upload and save the new product images
            $i = 1;
            foreach ($request->file('image') as $imageFile) {
                $extension = $imageFile->getClientOriginalExtension();
                $filename = time() . $i++ . '.' . $extension;
                $imageFile->move($uploadPath, $filename);
                $finalImagePathName = $uploadPath . $filename;
                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalImagePathName,
                ]);
            }
        }

        if ($request->has('type')) {
            $productData['type'] = $request->input('type');
            $productType =  $productData['type'];
        } else {
            $productType = Null;
        }
        // Update the product with the validated data
        $product->update([
            'brand_id' => $validatedData['brand_id'],
            'category' => $validatedData['category'], // Single category ID
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'type' => $productType,
            'orginal_price' => $validatedData['orginal_price'],
            'selling_price' => $validatedData['selling_price'],
            'quantity' => $validatedData['quantity'],
            'description' => $validatedData['description'],
            'meta_title' => $validatedData['meta_title'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'meta_description' => $validatedData['meta_description'],
            'pf_image' => isset($newImageName) ? $newImageName : $product->pf_image, // Use the new image name if uploaded, otherwise use the existing one
        ]);

        return redirect('admin/products')->with('message', 'Product Update Successfully');
    }


    public function destroyImage(int $product_image_id)
    {
        $productImage = ProductImage::findOrFail($product_image_id);
        if (File::exists($productImage->image)) {
            File::delete($productImage->image);
        }
        $productImage->delete();
        return redirect()->back()->with('message', 'Product Iamge Delete');
    }

    public function destroy(int $product_id)
    {
        $product = Product::findOrFail($product_id); // Find the product using its ID
        if ($product->productImage) {
            foreach ($product->productImage as $iamge) {
                if (File::exists($iamge->image)) {
                    File::delete($iamge->image);
                }
            }
        }
        $product->delete();
        return redirect('admin/products')->with('message', 'Product Delete Successfully');
    }
}
