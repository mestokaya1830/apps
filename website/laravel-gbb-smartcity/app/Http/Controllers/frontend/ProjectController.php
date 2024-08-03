<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;

class ProjectController extends Controller
{
    public function Projects()
    {
        $data['projects'] =  DB::table('projects')->orderBy('id', 'desc')->take(6)->get();
        return $data;
    }

    public function ProjectCategory($category)
    {
        $data['projectscategory'] = DB::table('projects')->where('category', $category, 1)->get();
        return $data;
    }

    public function ProjectDetails($id)
    {
        $data['details'] = DB::table('projects')->where('id', $id)->get();
        $path = public_path('uploads/projects/' . $data['details'][0]->title);
        if (File::isDirectory($path) && $data['details']) {
            $images = File::allFiles(public_path('uploads/projects/' . $data['details'][0]->title));
            return view('frontend.pages.projectsdetails', $data)->with(array('images' => $images));
        } else {
            // $data['details'] = 'Bu kritere uygun detay bulunamadi';
            return view('frontend.pages.projectsdetails', $data);
        }
    }
}
