<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Group;
use Symfony\Component\HttpFoundation\Response;
class GroupController extends Controller
{
    public function AddGroup (Request $request)
 {  
       if(auth()->user()->id==1)
       {
  $rules=array(
    "group_name"=>"required",
  );
  $validator=Validator::make($request->all() , $rules);
  if($validator->fails()){
    return $validator->errors();
  }
  else
  {
   $group = new Group;
   $group->group_name=$request->group_name;
   $result=$group->save();
   if($result){
    return ["Result"=>"data has been saved"];
 }
 return ["Result"=>"operation failed"];
 }
}
        
        else
        {
            return ["error"=>"you dont have permission to do this"];
        }
        
        }
 public function indexGroup()
 {
   return Group::all();
 }
  public function indexGroupbyPer()
  {  

    $group_name=Auth::user()->group_name;
    return Group::where('group_name','=',$group_name)->get();
   
  }

}

