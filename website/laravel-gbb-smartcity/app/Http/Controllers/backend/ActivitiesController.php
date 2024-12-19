<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Activity;

class ActivitiesController extends Controller
{
    public function index()
    {
        $data['result'] = Activity::get();
        return view('backend.pages.activities.index', $data);
    }

    public function create()
    {
        return view('backend.pages.activities.create');
    }

    public function store(Request $request)
    {
        $data['title'] = Activity::where('title', $request->title)->get();
        if(count($data['title']) > 0){
            return redirect()->route('activities.create')->withErrors('Bu etkinlik sistemde kayıtlıdır');
        }
        $fileName = $request->file->getClientOriginalName();
        $data['img'] = Activity::where('img', $fileName)->get();
        if(count($data['img']) > 0){
            return redirect()->route('activities.create')->withErrors('Bu resim sistemde kayıtlıdır');
        }
        $request->file->move(public_path('uploads/activities/'.$request->title), $fileName);
        Activity::insert([
            'title'=>$request->title,
            'text'=>$request->text,
            'img'=>$fileName,
        ]);
        return redirect('admin/activities');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $activity = Activity::whereId($id)->get();
        return view('backend.pages.activities.edit', compact('activity'));
    }

    public function update(Request $request, $id)
    {
        // if($request->hasFile('img')){
        //     $fileName = 'cover.'.$request->img->extension();
        //     $request->img->move(public_path('uploads/activities/'.$request->title), $fileName);
        //     $request->merge(['img' => $fileName]);
        // }
        Activity::find($id)->update($request->post());
        return redirect('admin/activities');
    }

    public function destroy(Request $request, $id)
    {
        Activity::whereId($id)->delete();
        File::deleteDirectory(public_path('uploads/activities/'.$request->activiti));
        return '200';
    }
}
