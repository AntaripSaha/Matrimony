@extends('frontend.layouts.app')

@section('content')
<div class="py-4 py-lg-5">
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-6 col-md-8 mx-auto">
				<div class="card">
					<div class="card-body">

						<div class="mb-5 text-center">
							<h1 class="h3 text-primary mb-0">{{ translate('Create Your Account') }}</h1>
							<p>{{ translate('Fill out the form to get started') }}.</p>
						</div>
						<form class="form-default" id="reg-form" role="form" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
						    
                  
							@csrf
							
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-3">
										<label class="form-label" for="on_behalf">{{ translate('On Behalf') }}</label>
										@php $on_behalves = \App\Models\OnBehalf::all(); @endphp
										<select class="form-control aiz-selectpicker @error('on_behalf') is-invalid @enderror" name="on_behalf" required>
											@foreach ($on_behalves as $on_behalf)
												<option value="{{$on_behalf->id}}">{{$on_behalf->name}}</option>
											@endforeach
										</select>
										@error('on_behalf')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
							
							<div class="row">
						        <div class="col-lg-6">
						            <div class="form-group mb-3">
										<label class="form-label" for="name">{{ translate('First Name') }}</label>
										<input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="{{translate('First Name')}}"  required>
										@error('first_name')
											<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
						            </div>
						        </div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="name">{{ translate('Last Name') }}</label>
										<input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" placeholder="{{ translate('Last Name') }}"  required>
										@error('last_name')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
    						</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="gender">{{ translate('Gender') }}</label>
										<select class="form-control aiz-selectpicker @error('gender') is-invalid @enderror" name="gender" required>
											<option value="1">{{translate('Male')}}</option>
											<option value="2">{{translate('Female')}}</option>
										</select>
										@error('gender')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="name">{{ translate('Date Of Birth') }}</label>
										<input type="text" class="form-control aiz-date-range @error('date_of_birth') is-invalid @enderror" name="date_of_birth" id="date_of_birth" placeholder="{{ translate('Date Of Birth') }}" data-single="true" data-show-dropdown="true"  required>
										@error('date_of_birth')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
							@if(addon_activation('otp_system'))
								<div>
									<div class="d-flex justify-content-between align-items-start">
										<label class="form-label" for="email">{{ translate('Email / Phone') }}</label>
										<button class="btn btn-link p-0 opacity-50 text-reset fs-12" type="button" onclick="toggleEmailPhone(this)">{{ translate('Use Email Instead') }}</button>
									</div>
									<div class="form-group phone-form-group mb-1">
							            <input type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
							        </div>

							        <input type="hidden" name="country_code" value="">

							        <div class="form-group email-form-group mb-1 d-none">
							            <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email"  autocomplete="off">
							            @if ($errors->has('email'))
							                <span class="invalid-feedback" role="alert">
							                    <strong>{{ $errors->first('email') }}</strong>
							                </span>
							            @endif
							        </div>
							    </div>
							@else
								<div class="row">
									<div class="col-lg-12">
									  <div class="form-group mb-3">
											<label class="form-label" for="email">{{ translate('Email address') }}</label>
											<input type="email" class="form-control @error('email') is-invalid @enderror" required name="email" id="signinSrEmail" placeholder="{{ translate('Email Address') }}" >
									        @error('email')
									            <span class="invalid-feedback" role="alert">{{ $message }}</span>
									        @enderror
									  </div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
									  <div class="form-group mb-3">
											<label class="form-label" for="phone">{{ translate('Phone Number') }}</label>
											<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" required placeholder="{{ translate('Phone Number') }}" >
									        @error('phone')
									            <span class="invalid-feedback" role="alert">{{ $message }}</span>
									        @enderror
									  </div>
									</div>
								</div>
							@endif
							<div class="row">
							    
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="password">{{ translate('Password') }}</label>
										<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="********" aria-label="********" required>
										<small>{{ translate('Minimun 8 characters') }}</small>
										@error('password')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="password-confirm">{{ translate('Confirm password') }}</label>
										<input type="password" class="form-control" name="password_confirmation" id="password-confirm" placeholder="********" required>
										<small>{{ translate('Minimun 8 characters') }}</small>
									</div>
								</div>
								
								<div class="col-md-12 form-group">
                                    <label for="first_name" >{{translate('Marital Status')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control aiz-selectpicker" name="marital_status" data-live-search="true" required>
                                        @foreach ($marital_statuses as $marital_status)
                                            <option value="{{$marital_status->id}}" >{{$marital_status->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('marital_status')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="height">{{translate('Height')}}</label>
                                    <input type="number" name="height" step="0.1" class="form-control" placeholder="{{translate('5.5')}}" required>
                                    @error('height')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                 <div class="col-md-6 form-group">
                                    <label for="member_religion_id">{{translate('Religion')}}</label>
                                    <select class="form-control aiz-selectpicker" name="member_religion_id" id="member_religion_id" data-live-search="true" required>
                                        <option value="">{{translate('Select One')}}</option>
                                        @foreach ($religions as $religion)
                                            <option value="{{$religion->id}}"> {{ $religion->name }} </option>
                                        @endforeach
                                    </select>
                                    @error('member_religion_id')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <!-- Country -->
                                <div class="col-md-6 form-group">
                                    <label for="present_country_id">{{translate('Living In')}}</label>
                                    <select class="form-control aiz-selectpicker" name="present_country_id" id="present_country_id" data-live-search="true" required>
                                        <option value="">{{translate('Select One')}}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{$country->id}}" @if( $country->name == "Bangladesh" ) selected @endif >{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('present_country_id')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <!-- degree -->
                                <div class="col-md-6 form-group">
                                    <label for="degree">{{translate('Last educational Degree')}}</label>
                                    <input type="text" name="degree" class="form-control" placeholder="{{translate('Last educational Degree')}}" required>
                                </div>
                                
                                <!-- designation -->
                                <div class="col-md-6 form-group">
                                    <label for="designation">{{translate('Designation')}}</label>
                                    <input type="text" name="designation" class="form-control" placeholder="{{translate('Designation')}}">
                                </div>
                                
                                <!-- company -->
                                <div class="col-md-6 form-group">
                                    <label for="company">{{translate('Company')}}</label>
                                    <input type="text" name="company" class="form-control" placeholder="{{translate('Company')}}">
                                </div>
            
							</div>
							<div class="form-group row">
                                <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Image*')}} <small>(90x90)</small></label>
                                  <div class="col-md-9">
                                       <input type="file" name="photo" class="selected-files" required>
                                       @error('photo')
        									<span class="invalid-feedback" role="alert">{{ $message }}</span>
        								@enderror
                                 </div>
                            </div>
                            
							@if(get_setting('google_recaptcha_activation') == 1)
							<div class="form-group">
								<div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
							</div>
							@endif

							<div class="mb-3">
								<label class="aiz-checkbox">
								<input type="checkbox" name="checkbox_example_1" required>
									<span class=opacity-60>{{ translate('By signing up you agree to our')}}
										<a href="{{ env('APP_URL').'/terms-conditions' }}" target="_blank">{{ translate('terms and conditions')}}.</a>
									</span>
									<span class="aiz-square-check"></span>
								</label>
							</div>

							<div class="mb-5">
								<button type="submit" class="btn btn-block btn-primary">{{ translate('Create Account') }}</button>
							</div>
							@if(get_setting('google_login_activation') == 1 || get_setting('facebook_login_activation') == 1 || get_setting('twitter_login_activation') == 1)
			                <div class="mb-5">
			                    <div class="separator mb-3">
			                        <span class="bg-white px-3">{{ translate('Or Join With') }}</span>
			                    </div>
	                    		<ul class="list-inline social colored text-center">
									@if(get_setting('facebook_login_activation') == 1)
			                        <li class="list-inline-item">
			                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook" title="{{ translate('Facebook') }}"><i class="lab la-facebook-f"></i></a>
			                        </li>
									@endif
									@if(get_setting('google_login_activation') == 1)
									<li class="list-inline-item">
										<a href="{{ route('social.login', ['provider' => 'google']) }}" class="google" title="{{ translate('Google') }}"><i class="lab la-google"></i></a>
									</li>
									@endif
									@if(get_setting('twitter_login_activation') == 1)
			                        <li class="list-inline-item">
			                            <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter" title="{{ translate('Twitter') }}"><i class="lab la-twitter"></i></a>
			                        </li>
									@endif
								</ul>
							</div>
							@endif

							<div class="text-center">
								<p class="text-muted mb-0">{{ translate("Already have an account?") }}</p>
								<a href="{{ route('login') }}">{{ translate('Login to your account') }}</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


@section('script')




<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
		// making the CAPTCHA  a required field for form submission
		@if(get_setting('google_recaptcha_activation') == 1)
				$(document).ready(function(){
				// alert('helloman');
				$("#reg-form").on("submit", function(evt)
				{
					var response = grecaptcha.getResponse();
					if(response.length == 0)
					{
						//reCaptcha not verified
						alert("please verify you are humann!");
						evt.preventDefault();
						return false;
					}
					//captcha verified
					//do the rest of your validations here
					$("#reg-form").submit();
				});
		});
		@endif


    var isPhoneShown = true,
        countryData = window.intlTelInputGlobals.getCountryData(),
        input = document.querySelector("#phone-code");

    for (var i = 0; i < countryData.length; i++) {
        var country = countryData[i];
        if(country.iso2 == 'bd'){
            country.dialCode = '88';
        }
    }

    var iti = intlTelInput(input, {
        separateDialCode: true,
        utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
        onlyCountries: @php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            if(selectedCountryData.iso2 == 'bd'){
                return "01xxxxxxxxx";
            }
            return selectedCountryPlaceholder;
        }
    });

    var country = iti.getSelectedCountryData();
    $('input[name=country_code]').val(country.dialCode);

    input.addEventListener("countrychange", function(e) {
        // var currentMask = e.currentTarget.placeholder;

        var country = iti.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode);

    });

	function toggleEmailPhone(el){
	    if(isPhoneShown){
	        $('.phone-form-group').addClass('d-none');
	        $('.email-form-group').removeClass('d-none');
	        isPhoneShown = false;
	        $(el).html('{{ translate('Use Phone Instead') }}');
	    }
	    else{
	        $('.phone-form-group').removeClass('d-none');
	        $('.email-form-group').addClass('d-none');
	        isPhoneShown = true;
	        $(el).html('{{ translate('Use Email Instead') }}');
	    }
	}
</script>
@endsection
