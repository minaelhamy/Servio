<?php

namespace App\Http\Controllers\admin;

use App\helper\helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Subscriber;
use App\Models\Settings;
use App\Models\Country;
use App\Models\City;
use URL;
use Illuminate\Support\Facades\Auth;

class OtherController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $contacts = Contact::where('vendor_id', $vendor_id)->orderByDesc('id')->get();
        return view('admin.contact.index', compact('contacts'));
    }
    public function delete(Request $request)
    {
        $deletecontact = Contact::where('id', $request->id)->first();
        $deletecontact->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function inquiries_bulk_delete(Request $request)
    {
        if (!empty($request->id)) {
            foreach ($request->id as $id) {
                $inquiry = Contact::find($id);
                $inquiry->delete();
            }
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        }
         return response()->json(['status' => 0, 'msg' => trans('messages.error')], 200);
    }

    public function privacypolicy(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getprivacypolicy = helper::appdata($vendor_id)->privacy_content;
        return view('admin.other.privacypolicy', compact('getprivacypolicy'));
    }
    public function update_privacypolicy(Request $request)
    {
        $request->validate([
            'privacypolicy' => 'required',
        ], [
            'privacypolicy.required' => trans('messages.content_required'),
        ]);
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $checkprivacy = Settings::where('vendor_id', $vendor_id)->first();
        if (!empty($checkprivacy)) {
            $checkprivacy->privacy_content = $request->privacypolicy;
            $checkprivacy->update();
        } else {
            $privacy = new Settings();
            $privacy->privacy_content = $request->privacypolicy;
            $privacy->save();
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function termscondition()
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getterms = helper::appdata($vendor_id)->terms_content;
        return view('admin.other.termscondition', compact('getterms'));
    }
    public function update_terms(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'termscondition' => 'required',
        ], [
            'termscondition.required' => trans('messages.content_required'),
        ]);
        $checkterms = Settings::where('vendor_id', $vendor_id)->first();
        if (!empty($checkterms)) {
            $checkterms->terms_content = $request->termscondition;
            $checkterms->update();
        } else {
            $terms = new Settings();
            $terms->terms_content = $request->termscondition;
            $terms->save();
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }

    public function aboutus(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }

        $getaboutus = helper::appdata($vendor_id)->about_content;
        return view('admin.other.aboutus', compact('getaboutus'));
    }
    public function update_aboutus(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'aboutus' => 'required',
        ], [
            'aboutus.required' => trans('messages.content_required'),
        ]);
        $checkaboutus = Settings::where('vendor_id', $vendor_id)->first();
        if (!empty($checkaboutus)) {
            $checkaboutus->about_content = $request->aboutus;
            $checkaboutus->update();
        } else {
            $about = new Settings();
            $about->about_content = $request->aboutus;
            $about->save();
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function faq_index(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $faqs = Faq::where('vendor_id', $vendor_id)->orderBy('reorder_id')->get();
        return view('admin.faqs.index', compact('faqs'));
    }
    public function faq_add(Request $request)
    {
        return view('admin.faqs.add');
    }
    public function faq_save(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ], [
            'question.required' => trans('messages.question_required'),
            'answer.required' => trans('messages.answer_required'),

        ]);
        $faqs = new Faq();
        $faqs->vendor_id = $vendor_id;
        $faqs->question = $request->question;
        $faqs->answer = $request->answer;
        $faqs->save();
        return redirect('/admin/faqs')->with('success', trans('messages.success'));
    }
    public function faq_edit(Request $request)
    {
        $getfaq = Faq::where('id', $request->id)->first();
        return view('admin.faqs.edit', compact('getfaq'));
    }
    public function faq_update(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ], [
            'question.required' => trans('messages.question_required'),
            'answer.required' => trans('messages.answer_required'),

        ]);
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getfaq = Faq::where('id', $request->id)->first();
        $getfaq->vendor_id = $vendor_id;
        $getfaq->question = $request->question;
        $getfaq->answer = $request->answer;
        $getfaq->update();
        return redirect('/admin/faqs')->with('success', trans('messages.success'));
    }
    public function faq_delete(Request $request)
    {
        $deletefaq = Faq::where('id', $request->id)->first();
        $deletefaq->delete();
        return redirect('/admin/faqs')->with('success', trans('messages.success'));
    }

    public function faq_bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $deletefaq = Faq::where('id', $id)->first();
            $deletefaq->delete();
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
       
    }
    public function countries(Request $request)
    {

        $allcontries = Country::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.country.index', compact('allcontries'));
    }
    public function add_country(Request $request)
    {
        return view('admin.country.add');
    }
    public function save_country(Request $request)
    {

        $country = new Country();
        $country->name = $request->name;
        $country->save();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function edit_country(Request $request)
    {
        $editcountry = Country::where('id', $request->id)->first();
        return view('admin.country.edit', compact('editcountry'));
    }
    public function update_country(Request $request)
    {

        $editcountry = Country::where('id', $request->id)->first();
        $editcountry->name = $request->name;
        $editcountry->update();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function delete_country(Request $request)
    {
        $country = Country::where('id', $request->id)->first();
        $country->is_deleted = 1;
        $country->update();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function bulk_delete_country(Request $request)
    {
        foreach ($request->id as $id) {
            $country = Country::where('id', $id)->first();
            $country->is_deleted = 1;
            $country->update();
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);

    }
    public function statuschange_country(Request $request)
    {
        $country = Country::where('id', $request->id)->first();
        $country->is_available = $request->status;
        $country->update();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function cities(Request $request)
    {
        $allcities = City::with('country_info')->where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.city.index', compact('allcities'));
    }
    public function add_city(Request $request)
    {
        $allcountry = Country::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.city.add', compact('allcountry'));
    }
    public function save_city(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => trans('messages.name_required'),
        ]);
        $city = new City();
        $city->country_id = $request->country;
        $city->city = $request->name;
        $city->save();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function edit_city(Request $request)
    {
        $allcountry = Country::where('is_deleted', 2)->orderBy('reorder_id')->get();
        $editcity = City::where('id', $request->id)->first();
        return view('admin.city.edit', compact('editcity', 'allcountry'));
    }
    public function update_city(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => trans('messages.name_required'),
        ]);
        $editcity = City::where('id', $request->id)->first();
        $editcity->country_id = $request->country;
        $editcity->city = $request->name;
        $editcity->update();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function delete_city(Request $request)
    {
        $city = City::where('id', $request->id)->first();
        $city->is_deleted = 1;
        $city->update();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function bulk_delete_city(Request $request)
    {
        foreach ($request->id as $id) {
            $city = City::where('id', $id)->first();
            $city->is_deleted = 1;
            $city->update();
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);

    }
    public function statuschange_city(Request $request)
    {
        $city = City::where('id', $request->id)->first();
        $city->is_available = $request->status;
        $city->update();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function subscribers(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getsubscribers = Subscriber::where('vendor_id', $vendor_id)->orderByDesc('id')->get();
        return view('admin.subscriber.index', compact('getsubscribers'));
    }
    public function subscribers_delete(Request $request)
    {
        $subscriber = Subscriber::find($request->id);
        if (!empty($subscriber)) {
            $subscriber->delete();
            return redirect('/admin/subscribers')->with('success', trans('messages.success'));
        }
        return redirect('/admin/subscribers')->with('error', trans('messages.wrong'));
    }
    public function subscribers_bulk_delete(Request $request)
    {
        if (!empty($request->id)) {
            foreach ($request->id as $id) {
                $subscriber = Subscriber::find($id);
                $subscriber->delete();
            }
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        }else{
            return redirect('/admin/subscribers')->with('error', trans('messages.wrong'));
        }
    }
    public function share()
    {
        if (helper::checkcustomdomain(Auth::user()->id) == null) {
            $url = URL::to('/' . Auth::user()->slug);
        } else {
            $url = 'https://' . helper::checkcustomdomain(Auth::user()->id);
        }

        $shareComponent = \Share::page(
            $url
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();
        return view('admin.other.share', compact('shareComponent'));
    }
    public function refund_policy(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $policy = Settings::where('vendor_id', $vendor_id)->first();
        return view('admin.other.refundpolicy', compact('policy'));
    }
    public function refund_policy_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $policy = Settings::where('vendor_id', $vendor_id)->first();
        $policy->refund_policy = $request->refund_policy;
        $policy->update();
        return redirect('/admin/refund_policy')->with('success', trans('messages.success'));
    }
    public function reorder_country(Request $request)
    {
        $getcountry = Country::where('is_deleted', 2)->get();
        foreach ($getcountry as $country) {
            foreach ($request->order as $order) {
                $country = Country::where('id', $order['id'])->first();
                $country->reorder_id = $order['position'];
                $country->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
    public function reorder_city(Request $request)
    {
        $getcity = City::with('country_info')->where('is_deleted', 2)->get();
        foreach ($getcity as $city) {
            foreach ($request->order as $order) {
                $city = City::where('id', $order['id'])->first();
                $city->reorder_id = $order['position'];
                $city->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
    public function reorder_faqs(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getfaqs = Faq::where('vendor_id', $vendor_id)->get();
        foreach ($getfaqs as $faq) {
            foreach ($request->order as $order) {
                $faq = Faq::where('id', $order['id'])->first();
                $faq->reorder_id = $order['position'];
                $faq->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
