<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;

class ActivitesController extends Controller
{
    public function Activities($id)
    {
        $data['details'] = DB::table('activities')->where('id', $id)->get();
        $path = public_path('uploads/activities/' . $data['details'][0]->title);
        if (File::isDirectory($path) && $data['details']) {
            $images = File::allFiles(public_path('uploads/activities/' . $data['details'][0]->title));
            return view('frontend.pages.activitiesdetails', $data)->with(array('images' => $images));
        } else {
            // $data['details'] = 'Bu kritere uygun detay bulunamadi';
            return view('frontend.pages.activitiesdetails', $data);
        }
    }
}
