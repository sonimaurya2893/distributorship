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
        $franchise = $this->GeneralServiceInterface->allListing('franchise');
        $salesagent = $this->GeneralServiceInterface->allListing('salesagent');
        return view('web.home',compact('blogRand','distributors','franchise','salesagent'));
    }

    public function dashboard() {
        //dd(Auth::user()->intrested);
        $blogRand = $this->GeneralServiceInterface->blogRand();
        $listing = $this->GeneralServiceInterface->userListing(Auth::id());
        return view('web.dash',compact('blogRand','listing'));
    }

    public function dash_gallery($id) {
        $mygals = $this->GeneralServiceInterface->gallery(Auth::user()->intrested,$id);
        if($mygals->gallery == null) {
            $gals = [];
        } else {
            $gals = json_decode($mygals->gallery);
        }
        return view('web.listing.gallery',compact('gals','id','mygals'));
    }

    public function add_listing() {
        $blogRand = $this->GeneralServiceInterface->blogRand();
        return view('web.addlisting',compact('blogRand'));
    }

    public function listingdetail($slug) {
        $blogRand = $this->GeneralServiceInterface->blogRand();
        $listing = $this->GeneralServiceInterface->listingDetail($slug,0);
        $listingcats = $this->GeneralServiceInterface->getListingCats($listing->id, 0);
        $mygals = $this->GeneralServiceInterface->gallery(0,$listing->id);
        $mcats=[];
        foreach($listingcats as $lc) {
            $mcats[] = $lc->name;
        }
        $listCat = implode(',', $mcats);
        if($mygals->gallery == null) {
            $gals = [];
        } else {
            $gals = json_decode($mygals->gallery);
        }
        $list_type = 'Distributor';
        return view('web.listingdetail',compact('blogRand','listing', 'listCat','gals','list_type'));
    }

    public function listingdetail_fr($slug) {
        $blogRand = $this->GeneralServiceInterface->blogRand();
        $listing = $this->GeneralServiceInterface->listingDetail($slug,1);
        $listingcats = $this->GeneralServiceInterface->getListingCats($listing->id, 1);
        $mygals = $this->GeneralServiceInterface->gallery(1,$listing->id);
        $mcats=[];
        foreach($listingcats as $lc) {
            $mcats[] = $lc->name;
        }
        $listCat = implode(',', $mcats);
        if($mygals->gallery == null) {
            $gals = [];
        } else {
            $gals = json_decode($mygals->gallery);
        }
        $list_type = 'Franchise';
        return view('web.listingdetail',compact('blogRand','listing', 'listCat','gals','list_type'));
    }

    public function listingdetail_sa($slug) {
        $blogRand = $this->GeneralServiceInterface->blogRand();
        $listing = $this->GeneralServiceInterface->listingDetail($slug,2);
        $listingcats = $this->GeneralServiceInterface->getListingCats($listing->id, 2);
        $mygals = $this->GeneralServiceInterface->gallery(2,$listing->id);
        $mcats=[];
        foreach($listingcats as $lc) {
            $mcats[] = $lc->name;
        }
        $listCat = implode(',', $mcats);
        if($mygals->gallery == null) {
            $gals = [];
        } else {
            $gals = json_decode($mygals->gallery);
        }
        $list_type = 'Franchise';
        return view('web.listingdetail',compact('blogRand','listing', 'listCat','gals','list_type'));
    }

    public function subcats($id){
        return json_encode($this->GeneralServiceInterface->subCat($id));
    }

    public function listsubmit(Request $request) {
        //salesagent
        if($request->listing_type=='distributor' || $request->listing_type=='franchise') {
            $this->validate($request, [
                'name' => 'required',
                'gst' => 'required',
                'pan' => 'required',
                'brand' => 'required',
                'establishment' => 'required',
                'anualsale_start' => 'required',
                'anualsale_end' => 'required',
                'anualsale_unit' => 'required',
                'total_distributors' => 'required',
                'space' => 'required',
                'logo' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required',
            ],[
                'name.required' => 'Name is required.',
                'brand.required' => 'Brand name is required.',
                'establishment.required' => 'Establishment year is required.',
                'pan.required' => 'PAN is required.',
                'gst.required' => 'GST is required.'
            ]);
        } else {
            $this->validate($request, [
                'business_profile' => 'required',
                'product_detail' => 'required',
            ],[
                'business_profile.required' => 'Profile is required.',
            ]);
        }
        $this->GeneralServiceInterface->saveList($request->all(),$request->scats);
        return redirect('/dashboard');
    }

    public function addgallery(Request $request) {
        /*$validatedData = $request->validate([
            'file' => 'required|jpg,jpeg,png|max:2048',
        ]);*/
        //dd($request);
        if($request->file('logo')) {
            $file = $request->file('logo');
            $filename = time().'_'.$file->getClientOriginalName();
            if(Auth::user()->intrested == 0) {
                $location = 'public/assets/uploads/distributors/gallary';
                $file->move($location,$filename);
            }
            $this->GeneralServiceInterface->saveImage(['id'=>$request->listing_id, 'user_id' => Auth::id(), 'type'=>Auth::user()->intrested, 'filename'=>$filename]);
        }
    }

    public function searchresult(Request $request) {
        //dd($request->all());
        if($request->stype == '0'){
            $result = $this->GeneralServiceInterface->search($request->all(),0);
            $blogRand = $this->GeneralServiceInterface->blogRand();
            return view('web.distributor_search',compact('result','blogRand'));
        }
        if($request->stype == 1){
            $result = $this->GeneralServiceInterface->search($request->all(),1);
            $blogRand = $this->GeneralServiceInterface->blogRand();
            return view('web.franchise_search',compact('result','blogRand'));
        }
        
    }
    
    public function contactUsShow() {
        return view('web.contact-us');
    }
    public function comingSoon() {
        //return view('web.coming-soon');
    }

    public function aboutUs() {
        return view('web.about-us');
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