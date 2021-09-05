<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OTPVerificationController;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Models\Member;
use App\Models\Package;
use App\Models\Setting;
use App\Models\EmailTemplate;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\MaritalStatus;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Models\MemberLanguage;
use App\Models\Religion;
use App\Models\FamilyValue;
use App\Models\Address;
use App\Models\Education;
use App\Models\Career;
use App\Models\PhysicalAttribute;
use App\Models\Hobby;
use App\Models\Recidency;
use App\Models\SpiritualBackground;
use App\Models\Lifestyle;
use App\Models\Family;
use App\Models\PartnerExpectation;

use Mail;
use App\Mail\EmailManager;
use Notification;
use App\Notifications\DbStoreNotification;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function showRegistrationForm()
    {
        $marital_statuses   = MaritalStatus::all();
        $countries          = Country::all();
        $states             = State::all();
        $cities             = City::all();
        $languages          = MemberLanguage::all();
        $religions          = Religion::all();
        $family_values      = FamilyValue::all();
        
        return view('frontend.user_registration',compact('marital_statuses','countries','states','cities','languages','religions','family_values'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'  => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
            'photo'       => ['required'], 
            'gender'       => ['required'], 
            'date_of_birth'       => ['required'], 
            'email'       => ['required'], 
            // 'introduction'       => ['required'], 
            // 'marital_status'       => ['required'], 
            

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        $approval = get_setting('member_approval_by_admin') == 1 ? 0 : 1;
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            
            $image = $data['photo'];
            $img = time().Str::random(12).'.'.$image->getClientOriginalExtension();
            $location = public_path('images/'.$img);
            Image::make($image)->save($location);
            
            $user = User::create([
                'first_name'  => $data['first_name'],
                'last_name'   => $data['last_name'],
                'email'       => $data['email'],
                'photo'       => $img,
                'phone'       => $data['phone'],
                'password'    => Hash::make($data['password']),
                'code'        => unique_code(),
                'approved'    => $approval,
            ]);
        }
        else{
            if(addon_activation('otp_system'))
            {
                $user = User::create([
                    'first_name'  => $data['first_name'],
                    'last_name'   => $data['last_name'],
                    'phone'       => $data['phone'],
                    'password'    => Hash::make($data['password']),
                    'code'        => unique_code(),
                    'approved'    => $approval,
                    'verification_code' => rand(100000, 999999)
                ]);
            }
        }

        $member                             = new Member;
        $member->user_id                    = $user->id;
        $member->gender                     = $data['gender'];
        $member->on_behalves_id             = $data['on_behalf'];
        $member->birthday                   = date('Y-m-d', strtotime($data['date_of_birth']));

        $package                            = Package::where('id',1)->first();
        $member->current_package_id         = $package->id;
        $member->remaining_interest         = $package->express_interest;
        $member->remaining_contact_view     = $package->contact;
        $member->remaining_photo_gallery    = $package->photo_gallery;
        $member->auto_profile_match         = $package->auto_profile_match;
        $member->package_validity           = Date('Y-m-d', strtotime($package->validity." days"));
        
        
        //introduction update
        // $member->introduction = $data['introduction'];
        $member->marital_status_id  = $data['marital_status'];
        // $member->children           = $data['children'];
        $member->save();
        
        //present address
        $address = new Address;
        $address->user_id = $user->id;
        $address->country_id   = $data['present_country_id'];
        $address->state_id     = null;
        $address->city_id      = null;
        $address->postal_code  = null;
        $address->type             = 'present';
        $address->save();

        //education 
        $education              = new Education;
        $education->user_id     = $user->id;
        $education->degree      = $data['degree'];
        $education->institution = null;
        $education->start       = null;
        $education->end         = null;
        $education->present     = 1;
        $education->save();
        
        //career
        $career              = new Career;
        $career->user_id     = $user->id;
        $career->designation = $data['designation'] ?? null;
        $career->company     = $data['company'] ?? null;
        $career->start       = null;
        $career->end         = null;
        $career->present     = 1;
        $career->save();
        
        //physical attribute
        $physical_attribute = new PhysicalAttribute();
        $physical_attribute->user_id = $user->id;
        $physical_attribute->height        = $data['height'];
        // $physical_attribute->weight        = $data['weight'];
        // $physical_attribute->eye_color     = $data['eye_color'];
        // $physical_attribute->hair_color    = $data['hair_color'];
        // $physical_attribute->complexion    = $data['complexion'];
        // $physical_attribute->blood_group   = $data['blood_group'];
        // $physical_attribute->body_type     = $data['body_type'];
        // $physical_attribute->body_art      = $data['body_art'];
        // $physical_attribute->disability    = $data['disability'];
        $physical_attribute->save();
        
        //languages
        // $member->mothere_tongue     = $data['mothere_tongue'];
        // $member->known_languages    = $data['known_languages'];
        
        //hobbie 
        // $hobbies = new Hobby();
        // $hobbies->user_id = $user->id;
        // $hobbies->hobbies              = $data['hobbies'];
        // $hobbies->interests            = $data['interests'];
        // $hobbies->music                = $data['music'];
        // $hobbies->books                = $data['books'];
        // $hobbies->movies               = $data['movies'];
        // $hobbies->tv_shows             = $data['tv_shows'];
        // $hobbies->sports               = $data['sports'];
        // $hobbies->fitness_activities   = $data['fitness_activities'];
        // $hobbies->cuisines             = $data['cuisines'];
        // $hobbies->dress_styles         = $data['dress_styles'];
        // $hobbies->save();
        
        //recidencies
        // $recidencies = new Recidency();
        // $recidencies->user_id = $user->id;
        // $recidencies->birth_country_id         = $data['birth_country_id'];
        // $recidencies->recidency_country_id     = $data['recidency_country_id'];
        // $recidencies->growup_country_id        = $data['growup_country_id'];
        // $recidencies->immigration_status       = $data['immigration_status'];
        // $recidencies->save();
        
        //spiritual_backgrounds
        $spiritual_backgrounds          = new SpiritualBackground;
        $spiritual_backgrounds->user_id = $user->id;
        $spiritual_backgrounds->religion_id        = $data['member_religion_id'];
        // $spiritual_backgrounds->caste_id           = $data['member_caste_id'];
        // $spiritual_backgrounds->sub_caste_id       = $data['member_sub_caste_id'];
        // $spiritual_backgrounds->ethnicity	       = $data['ethnicity'];
        // $spiritual_backgrounds->personal_value	   = $data['personal_value'];
        // $spiritual_backgrounds->family_value_id	   = $data['family_value_id'];
        // $spiritual_backgrounds->community_value	   = $data['community_value'];
        $spiritual_backgrounds->save();
        
        //Lifestyle
        // $lifestyle             = new Lifestyle;
        // $lifestyle->user_id    = $user->id;
        // $lifestyle->diet          = $data['diet'];
        // $lifestyle->drink         = $data['drink'];
        // $lifestyle->smoke         = $data['smoke'];
        // $lifestyle->living_with   = $data['living_with'];
        // $lifestyle->save();
        
        //permanent address
        // $address = new Address;
        // $address->user_id = $user->id;
        // $address->country_id   = $data['permanent_country_id'];
        // $address->state_id     = $data['permanent_state_id'];
        // $address->city_id      = $data['permanent_city_id'];
        // $address->postal_code  = $data['permanent_postal_code'];
        // $address->type             = 'permanent';
        // $address->save();
        
        //family
        // $family           = new Family;
        // $family->user_id  = $user->id;
        // $family->father    = $data['father'];
        // $family->mother    = $data['mother'];
        // $family->sibling   = $data['sibling'];
        // $family->save();
        
        //partner_expectations
        // $partner_expectations           = new PartnerExpectation;
        // $partner_expectations->user_id  = $user->id;
        // $partner_expectations->general                   = $data['general'];
        // $partner_expectations->height                    = $data['partner_height'];
        // $partner_expectations->weight                    = $data['partner_weight'];
        // $partner_expectations->marital_status_id         = $data['partner_marital_status'];
        // $partner_expectations->children_acceptable       = $data['partner_children_acceptable'];
        // $partner_expectations->residence_country_id      = $data['residence_country_id'];
        // $partner_expectations->religion_id               = $data['partner_religion_id'];
        // $partner_expectations->caste_id                  = $data['partner_caste_id'];
        // $partner_expectations->sub_caste_id              = $data['partner_sub_caste_id'];
        // $partner_expectations->education                 = $data['pertner_education'];
        // $partner_expectations->profession                = $data['partner_profession'];
        // $partner_expectations->smoking_acceptable        = $data['smoking_acceptable'];
        // $partner_expectations->drinking_acceptable       = $data['drinking_acceptable'];
        // $partner_expectations->diet                      = $data['partner_diet'];
        // $partner_expectations->body_type                 = $data['partner_body_type'];
        // $partner_expectations->personal_value            = $data['partner_personal_value'];
        // $partner_expectations->manglik                   = $data['partner_manglik'];
        // $partner_expectations->language_id               = $data['language_id'];
        // $partner_expectations->family_value_id           = $data['family_value_id'];
        // $partner_expectations->preferred_country_id      = $data['partner_country_id'];
        // $partner_expectations->preferred_state_id        = $data['partner_state_id'];
        // $partner_expectations->complexion                = $data['pertner_complexion'];
        // $partner_expectations->save();
        
        
        
        
        
        if(addon_activation('otp_system') && $data['phone'] != null)
        {
            $otpController = new OTPVerificationController;
            $otpController->send_code($user);
        }

        // Email to member
        if($data['email'] != null  && env('MAIL_USERNAME') != null)
        {
            $account_oppening_email = EmailTemplate::where('identifier','account_oppening_email')->first();
            if($account_oppening_email->status == 1)
            {
                EmailUtility::account_oppening_email($user, $data['password']);
            }
        }
        
        $religion = !empty($user->spiritual_backgrounds->religion->name) ? $user->spiritual_backgrounds->religion->name : "";
        $height = !empty($user->physical_attributes->height) ? $user->physical_attributes->height : "";
        $gender = ( $user->member->gender == 1 ) ? 'Male' : 'Female';
        
        //send sms
        $url = 'http://isms.zaman-it.com/smsapimany';
        $data = [
                    'api_key' => 'R20000185d4afaa187f594.83659319',
                    'senderid' => '8809612776677',
                    'messages' => json_encode([
                    [
                        'to' => '01973009007',
                        // 'to' => '01858361812',
                        'message' => "New User Registration From rightmatchbd.com \n\nName : $user->first_name $user->last_name \nGender : $gender \nPhone : $user->phone \nReligion : $religion \nHeight : $height",
                    ],
                    [
                        'to' => $user->phone,
                        'message' => "Thanks for your registration. Please complete your profile and expectation as soon as possible. \nHotline Number : +8801938898350"
                    ]
                    ]),
                ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        return $user;

    }

    public function register(Request $request)
    {
        
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if(User::where('email', $request->email)->first() != null){
                flash(translate('Email or Phone already exists.'));
                return back();
            }
        }
        elseif (User::where('phone', '+88'.$request->phone)->first() != null) {
            flash(translate('Phone already exists.'));
            return back();
        }

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        if(get_setting('member_approval_by_admin') != 1 )
        {
          $this->guard()->login($user);
        }
    
        try{
            $notify_type = 'member_registration';
            $id = unique_notify_id();
            $notify_by = $user->id;
            $info_id = $user->id;
            $message = translate('A new member has been registered to your system. Name: ').$user->first_name.' '.$user->last_name;
            $route = 'members.index';

            Notification::send(User::where('user_type', 'admin')->first(), new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
        }
        catch(\Exception $e){
            // dd($e);
        }

        if($user->email != null  && env('MAIL_USERNAME') != null && (get_email_template('account_opening_email_to_admin','status') == 1))
        {
            $admin = User::where('user_type', 'admin')->first();
            EmailUtility::account_opening_email_to_admin($user, $admin);
        }


        if($user->email != null){
            if(get_setting('email_verification') != 1){
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                flash(translate('Registration successfull.'))->success();
            }
            else {
                event(new Registered($user));
                flash(translate('Registration successfull. Please verify your email.'))->success();
            }
        }
        if($user->phone != null){
          flash(translate('Registration successfull. Please verify your phone number.'))->success();
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        if(get_setting('member_approval_by_admin') == 1 )
        {
          return redirect()->route('home');
        }
        else {
          return redirect()->route('dashboard');
        }
    }
}
