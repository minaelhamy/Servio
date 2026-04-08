<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Contact;
use App\Models\User;

class OtherController extends Controller
{
    public function getcontent()
    {
        $id = User::where('type',1)->first();
        $privecypolicy = Settings::select('privacy_content')->where('vendor_id',$id->id)->first();
        $termscondition = Settings::select('terms_content')->where('vendor_id',$id->id)->first();
        $aboutus = Settings::select('about_content')->where('vendor_id',$id->id)->first();
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'privecypolicy' => $privecypolicy->privacy_content,'termscondition'=>$termscondition->terms_content,'aboutus'=>$aboutus->about_content], 200);
    }
  
    public function inquiries(Request $request)
    {
        if($request->name == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.name_required')],400);
        }
        if($request->email == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.email_required')],400);
        }
        if($request->mobile == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.email_required')],400);
        }
        if($request->message == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.message_required')],400);
        }
        $newcontact = new Contact();
        $newcontact->vendor_id = 1;
        $newcontact->name = $request->name;
        $newcontact->email = $request->email;
        $newcontact->mobile = $request->mobile;
        $newcontact->message = $request->message;
        $newcontact->save();
        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }
}
