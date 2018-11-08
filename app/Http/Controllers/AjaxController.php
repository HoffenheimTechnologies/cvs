<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;

class AjaxController extends Controller
{
    //
    public function getServices(Request $request){
      $service = \App\Service::where('name', '!=', 'manual')->get();
      return Datatables::of($service)->make();
      // return response()->json([]);
    }

    public function deleteService(Request $request){
      $service = \App\Service::find($request->id);
      if($service){
        $service->delete();
        // $service->save();
        return response()->json(['status' => true]);
      }
      return response()->json(['status' => false]);
    }

    public function updateService(Request $request){
      $service = \App\Service::find($request->id);
      if ($service) {
        $index = ['name','sdays','edays'];
        foreach ($index as $key => $value) {
          if($request->$value){
            $service->$value = $request->$value;
          }
          $service->save();
        }
        return response()->json(['status' => true]);
      }
      return response()->json(['status' => false]);
    }
}
