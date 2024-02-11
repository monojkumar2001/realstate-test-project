<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyType;
use App\Models\Amenities;
class PropertyTypeController extends Controller
{

    public function AllType(){
        $types = PropertyType::latest()->get();
        return view('backend.type.all_type', compact('types'));
    } //End Method

    public function AddType(){
        return view('backend.type.add_type');
    }//End Method

    public function StoreType( Request $request){
        
        // Validation 
        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon'=>'required'
        ]);
        PropertyType::insert([
            'type_name'=>$request->type_name,
            'type_icon'=>$request->type_icon,
        ]);
        $notification = array(
            'message' => "Property Type Create successfully",
            'alert-type' => "success"
        );
        return redirect()->route('all.type')->with($notification);
    }//End Method

    public function EditType($id){
        $types=PropertyType::findOrFail($id);
        return view('backend.type.edit_type', compact('types'));
    }//End Method

    public function UpdateType( Request $request){
        $pid= $request->id;
        PropertyType::findOrFail($pid)->update([
            'type_name'=>$request->type_name,
            'type_icon'=>$request->type_icon,
        ]);
        $notification = array(
            'message' => "Property Type Update successfully",
            'alert-type' => "success"
        );
        return redirect()->route('all.type')->with($notification);
    }//End Method

    public function DeleteType($id){
        PropertyType::findOrFail($id)->delete();
        $notification = array(
            'message' => "Property Type Delete successfully",
            'alert-type' => "success"
        );
        return redirect()->back()->with($notification);
    }//End Method

    ///=========== Amenitie all=============

    public function AllAmenitie(){
        $amenitie = Amenities::latest()->get();
        return view('backend.amenitie.all_amenitie', compact('amenitie'));
    } //End Method
    
    public function AddAmenitie(){
        return view('backend.amenitie.add_amenitie');
    }//End Method


    public function StoreAmenitie( Request $request){
        
        // Validation 
        $request->validate([
            'amenities_name' => 'required|unique:amenities|max:200',
        ]);
        Amenities::insert([
            'amenities_name'=>$request->amenities_name,
        ]);
        $notification = array(
            'message' => "Property Amenities Create successfully",
            'alert-type' => "success"
        );
        return redirect()->route('all.amenitie')->with($notification);
    }//End Method

    public function EditAmenitie($id){
        $amenities=Amenities::findOrFail($id);
        return view('backend.amenitie.edit_amenitie', compact('amenities'));
    }//End Method

    public function UpdateAmenitie( Request $request){
        $aid= $request->id;
        Amenities::findOrFail($aid)->update([
            'amenities_name'=>$request->amenities_name,

        ]);
        $notification = array(
            'message' => "Property Amenitie Update successfully",
            'alert-type' => "success"
        );
        return redirect()->route('all.amenitie')->with($notification);
    }//End Method

    public function DeleteAmenitie($id){
        Amenities::findOrFail($id)->delete();
        $notification = array(
            'message' => "Property Amenitie Delete successfully",
            'alert-type' => "success"
        );
        return redirect()->back()->with($notification);
    }//End Method
}
