<?php

namespace App\Http\Controllers\API;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class AboutController extends Controller
{
    //

    public function edit_about(Request $request)
    {
        return About::orderBy('id','desc')->first();
    }


    public function update_about(Request $request, $id)
    {
        try {
            $about = About::find($id);

            $this->validate($request, [
                "name"=> "required",
                "email"=> "required",
            ]);

            if($about->photo != $request->photo){
                $strpos = strpos($request->photo, ';');

                $sub = substr($request->photo, 0,$strpos);

                $ex = explode('/', $sub)[1];

                $name_photo = time().".".$ex;

                $img = Image::make($request->photo)->resize(200, 200);

                $upload_path = public_path()."/img/uploads/";

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 777, true);
                }

                $image = $upload_path.$about->photo;

                $img->save($upload_path.$name_photo);

                if(file_exists($image)){
                    @unlink($image);
                }else{
                    $name = $about->photo;
                }

            }

            if($about->cv != $request->cv){
                $strpos = strpos($request->cv, ';');

                $sub = substr($request->cv, 0,$strpos);

                $ex = explode('/', $sub)[1];

                $namecv = time().".".$ex;

                $img = Image::make($request->cv)->resize(200, 200);

                $upload_path = public_path()."/img/uploads/";

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 777, true);
                }

                $image = $upload_path.$about->cv;

                $img->save($upload_path.$namecv);

                if(file_exists($upload_path)){
                    @unlink($image);
                }else{
                    $namecv = $about->photo;
                }

            }

            $about->name = $request->name;
            $about->email = $request->email;
            $about->phone = $request->phone;
            $about->address = $request->address;
            $about->description = $request->description;
            $about->tagline = $request->tagline;
            $about->photo = $name_photo;
            $about->cv = $namecv;

            $about->save();

            return response()->json($about, 200);
        } catch (\Throwable $e) {
            return response()->json(["success"=> false, "message"=> $e->getMessage()], 500);
        }
    }


}
