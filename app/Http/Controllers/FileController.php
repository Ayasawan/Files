<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use App\Models\MyFile;
use DB;
class FileController extends Controller
{
   public function uploadFile(Request $request)
{
    $file = $request->file('link');
    $fileName = time().$file->getClientOriginalName();
    $path = $file->storePubliclyAs('public/upload', $fileName);
    $link = Storage::url($path);
    $file = new MyFile;
    $file->link = $link;
    $file->file_name = $fileName;
    $file->status = $request->status;
    $file->group_name = auth()->user()->group_name;
    $result=$file->save();
     if($result)
      {
        return ["Result"=>"file has been uploaded"];
      }
     return ["Result"=>"operation failed"];
}
    public function reserveFile($id )
    {
    $file = MyFile::find($id);

    if (!$file) {
         return response()->json([
        'message' => 'File was not found'
        ], 400);
    }

    if ($file->status=='reserved') {
        return response()->json([
                    'message' => 'File already reserved!!!!!'
                ], 400);
    }
    $file->status = 'reserved';
    $result=$file->save();
     if($result)
      {
        return ["Result"=>"file has been reserved"];
      }
     return ["Result"=>"operation failed"];
    }

   public function indexFiles()
  {  
    
   return MyFile::all();
   
  }
 
   public function indexFilesbyPer()
  {  

    $group_name=Auth::user()->group_name;
    return MyFile::where('group_name','=',$group_name)->get();
   
  }
  public function reserveFiles(Request $request)
{
    $data = $request->all();
    $files = $data["files"];
    if (empty($files)) 
    {
        return response()->json(['message' => 'No files provided']);
    }
    $response = ['message' => 'operation failed'];
    $allFilesFree = true;
    foreach ($files as $file) {
        $status = MyFile::where('id', '=', $file["id"])->value('status');
        if ($status === "reserved") {
            $allFilesFree = false;
            break;
        }
    }
     if ($allFilesFree) {
        foreach ($files as $file) {
            $fileModel = MyFile::find($file["id"]);
            $fileModel->status = 'reserved';
            $result = $fileModel->save();
            if ($result) {
                $file = Storage::disk('public')->path("upload/{$fileModel->file_name}");
                 response()->download($file, $fileModel->file_name);
            }
        }
        return ["Result" => "All files reserved successfully"];
    } else {
        return ["Result" => "Some files are already reserved"];
    }
}

 public function ReplaceFile ($id,Request $request)
 { 
    $file = $request->file('link');
    $fileName = time().$file->getClientOriginalName();
    $path = $file->storePubliclyAs('public/upload', $fileName);
    $link = Storage::url($path);
    $file= MyFile::find($id);
    $file->link = $link;
    $file->file_name = $fileName;
    $file->status = 'free';
    $file->group_name = auth()->user()->group_name;
    $result=$file->save();
   if($result){
    return ["Result"=>"data has been replaced"];
 }
 return ["Result"=>"operation failed"];
 }

}



