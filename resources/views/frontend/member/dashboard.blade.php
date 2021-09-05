@extends('frontend.layouts.member_panel')
@section('panel_content')
    @php $user = Auth::user(); @endphp
    <div class="row gutters-5">
        <div class="col-md-4 mx-auto mb-3" >
            <div class="bg-light rounded overflow-hidden text-center p-3">
                <i class="la la-heart-o la-3x mb-3 text-primary-grad"></i>
                <div class="h4 fw-700 text-primary-grad">{{ get_remaining_value($user->id,'remaining_interest') }}</div>
                <div class="opacity-50">{{ translate('Remaining Interest') }}</div>
            </div>
        </div>
        <div class="col-md-4 mx-auto mb-3" >
            <div class="bg-light rounded overflow-hidden text-center p-3">
                <i class="las la-phone la-3x mb-3 text-primary-grad"></i>
                <div class="h4 fw-700 text-primary-grad">{{ get_remaining_value($user->id,'remaining_contact_view') }}</div>
                <div class="opacity-50 ">{{ translate('Remaining Contact View') }}</div>
            </div>
        </div>
        <div class="col-md-4 mx-auto mb-3" >
            <div class="bg-light rounded overflow-hidden text-center p-3">
                <i class="las la-image la-3x mb-3 text-primary-grad"></i>
                <div class="h4 fw-700 text-center text-primary-grad">{{ get_remaining_value($user->id,'remaining_photo_gallery') }}</div>
                <div class="opacity-50 text-center">{{ translate('Remaining Gallery Image Upload') }}</div>
            </div>
        </div>
    </div>

    <div class="row gutters-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="fs-16 mb-0">{{  translate('Current package') }}</h2>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4 mt-3">
                        <img class="mw-100 mx-auto mb-4" src="{{ uploaded_asset($user->member->package->image) }}" height="130">
                        <h5 class="mb-3 h5 fw-600">{{$user->member->package->name}}</h5>
                    </div>
                    <ul class="list-group list-group-raw fs-15 mb-4 pb-4 border-bottom">
                        <li class="list-group-item py-2">
                            <i class="las la-check text-success mr-2"></i>
                            {{ $user->member->package->express_interest }} {{ translate('Express Interests') }}
                        </li>
                        <li class="list-group-item py-2">
                            <i class="las la-check text-success mr-2"></i>
                            {{ $user->member->package->photo_gallery }} {{ translate('Galley Photo Upload') }}
                        </li>
                        <li class="list-group-item py-2">
                            <i class="las la-check text-success mr-2"></i>
                            {{ $user->member->package->contact }} {{ translate('Contact Info View') }}
                        </li>
                        <li class="list-group-item py-2 text-line-through">
                            @if( $user->member->package->auto_profile_match == 0 )
                                <i class="las la-times text-danger mr-2"></i>
                                <del class="opacity-60">{{ translate('Show Auto Profile Match') }}</del>
                            @else
                                <i class="las la-check text-success mr-2"></i>
                                {{ translate('Show Auto Profile Match') }}
                            @endif
                        </li>
                    </ul>
                    <h4 class="fs-18 mb-3">
                      {{ translate('Package expiry date') }}:
                      @if(package_validity($user->id))
                        {{ $user->member->package_validity }}
                      @else
                          <span class="text-danger">{{translate('Expired')}}</span>
                      @endif
                    </h4>
                    <a href="{{ route('packages') }}" class="btn btn-success d-inline-block">{{ translate('Upgrade Package') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="fs-16 mb-0">{{  translate('Matched profile') }}</h2>
                </div>
                <div class="card-body">
                    @if(Auth::user()->member->auto_profile_match == 1)
                    <div>
                        @forelse ($similar_profiles->shuffle()->take(5) as $similar_profile)
                          @if($similar_profile->matched_profile != null)
                            <a href="{{ route('member_profile', $similar_profile->match_id) }}" class="text-reset border rounded row no-gutters align-items-center mb-3">
                                <div class="col-auto w-100px">
                                  @php
                                      $profile_picture_show = 'ok';
                                      $profile_picture_privacy = $similar_profile->matched_profile->member->profile_picture_privacy;

                                      if($profile_picture_privacy  == '0')
                                      {
                                        $profile_picture_show = 'no';
                                      }
                                      elseif($profile_picture_privacy == 2)
                                      {
                                        if(Auth::user()->membership == 1)
                                        {
                                          $profile_picture_show = 'no';
                                        }
                                      }
                                  @endphp
                                    <img
                                        @if($profile_picture_show == 'ok')
                                        src="{{ URL::to('/public/images/'.$similar_profile->matched_profile->photo) }}"
                                        @else
                                        src="{{ static_asset('assets/img/avatar-place.png') }}"
                                        @endif
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';"
                                        class="img-fit w-100 size-100px"
                                    >
                                </div>
                                <div class="col">
                                  <div class="p-3">
                                      <h5 class="fs-16 text-body text-truncate">{{ $similar_profile->matched_profile->first_name.' '.$similar_profile->matched_profile->last_name }}</h5>
                                      <div class="fs-12 text-truncate-3">
                                          <span class="mr-1 d-inline-block">
                                            @if(!empty($similar_profile->matched_profile->member->birthday))
                                              {{ \Carbon\Carbon::parse($similar_profile->matched_profile->member->birthday)->age }} {{ translate('yrs') }},
                                            @endif
                                          </span>
                                          <span class="mr-1 d-inline-block">
                                            @if(!empty($similar_profile->matched_profile->physical_attributes->height))
                                              {{ $similar_profile->matched_profile->physical_attributes->height }} {{ translate('Feet') }},
                                            @endif
                                          </span>
                                          <span class="mr-1 d-inline-block">
                                            @if(!empty($similar_profile->matched_profile->member->marital_status->name))
                                              {{ $similar_profile->matched_profile->member->marital_status->name }},
                                            @endif
                                          </span>
                                          <span class="mr-1 d-inline-block">
                                            {{ !empty($similar_profile->matched_profile->spiritual_backgrounds->religion->name) ? $similar_profile->matched_profile->spiritual_backgrounds->religion->name.', ' : "" }}
                                          </span>
                                          <span class="mr-1 d-inline-block">
                                            {{ !empty($similar_profile->matched_profile->spiritual_backgrounds->caste->name) ? $similar_profile->matched_profile->spiritual_backgrounds->caste->name.', ' : "" }}
                                          </span>
                                          <span class="mr-1 d-inline-block">
                                            <td class="py-1">{{ !empty($similar_profile->matched_profile->spiritual_backgrounds->sub_caste->name) ? $similar_profile->matched_profile->spiritual_backgrounds->sub_caste->name : "" }}</td>
                                          </span>
                                      </div>
                                  </div>
                                </div>
                            </a>
                          @endif
                        @empty
                            <div class="alert alert-info">{{  translate('Update your partner expectation for auto match making') }}</div>
                        @endforelse
                    </div>
                    @else
                        <div class="alert alert-info">{{  translate('Upgrade your package for auto match making') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
