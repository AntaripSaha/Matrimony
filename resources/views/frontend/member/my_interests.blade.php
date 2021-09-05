@extends('frontend.layouts.member_panel')
@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('My Interests') }}</h5>
            <a href="{{ route('interest_requests') }}" class="mb-0 h6 btn btn-primary">{{ translate('Interest Requests') }}</a>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>{{translate('Image')}}</th>
                      <th>{{translate('Name')}}</th>
                      <th>{{translate('Age')}}</th>
                      <th class="text-center">{{translate('Status')}}</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($interests as $key => $interest)
                      <tr id="interested_member_{{ $interest->user_id }}">
                          <td>{{ ($key+1) + ($interests->currentPage() - 1)*$interests->perPage() }}</td>
                          <td>
                            <img class="img-md" src="{{ URL::to('/public/images/'.$interest->user->photo) }}" height="45px"  alt="{{translate('photo')}}">
                          </td>
                          <td>{{ $interest->user->first_name.' '.$interest->user->last_name }}</td>
                          <td>{{ \Carbon\Carbon::parse($interest->user->member->birthday)->age }}</td>
                         <td class="text-center">
                             @if ($interest->status == 1)
                                 <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>
                             @else
                                 <span class="badge badge-inline badge-info">{{translate('Pending')}}</span>
                             @endif
                         </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $interests->links() }}
            </div>
        </div>
    </div>
@endsection
