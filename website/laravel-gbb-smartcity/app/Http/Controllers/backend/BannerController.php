<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $data['result'] = DB::table('banners')->get();
        return view('backend.pages.banner.index', $data);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
       
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
        $banner = DB::table('banners')->find($id);
        return view('backend.pages.banner.edit', compact('banner'));
    }
    public function update(Request $request, $id)
    {
        if($request->hasFile('img')){
            $fileName = 'uploads/banner/banner.jpg';
            $request->img->move(public_path('uploads/banner/'), $fileName);
            $request->merge(['img' => $fileName]);
        }
        Banner::find($id)->update($request->post());
        return redirect()->route('banner.index')->withSuccess('Updated Successfully');
    }
    public function destroy($id)
    {
       
    }
}
