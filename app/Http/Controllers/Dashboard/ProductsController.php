<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\ProductPriceValidaton;
use App\Http\Requests\ProductImagesValidaton;


use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;
use DB;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Product::select('id','slug','price','created_at')->paginate(PAGINATION_COUNT);
         return view('dashboard.products.general.index', compact('products'));
    }

    public function create()
    {
           $data =   [];
        
               
        return view('dashboard.products.general.create',$data);
    }

    public function store(GeneralProductRequest $request)
    {
        try {

            DB::beginTransaction();

            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            //if user choose main category then we must remove paret id from the request
            $product = Product::create([
             
                'is_active' => $request -> is_active,
            ]);
         
            //save translations
            $product->name = $request->name;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->save();


           
             DB::commit();

            return redirect()->route('admin.products')->with(['success' => 'تم ألاضافة بنجاح']);

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    /// price ////

    public function getPrice($product_id)
    {
        return view('dashboard.products.prices.create') -> with('id',$product_id);
    }

    public function saveProductPrice(ProductPriceValidaton $request)
    {
       try{
        Product::whereId($request -> product_id) -> update($request -> only(['price','special_price','special_price_type','special_price_start','special_price_end']));            return redirect()-> route('admin.products')-> with(['success' => 'تم التحديث بنجاح']);
        return redirect()->route('admin.products')->with(['success' => 'تم ألاضافة بنجاح']);    
    } catch (\Exception $ex) {
    
        return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
    ///end price ////





    



    




     ///// images ///////////
     public function addImages($product_id)
     {
        return view('dashboard.products.images.create') -> with('id',$product_id);

     }
 
 // to save images
 
    public function saveProductImages(Request $request ){
         $file = $request->file('dzfile');
         $filename = uploadImage('dsdsc', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }


    // to save images into db

    public function saveProductImagesDB(ProductImagesValidaton $request){
        return $request;
       try {
            // save dropzone images
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Image::create([
                        'product_id' => $request->product_id,
                        'photo' => $image,
                    ]);
                }
            }

            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);

        }catch(\Exception $ex){

        }
    }
 
 
     ///// end images ///////////
 
    public function edit($id)
    {
           //get specific categories and its translations
           $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);

        return view('dashboard.categories.edit',compact('category')) ;
        }



     
     
    
}