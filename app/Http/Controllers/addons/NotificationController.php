<?php



namespace App\Http\Controllers\addons;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class NotificationController extends Controller

{
    
   public function getorder()
   {
    if(Auth::user()->type == 4){
        $vendor_id = Auth::user()->vendor_id;
     }else{
        $vendor_id = Auth::user()->id;
     }
       $todayorders = Booking::whereDate('created_at', Carbon::today())->where('is_notification', '=', '1')->where('vendor_id', $vendor_id)->count();
       return json_encode($todayorders);
   }
}
