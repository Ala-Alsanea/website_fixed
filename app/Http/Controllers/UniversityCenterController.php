<?php

namespace App\Http\Controllers;

use App\Models\AttachFile;
use App\Models\Comment;
use App\Http\Requests;
use App\Models\Map;
use App\Models\Photo;
use App\Models\UniversityCenter; 
use App\Models\Section;  
use App\Models\Setting;
use App\Models\ContentSection;  
use App\Models\WebmasterSection;
use Auth;
use File;
use Helper;
use Illuminate\Http\Request;
use Redirect; 
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Mail;

class UniversityCenterController extends Controller
{
    private $uploadPath = "uploads/universitycenters/";

    // Define Default Variables

    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Permissions
        

          $universitycenters= UniversityCenter::orderby('row_no','asc')->paginate(env('BACKEND_PAGINATION'));
            return view("backEnd.universitycenters.index", compact("universitycenters"));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         
         

            return view("backEnd.universitycenters.create");
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
          
            
   $row_no = UniversityCenter::max('row_no')+1;
           
 $audioFileFinalName="";
$videoFileFinalName = "";
          

 
            // create new UniversityCenter
            $UniversityCenter = new UniversityCenter;

            // Save UniversityCenter details
        
            
            $UniversityCenter->faculty_id =$request->faculty_id;
            $UniversityCenter->row_no = $row_no;
            $UniversityCenter->title_ar = $request->title_ar;
            $UniversityCenter->title_en = $request->title_en;

            $UniversityCenter->details_ar = $request->details_ar;
            $UniversityCenter->details_en = $request->details_en;
            $UniversityCenter->url_link = $request->url_link; 
             $UniversityCenter->mobile = $request->mobile;
            $UniversityCenter->phone = $request->phone;
            $UniversityCenter->fax = $request->fax;
            $UniversityCenter->email = $request->email; 
     
            
           
            $UniversityCenter->photo_file = Helper::FilterImagePath($request->photo_file);
            $UniversityCenter->attach_file = Helper::FilterImagePath($request->attach_file); 
                $UniversityCenter->admitionbanner = Helper::FilterImagePath($request->admitionbanner);
                 $UniversityCenter->banner = Helper::FilterImagePath($request->banner);
            $UniversityCenter->icon = $request->icon;  
            $UniversityCenter->webmaster_id =0; 
            $UniversityCenter->created_by = Auth::user()->id;
            $UniversityCenter->visits = 0;
            $UniversityCenter->status = 1;

            // Meta title
            $UniversityCenter->seo_title_ar = $request->title_ar;
            $UniversityCenter->seo_title_en = $request->title_en;

            // URL Slugs
            $slugs = Helper::URLSlug($request->title_ar, $request->title_en, "UniversityCenter", 0);
            $UniversityCenter->seo_url_slug_ar = $slugs['slug_ar'];
            $UniversityCenter->seo_url_slug_en = $slugs['slug_en'];

            // Meta Description
            $UniversityCenter->seo_description_ar = mb_substr(strip_tags(stripslashes($request->details_ar)), 0, 165, 'UTF-8');
            $UniversityCenter->seo_description_en = mb_substr(strip_tags(stripslashes($request->details_en)), 0, 165, 'UTF-8');


            $UniversityCenter->save();
  

