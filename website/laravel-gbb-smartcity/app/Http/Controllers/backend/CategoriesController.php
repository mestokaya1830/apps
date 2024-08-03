<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    public function index()
    {
        $data['result'] = Category::get();
        return view('backend.pages.categories.index', $data);
    }

    public function create()
    {
        return view('backend.pages.categories.create');
    }

    public function store(Request $request)
    {
        $data['category'] = Category::where('category', $request->category)->get();
        if(count($data['category']) > 0){
            return redirect()->route('categories.create')->withErrors('Bu kategori sistemde kayıtlıdır');
        }
        
        $fileName = $request->file->getClientOriginalName();
        $data['img'] = Category::where('img', $fileName)->get();
        if(count($data['img']) > 0){
            return redirect()->route('categories.create')->withErrors('Bu resim sistemde kayıtlıdır');
        }
        $request->file->move(public_path('uploads/categories/'.$request->category), $fileName);
        Category::insert([
            'category'=>$request->category,
            'img'=>$fileName
        ]);
        return redirect('admin/categories');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $category = Category::whereId($id)->get();
        return view('backend.pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $oldValues = Category::find($id)->get();
        if($request->hasFile('img')){
            $fileName = $request->img->getClientOriginalName();
            $request->img->move(public_path('uploads/categories/'.$request->category), $fileName);
            File::delete('uploads/categories/'.$request->category.'/'.$oldValues[0]->img);
            $request->merge(['img' => $fileName]);
            Category::find($id)->update(["img" => $request->img]);
        } else {
            rename('uploads/categories/'.$oldValues[0]->category, 'uploads/categories/'.$request->category );
            Category::find($id)->update(["category"=>$request->category]);
        }
        Category::find($id)->update($request->post());
        return redirect('admin/categories');
    }

    public function destroy(Request $request,$id)
    {
        Category::whereId($id)->delete();
        File::deleteDirectory(public_path('uploads/categories/'.$request->category));
        $data = Project::where('category', $request->category)->get();
        foreach($data as $item){
            Project::where('title', $item->title)->delete();
            File::deleteDirectory(public_path('uploads/projects/'.$item->title));
        }
        return '200';
    }
}
