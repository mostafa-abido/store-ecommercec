<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;

use App\Http\Requests\TagsRequest;

use App\Models\Tag;
use Illuminate\Http\Request;
use DB;




class  TagsController extends Controller
{
    public function index()
    {
          $tags = Tag::orderBy('id','DESC') ->paginate(PAGINATION_COUNT);
         return view('dashboard.tags.index',compact('tags')) ;
    }

    public function create()
    {
         
        return view('dashboard.tags.create');
    }

    public function store(TagsRequest $request)
    {

     
      

            DB::beginTransaction();

            //validation

            
        $tag = Tag::create(['slug' => $request->slug]);

        //save translations
        $tag->name = $request->name;
      

        $tag->save();

        DB::commit();
        return redirect()->route('admin.tags')->with(['success' => 'تم ألاضافة بنجاح']);

   

    }


        

    





    public function edit($id)
    {
           //get specific categories and its translations
           $tag = Tag::find($id);

        if (!$tag)
            return redirect('admin.tags')->with(['error' => 'هذه الماركه غير موجوده']);

        return view('dashboard.tags.edit',compact('tag')) ;
        }


        public function update($id, TagsRequest $request)
        {
            try {
                //validation
    
                //update DB
    
    
                $tag = Tag::find($id);
    
                if (!$tag)
                    return redirect()->route('admin.tags')->with(['error' => 'هذه الماركه غير موجوده']);
                
                DB::beginTransaction();

              
    
                $tag->update($request->except('_token','id'));
                

                //save translations
                $tag->name = $request->name;
                $tag->save();
                DB::commit();
                return redirect()->route('admin.tags')->with(['success' => 'تم ألتحديث بنجاح']);
            } catch (\Exception $ex) {
                DB::rollback();
                return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
            }
    
        }

     // delete method //
        public function destroy($id)
        {
    
            try {
                //get specific categories and its translations
                $tag = Tag::find($id);
    
                if (!$tag)
                    return redirect()->route('admin.tags')->with(['error' => 'هذا القسم غير موجود ']);
    
                $tag->delete();
    
                return redirect()->route('admin.tags')->with(['success' => 'تم  الحذف بنجاح']);
    
            } catch (\Exception $ex) {
                return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
            }
        }
    
    
}