            return redirect()->action('UniversityCenterController@index',$UniversityCenter->id)->with('doneMessage',
                trans('backLang.addDone'));
      
    }

    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = Config::get('app.APP_URL') . $uploadPath;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param  int $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
          
        $universitycenters = UniversityCenter::find($id);
            if (count((array)$universitycenters) > 0) {
                //UniversityCenter universitycenters Details
              
                return view("backEnd.universitycenters.edit",compact("universitycenters"));
            } else {
                return redirect()->action('UniversityCenterController@index');
            }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @param  int $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       
            //
            $UniversityCenter = UniversityCenter::find($id);
            if (count((array)$UniversityCenter) > 0) {


           
          
            
                $UniversityCenter->title_ar = $request->title_ar;
                $UniversityCenter->title_en = $request->title_en;
                $UniversityCenter->details_ar = $request->details_ar;
                $UniversityCenter->details_en = $request->details_en;
                 $UniversityCenter->mobile = $request->mobile;
                $UniversityCenter->phone = $request->phone;
                $UniversityCenter->fax = $request->fax;
                $UniversityCenter->email = $request->email; 
               

                $UniversityCenter->photo_file = Helper::FilterImagePath($request->photo_file);
                $UniversityCenter->attach_file = Helper::FilterImagePath($request->attach_file); 
                  $UniversityCenter->admitionbanner = Helper::FilterImagePath($request->admitionbanner);
                 $UniversityCenter->banner = Helper::FilterImagePath($request->banner);
           
             $UniversityCenter->faculty_id =$request->faculty_id; 
            $UniversityCenter->icon = $request->icon;  
               
                 
                $UniversityCenter->attach_file = $request->attach_file; 
                $UniversityCenter->status = $request->status;
                $UniversityCenter->url_link = $request->url_link;
                
                $UniversityCenter->updated_by = Auth::user()->id;
                $UniversityCenter->save();

              

                return redirect()->action('UniversityCenterController@index', $id)->with('doneMessage',
                    trans('backLang.saveDone'));
            } else {
                return redirect()->action('UniversityCenterController@index');
            }
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param  int $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $UniversityCenter = UniversityCenter::find($id);
            if (count((array)$UniversityCenter) > 0) {
                 
               
                $UniversityCenter->delete();
                return redirect()->action('UniversityCenterController@index')->with('doneMessage',
                    trans('backLang.deleteDone'));
            } else {
                return redirect()->action('UniversityCenterController@index');
            }
      
    }


    /**
     * Update all selected resources in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  buttonNames , array $ids[],$webmasterId
     * @return \Illuminate\Http\Response
     */
    public function updateAll(Request $request)
    {
        
            //
            if ($request->action == "order") {
                foreach ($request->row_ids as $rowId) {
                    $UniversityCenter = UniversityCenter::find($rowId);
                    if (count((array)$UniversityCenter) > 0) {
                        $row_no_val = "row_no_" . $rowId;
                        $UniversityCenter->row_no = $request->$row_no_val;
                        $UniversityCenter->save();
                    }
                }

            } elseif ($request->action == "activate") {
                UniversityCenter::wherein('id', $request->ids)
                    ->update(['status' => 1]);

            } elseif ($request->action == "block") {
                UniversityCenter::wherein('id', $request->ids)
                    ->update(['status' => 0]);

            } elseif ($request->action == "delete") {
                // Check Permissions
                if (!@Auth::user()->permissionsGroup->delete_status) {
                    return Redirect::to(route('NoPermission'))->send();
                }
                // Delete universitycenters photo
               

             
  
              

                //Remove universitycenters
                UniversityCenter::wherein('id', $request->ids)
                    ->delete();

            }
            return redirect()->action('UniversityCenterController@index')->with('doneMessage',
                trans('backLang.saveDone'));
       
    }


    /**
     * Update SEO tab
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @param  int $webmasterId
     * @return \Illuminate\Http\Response
     */

    public
    function seo(Request $request, $id)
    {
      
            //
            $UniversityCenter = UniversityCenter::find($id);
            if (count((array)$UniversityCenter) > 0) {

                $UniversityCenter->seo_title_ar = $request->seo_title_ar;
                $UniversityCenter->seo_title_en = $request->seo_title_en;
                $UniversityCenter->seo_description_ar = $request->seo_description_ar;
                $UniversityCenter->seo_description_en = $request->seo_description_en;
                $UniversityCenter->seo_keywords_ar = $request->seo_keywords_ar;
                $UniversityCenter->seo_keywords_en = $request->seo_keywords_en;
                $UniversityCenter->updated_by = Auth::user()->id;

                //URL Slugs
                $slugs = Helper::URLSlug($request->seo_url_slug_ar, $request->seo_url_slug_en, "UniversityCenter", $id);
                $UniversityCenter->seo_url_slug_ar = $slugs['slug_ar'];
                $UniversityCenter->seo_url_slug_en = $slugs['slug_en'];

                $UniversityCenter->save();
                return redirect()->action('UniversityCenterController@edit',$id)->with('doneMessage',
                    trans('backLang.saveDone'))->with('activeTab', 'seo');
            } else {
                return redirect()->action('UniversityCenterController@index');
            }
      
    }

    
 

   /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function indexcontentscenters()
    {
        // Check Permissions
        

          $contentsections= ContentSection::where('key_content','universitycenter')->orderby('row_no','asc')->paginate(env('BACKEND_PAGINATION'));
            return view("backEnd.contentscenters.index", compact("contentsections"));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function createcontentscenters()
    {
         
         

            return view("backEnd.contentscenters.create");
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function storecontentscenters(Request $request)
    {
       
           
            
   $row_no = ContentSection::where('key_content','universitycenter')->max('row_no')+1;
           
 $audioFileFinalName="";
$videoFileFinalName = "";
          

 
            // create new ContentSection
            $ContentSection = new ContentSection;

            // Save ContentSection details
        
            
            $ContentSection->faculty_id =$request->faculty_id;
            $ContentSection->row_no = $row_no; 
            $ContentSection->father_id = $request->father_id;
            $ContentSection->title_ar = $request->title_ar;
            $ContentSection->title_en = $request->title_en;

            $ContentSection->details_ar = $request->details_ar;
            $ContentSection->details_en = $request->details_en;
            $ContentSection->url_link = $request->url_link; 
              $ContentSection->catagoryes = $request->catagoryes;  
             $ContentSection->key_content ='universitycenter';  
           
            $ContentSection->photo_file = Helper::FilterImagePath($request->photo_file);
            $ContentSection->attach_file = Helper::FilterImagePath($request->attach_file); 
              
             $ContentSection->banner = Helper::FilterImagePath($request->banner);
            $ContentSection->icon = $request->icon;  
            $ContentSection->webmaster_id =0; 
            $ContentSection->created_by = Auth::user()->id;
            $ContentSection->visits = 0;
            $ContentSection->status = 1;

            // Meta title
            $ContentSection->seo_title_ar = $request->title_ar;
            $ContentSection->seo_title_en = $request->title_en;

            // URL Slugs
            $slugs = Helper::URLSlug($request->title_ar, $request->title_en, "ContentSection", 0);
            $ContentSection->seo_url_slug_ar = $slugs['slug_ar'];
            $ContentSection->seo_url_slug_en = $slugs['slug_en'];

            // Meta Description
            $ContentSection->seo_description_ar = mb_substr(strip_tags(stripslashes($request->details_ar)), 0, 165, 'UTF-8');
            $ContentSection->seo_description_en = mb_substr(strip_tags(stripslashes($request->details_en)), 0, 165, 'UTF-8');


            $ContentSection->save();
  

            return redirect()->action('UniversityCenterController@indexcontentscenters',$ContentSection->id)->with('doneMessage',
                trans('backLang.addDone'));
      
    }

 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param  int $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function editcontentscenters($id)
    {
        
          
        $contentsections = ContentSection::find($id);
            if (count((array)$contentsections) > 0) {
                //ContentSection contentsections Details
              
                return view("backEnd.contentscenters.edit",compact("contentsections"));
            } else {
                return redirect()->action('UniversityCenterController@indexcontentscenters');
            }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @param  int $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function updatecontentscenters(Request $request,$id)
    {
       
            //
            $ContentSection = ContentSection::find($id);
            if (count((array)$ContentSection) > 0) {


           
          
            
                $ContentSection->title_ar = $request->title_ar;
                $ContentSection->title_en = $request->title_en;
                $ContentSection->details_ar = $request->details_ar;
                $ContentSection->details_en = $request->details_en;
                
               

                $ContentSection->photo_file = Helper::FilterImagePath($request->photo_file);
                $ContentSection->attach_file = Helper::FilterImagePath($request->attach_file); 
                  
                 $ContentSection->banner = Helper::FilterImagePath($request->banner);
           
             $ContentSection->faculty_id =$request->faculty_id;
             $ContentSection->father_id =$request->father_id;
              $ContentSection->icon = $request->icon;  
              $ContentSection->catagoryes = $request->catagoryes;  
              $ContentSection->key_content ='universitycenter';  
                 
                $ContentSection->attach_file = $request->attach_file; 
                $ContentSection->status = $request->status;
                $ContentSection->url_link = $request->url_link;
                
                $ContentSection->updated_by = Auth::user()->id;
                $ContentSection->save();

              

                return redirect()->action('UniversityCenterController@indexcontentscenters', $id)->with('doneMessage',
                    trans('backLang.saveDone'));
            } else {
                return redirect()->action('UniversityCenterController@indexcontentscenters');
            }
       
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param  int $webmasterId
     * @return \Illuminate\Http\Response
     */
    public function destroycontentscenters($id)
    {
        $ContentSection = ContentSection::find($id);
            if (count((array)$ContentSection) > 0) {
                
            
               
                $ContentSection->delete();
                return redirect()->action('UniversityCenterController@indexcontentscenters')->with('doneMessage',
                    trans('backLang.deleteDone'));
            } else {
                return redirect()->action('UniversityCenterController@indexcontentscenters');
            }
      
    }


    /**
     * Update all selected resources in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  buttonNames , array $ids[],$webmasterId
     * @return \Illuminate\Http\Response
     */
    public function updateAllcontentscenters(Request $request)
    {
        
            //
            if ($request->action == "order") {
                foreach ($request->row_ids as $rowId) {
                    $ContentSection = ContentSection::find($rowId);
                    if (count((array)$ContentSection) > 0) {
                        $row_no_val = "row_no_" . $rowId;
                        $ContentSection->row_no = $request->$row_no_val;
                        $ContentSection->save();
                    }
                }

            } elseif ($request->action == "activate") {
                ContentSection::wherein('id', $request->ids)
                    ->update(['status' => 1]);

            } elseif ($request->action == "block") {
                ContentSection::wherein('id', $request->ids)
                    ->update(['status' => 0]);

            } elseif ($request->action == "delete") {
                // Check Permissions
                if (!@Auth::user()->permissionsGroup->delete_status) {
                    return Redirect::to(route('NoPermission'))->send();
                }
                // Delete contentsections photo
               

             
  
              

                //Remove contentsections
                ContentSection::where('key_content','universitycenter')->wherein('id', $request->ids)
                    ->delete();

            }
            return redirect()->action('UniversityCenterController@indexcontentscenters')->with('doneMessage',
                trans('backLang.saveDone'));
       
    }


    /**
     * Update SEO tab
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @param  int $webmasterId
     * @return \Illuminate\Http\Response
     */

    public
    function seocontentscenters(Request $request, $id)
    {
      
            //
            $ContentSection = ContentSection::find($id);
            if (count((array)$ContentSection) > 0) {

                $ContentSection->seo_title_ar = $request->seo_title_ar;
                $ContentSection->seo_title_en = $request->seo_title_en;
                $ContentSection->seo_description_ar = $request->seo_description_ar;
                $ContentSection->seo_description_en = $request->seo_description_en;
                $ContentSection->seo_keywords_ar = $request->seo_keywords_ar;
                $ContentSection->seo_keywords_en = $request->seo_keywords_en;
                $ContentSection->updated_by = Auth::user()->id;

                //URL Slugs
                $slugs = Helper::URLSlug($request->seo_url_slug_ar, $request->seo_url_slug_en, "ContentSection", $id);
                $ContentSection->seo_url_slug_ar = $slugs['slug_ar'];
                $ContentSection->seo_url_slug_en = $slugs['slug_en'];

                $ContentSection->save();
                return redirect()->action('UniversityCenterController@editcontentscenters',$id)->with('doneMessage',
                    trans('backLang.saveDone'))->with('activeTab', 'seo');
            } else {
                return redirect()->action('UniversityCenterController@indexcontentscenters');
            }
      
    }
 
   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function CenterPageSubmit(Request $request,$id)
    {

         $validator = Validator::make($request->all(), [
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            //'contact_subject' => 'required|string|max:255',
            'contact_message' => 'required|string|max:255'
        ]);
   if ($validator->fails()) {
           $messages=  $validator->errors()->all();
              return response()->json([

                'Message' =>$messages[0],
                'Status' =>'0',

            ], 400);


        }
        //   $uploadedFile = $request->file('file'); 
        
        //  echo $uploadedFile; 
        //   dd($request->all());
        //  $fileName = time().'.'.$request->file;  
   
        // $request->file->move(public_path('uploads'), $fileName);
      
        if (env('NOCAPTCHA_STATUS', false)) {
            $this->validate($request, [
                'g-recaptcha-response' => 'required|captcha'
            ]);
        }
        // SITE SETTINGS
         $UniversityCenter = UniversityCenter::find($id);
        $WebsiteSettings = \App\Models\Setting::find(1);
        $site_title_var = "site_title_" . trans('backLang.boxCode');
        $site_email = $WebsiteSettings->site_webmails;
        $site_url = $WebsiteSettings->site_url;
        $site_title = $WebsiteSettings->$site_title_var;

        $Webmail = new \App\Models\Webmail;
        $Webmail->cat_id = 0;
        $Webmail->group_id = null;
        $Webmail->title = $request->contact_name;
        if (isset($request->contact_subject)) {
           $Webmail->title = $request->contact_subject;
        }
        
        $Webmail->details = $request->contact_message;
        $Webmail->date = date("Y-m-d H:i:s");
        $Webmail->from_email = $request->contact_email;
        $Webmail->from_name = $request->contact_name;
        $Webmail->from_phone = $request->contact_phone;
        $Webmail->to_email = $WebsiteSettings->site_webmails;
        $Webmail->to_name = $site_title;
        $Webmail->status = 0;
        $Webmail->flag = 0;
        $status=$Webmail->save();
 if (!$status) {
               return response()->json([

                'Message' => $obj->error.'خطأ: برجاء إعادة المحاولة',
                'Status' =>'0',

            ], 400);
          //  return response()->json($network, 500);
        }
  
        // SEND Notification Email
        if ($WebsiteSettings->notify_messages_status) {
            if (env('MAIL_USERNAME') != "") {
                Mail::send('backEnd.emails.webmail', [
                    'title' => "NEW MESSAGE:" . $request->contact_subject,
                    'details' => $request->contact_message,
                    'websiteURL' => $site_url,
                    'websiteName' => $site_title
                ], function ($message) use ($request, $site_email, $site_title) {
                    $message->from(env('NO_REPLAY_EMAIL', $request->contact_email), $request->contact_name);
                    $message->to($site_email);
                    $message->replyTo($request->contact_email, $site_title);
                    $message->subject($request->contact_subject);

                });

               Mail::send('backEnd.emails.webmail', [
                    'title' => "NEW MESSAGE:" . $request->contact_subject,
                    'details' => $request->contact_message,
                    'websiteURL' => $site_url,
                    'websiteName' => $site_title
                ], function ($message) use ($request, $site_email, $site_title) {
                    $message->from(env('NO_REPLAY_EMAIL', $request->contact_email), $request->contact_name);
                    $message->to($UniversityCenter->email);
                    $message->replyTo($request->contact_email, $site_title);
                    $message->subject($request->contact_subject);

                });




            }
        }
  return response()->json([

                'Message' =>'  تم إرسال رسالتكم بنجاح، وسنقوم بالتواصل معكم في أقرب وقت ممكن. نشكركم لمراسلتنا! ',
                'Status' =>'1',

            ], 201);
       // return "OK";
    }

  
}



             
 