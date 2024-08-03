<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Project;
use App\Models\Category;

class ProjectsController extends Controller
{
    public function index()
    {
        $data['result'] = Project::get();
        return view('backend.pages.projects.index', $data);
    }

    public function create()
    {
        $data['categories'] = Category::get('category');
        return view('backend.pages.projects.create', $data);
    }

    public function store(Request $request)
    {
        $data['title'] = Project::where('title', $request->title)->get();
        if(count($data['title']) > 0){
            return redirect()->route('projects.create')->withErrors('Bu proje sistemde kayıtlıdır');
        }
        $fileName = $request->file->getClientOriginalName();
        $data['img'] = Project::where('img', $fileName)->get();
        if(count($data['img']) > 0){
            return redirect()->route('projects.create')->withErrors('Bu resim sistemde kayıtlıdır');
        }
        $request->file->move(public_path('uploads/projects/'.$request->title), $fileName);
        Project::insert([
            'category'=>$request->category,
            'title'=>$request->title,
            'text'=>$request->text,
            'img'=>$fileName,
        ]);
        return redirect('admin/projects');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $data['projects'] = Project::where('id',$id,1)->get();
        $data['categories'] = Category::get('category');
        return view('backend.pages.projects.edit', $data);
    }

    public function update(Request $request, $id)
    {
        // if($request->hasFile('file')){
        //     $fileName = $request->file->getClientOriginalName();
        //     $request->file->move(public_path('uploads/projects/'.$request->title), $fileName);
        //     return $request->merge(['img' => $fileName]);
        // }
        Project::find($id)->update($request->post());
        return redirect('admin/projects');

    }

    public function destroy(Request $request,$id)
    {
        Project::whereId($id)->delete();
        File::deleteDirectory(public_path('uploads/projects/'.$request->project));
        return '200';
        
    }
}
