<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Web\GeneralServiceInterface;
use App\Interfaces\Admin\CampaignsServiceInterface;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    private $GeneralServiceInterface;

    public function __construct(GeneralServiceInterface $GeneralServiceInterface, CampaignsServiceInterface $CampaignsServiceInterface) {
        $this->GeneralServiceInterface = $GeneralServiceInterface;
        $this->CampaignsServiceInterface = $CampaignsServiceInterface;
    }

    public function home() {
        $blogRand = $this->GeneralServiceInterface->blogRand();
        $distributors = $this->GeneralServiceInterface->allListing('distributor');
        return view('web.home',compact('blogRand','distributors'));
    }

    public function dashboard() {
        $blogRand = $this->GeneralServiceInterface->blogRand();
        $listing = $this->GeneralServiceInterface->userListing(Auth::id());
        return view('web.dash',compact('blogRand','listing'));
    }

    public function add_listing() {
        $blogRand = $this->GeneralServiceInterface->blogRand();
        return view('web.addlisting',compact('blogRand'));
    }

    public function listingdetail($slug) {
        $blogRand = $this->GeneralServiceInterface->blogRand();
        $listing = $this->GeneralServiceInterface->listingDetail($slug,'distributor');
        return view('web.listingdetail',compact('blogRand','listing'));
    }

    public function subcats($id){
        return json_encode($this->GeneralServiceInterface->subCat($id));
    }

    public function listsubmit(Request $request) {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'gst' => 'required',
        //     'pan' => 'required',
        //     'brand' => 'required',
        //     'establishment' => 'required',
        //     'anualsale_start' => 'required',
        //     'anualsale_end' => 'required',
        //     'anualsale_unit' => 'required',
        //     'total_distributors' => 'required',
        //     'space' => 'required',
        //     'logo' => 'required',
        //     'address' => 'required',
        //     'city' => 'required',
        //     'state' => 'required',
        //     'zip' => 'required',
        // ],[
        //     'name.required' => 'Name is required.',
        //     'brand.required' => 'Brand name is required.',
        //     'establishment.required' => 'Establishment year is required.',
        //     'pan.required' => 'PAN is required.',
        //     'gst.required' => 'GST is required.'
        // ]);
        $this->GeneralServiceInterface->saveList($request->all(),$request->scats);
    }
    
    public function contactUsShow() {
        //return view('web.contact-us');
    }
    public function comingSoon() {
        //return view('web.coming-soon');
    }

    public function aboutUs() {
        //return view('web.about-us');
    }

    /*public function campaigns(Request $request) {
        $campList = $this->CampaignsServiceInterface->campaignsList('weblist');
        return view('web.campaigns-list',compact('campList'));
    }

    public function campaignDetail($slug) {
        $campDetail = $this->CampaignsServiceInterface->campaignDetail($slug,'web');
        $campRand = $this->CampaignsServiceInterface->campaignDetail($slug,'random');
        return view('web.campaign-details',compact('campDetail'))->with('campRand',$campRand);
    }

    public function mediaList() {
        $media = $this->GeneralServiceInterface->mediaList();
        return view('web.media-list',compact('media'));
    }

    public function ourDonorList() {
        return view('web.our-donor-list');
    }

    public function joinVolunteer() {
        return view('web.join-us-volunteer');
    }

    public function blogList() {
        $blogs = $this->GeneralServiceInterface->blogList();
        return view('web.blog-list',compact('blogs'));
    }

    public function blogDetail($slug) {
        $blogDetail = $this->GeneralServiceInterface->blogDetail($slug);
        return view('web.blog-detail',compact('blogDetail'));
    }

    public function subscribeForm(Request $request) {
        $this->validate($request, [
            'email' => 'required|email:rfc,dns,filter'
        ],[
            'email.required' => 'Email Address field is required.',
            'email.email' => 'Email Address is not valid.'
        ]);
        $this->GeneralServiceInterface->subscribeForm($request->all());
        return redirect('/');
    }
    
    public function contactUs(Request $request) {
        $this->validate($request, [
            'fname' => 'required|regex:/^[a-zA-Z ]+$/',
            'lname' => 'required|regex:/^[a-zA-Z ]+$/',
            'email' => 'required|email:rfc,dns,filter', 
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'subject' => 'required',
            'message' => 'required',
        ],[
            'fname.required' => 'First Name field is required.',
            'lname.required' => 'Last Name field is required.',
            'email.required' => 'Email Address field is required.',
            'email.email' => 'Email Address is not valid.',
            'phone.required' => 'Phone field is required.',
            'subject.required' => 'Subject field is required.',
            'message.required' => 'Message field is required.',
        ]);
        $this->GeneralServiceInterface->contactUs($request->all());
    }*/
}