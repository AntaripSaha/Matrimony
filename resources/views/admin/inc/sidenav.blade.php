<div class="aiz-sidebar-wrap ">
    <div class="aiz-sidebar  left c-scrollbar bg-medium-pink">
        <div class="aiz-side-nav-logo-wrap bg-medium-pink ">
            <a href="{{ route('admin.dashboard') }}" class="d-block">
                <img src="{{ uploaded_asset(get_setting('system_logo'))}}" class="img-fluid bg-medium-pink">
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <ul class="aiz-side-nav-list" data-toggle="aiz-side-menu">

                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text text-white">{{translate('Dashboard')}}</span>
                    </a>
                </li>

                <!-- Member Manage -->
                <li class="aiz-side-nav-item">
                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                        <i class="las la-user aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text text-white">{{translate('Members')}}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        @can('show_members')
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('members.index', 1)}}" class="aiz-side-nav-link  {{ areActiveRoutes(['members.edit','members.show'])}}">
                                <span class="aiz-side-nav-text text-white">{{translate('Free Members')}}</span>
                            </a>
                        </li>
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('members.index', 2)}}" class="aiz-side-nav-link  {{ areActiveRoutes(['members.edit','members.show'])}}">
                                <span class="aiz-side-nav-text text-white">{{translate('Premium Members')}}</span>
                            </a>
                        </li>
                        @endcan

                        @can('bulk_member_add')
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('member_bulk_add.index') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text text-white">{{translate('Bulk Member Add')}}</span>
                            </a>
                        </li>
                        @endcan
                        @can('deleted_member_show')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('deleted_members') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text text-white">{{translate('Deleted Members')}}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view_reported_profile')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('reported_members','all') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text text-white">{{translate('Reported Members')}}</span>
                                </a>
                            </li>
                        @endcan
                        <li class="aiz-side-nav-item">
                            <a href="javascript:void(0);" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text text-white">{{translate('Profile Attributes')}}</span>
                                <span class="aiz-side-nav-arrow"></span>
                            </a>

                            <ul class="aiz-side-nav-list level-3">
                                @can('show_religions')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('religions.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('Religions')}}</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('show_castes')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('castes.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['castes.edit'])}}">
                                            <span class="aiz-side-nav-text text-white">{{translate('Caste')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_sub_castes')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('sub-castes.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['sub-castes.edit'])}}">
                                            <span class="aiz-side-nav-text text-white">{{translate('Sub-Caste')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_member_languages')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('member-languages.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('Member Language')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_countries')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('countries.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('Country')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_states')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('states.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['states.edit'])}}">
                                            <span class="aiz-side-nav-text text-white">{{translate('State')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_cities')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('cities.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['cities.edit'])}}">
                                            <span class="aiz-side-nav-text text-white">{{translate('City')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_on_behalves')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('on-behalf.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('On Behalf')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_family_values')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('family-values.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('Family Values')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_family_status')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('family-status.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('Family Status')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_marital_status')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('marital-statuses.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('Marital Statuses')}}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                        @can('manage_profile_sections')
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('member_profile_sections_configuration') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text text-white">{{translate('Profile Sections')}}</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>

                <!-- Premium Packages -->
                @can('show_packages')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('packages.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['packages.create','packages.edit']) }}">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text text-white">{{translate('Premium Packages')}}</span>
                    </a>
                </li>
                @endcan

                <!-- Earnings -->
                @can('show_package_payments')
                <li class="aiz-side-nav-item ">
                    <a href="{{ route('package-payments.index') }}" class="aiz-side-nav-link">
                        <i class="las la-money-bill-alt aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text text-white">{{translate('Package Payments')}}</span>
                    </a>
                </li>
                @endcan

                {{-- Happy Stories --}}
                @can('show_happy_stories')
                <li class="aiz-side-nav-item ">
                    <a href="{{ route('happy-story.index') }}" class="aiz-side-nav-link">
                        <i class="las la-handshake aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text text-white">{{translate('Happy Stories')}}</span>
                    </a>
                </li>
                @endcan

                <!-- Messaging -->
                @can('newsletter')
                <li class="aiz-side-nav-item">
                    <a href="javascript:void(0);" class="aiz-side-nav-link">
                        <i class="las la-envelope aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text text-white">{{translate('Marketing')}}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">
                            <a href="{{ route('newsletters.index') }}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text text-white">{{translate('Newsletter')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                <!-- Support Ticket Addon -->
                @if(addon_activation('support_tickets'))
                    @if(auth()->user()->can('show_active_tickets') || auth()->user()->can('show_my_tickets') || auth()->user()->can('show_solved_tickets') || auth()->user()->can('show_support_categories')|| auth()->user()->can('default_ticket_assigned_agent'))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-people-carry aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text text-white">{{translate('Support Ticket')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">{{ translate('Addon') }}</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('show_active_tickets')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('support-tickets.active_ticket') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support-tickets.edit'])}}">
                                            <span class="aiz-side-nav-text text-white">{{translate('Active Tickets')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_my_tickets')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('support-tickets.my_ticket') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support-tickets.show'])}}">
                                            <span class="aiz-side-nav-text text-white">{{translate('My tickets')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('show_solved_tickets')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('support-tickets.solved_ticket') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support-tickets.show'])}}">
                                            <span class="aiz-side-nav-text text-white">{{translate('Solved tickets')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @if(auth()->user()->can('show_support_categories') || auth()->user()->can('default_ticket_assigned_agent'))
                                    <li class="aiz-side-nav-item">
                                        <a href="#" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('Support Settings')}}</span>
                                            <span class="aiz-side-nav-arrow"></span>
                                        </a>
                                        <ul class="aiz-side-nav-list level-3">
                                            @can('show_support_categories')
                                                <li class="aiz-side-nav-item">
                                                    <a href="{{ route('support-categories.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support-categories.index', 'support-categories.edit'])}}">
                                                        <span class="aiz-side-nav-text text-white">{{translate('Category')}}</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('default_ticket_assigned_agent')
                                                <li class="aiz-side-nav-item">
                                                    <a href="{{ route('default_ticket_assigned_agent') }}" class="aiz-side-nav-link">
                                                        <span class="aiz-side-nav-text text-white">{{translate('Default Asssigned Agent')}}</span>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif

                {{-- OTP addon --}}
                @if(addon_activation('otp_system'))
                    @if(auth()->user()->can('manage_sms_templates') || auth()->user()->can('manage_otp_credentials') || auth()->user()->can('send_sms'))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="las la-phone aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text text-white">{{translate('OTP System')}}</span>
                                @if (env("DEMO_MODE") == "On")
                                    <span class="badge badge-inline badge-danger">{{ translate('Addon') }}</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                @can('manage_sms_templates')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('sms-templates.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('SMS Templates')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('manage_otp_credentials')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{route('otp_credentials.index')}}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('Set OTP Credentials')}}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('send_sms')
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('bulk_sms.index') }}" class="aiz-side-nav-link">
                                            <span class="aiz-side-nav-text text-white">{{translate('Send SMS')}}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                @endif

                <!-- Uploader Manage -->
                @can('show_uploaded_files')
                <li class="aiz-side-nav-item">
                    <a href="{{ route('uploaded-files.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['uploaded-files.create'])}}">
                        <i class="las la-folder-open aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text text-white">{{ translate('Uploaded Files') }}</span>
                    </a>
                </li>
                @endcan

                <!-- Website Setup -->
                @if(auth()->user()->can('header') || auth()->user()->can('footer') || auth()->user()->can('show_all_pages') || auth()->user()->can('appearances'))
                    <li class="aiz-side-nav-item">
                        <a href="javascript:void(0);" class="aiz-side-nav-link">
                            <i class="las la-desktop aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text text-white">{{translate('Website Setup')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('header')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('website.header_settings') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text text-white">{{translate('Header')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('footer')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('website.footer_settings')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text text-white">{{translate('Footer')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_all_pages')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('custom-pages.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['website.pages', 'custom-pages.create' ,'custom-pages.edit'])}}">
                                        <span class="aiz-side-nav-text text-white">{{translate('Pages')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('appearances')
                                <li class="aiz-side-nav-item">
                                    <a href="{{route('website.appearances')}}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text text-white">{{translate('Appearance')}}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif


                <!-- General settings -->
                @if(auth()->user()->can('general_settings') ||
                    auth()->user()->can('show_languages') ||
                    auth()->user()->can('show_currencies') ||
                    auth()->user()->can('payment_methods') ||
                    auth()->user()->can('smtp_settings') ||
                    auth()->user()->can('email_templates') ||
                    auth()->user()->can('third_party_settings') ||
                    auth()->user()->can('social_media_login_settings'))
                    <li class="aiz-side-nav-item">
                        <a href="javascript:void(0);" class="aiz-side-nav-link">
                            <i class="las la-cog aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text text-white">{{translate('Settings')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('general_settings')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('general_settings') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text text-white">{{translate('General Settings')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_languages')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('languages.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['languages.show'])}}">
                                        <span class="aiz-side-nav-text text-white">{{translate('Language')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('show_currencies')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('currencies.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text text-white">{{translate('Currency')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('payment_methods')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('payment_method_settings') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text text-white">{{translate('Payment Methods')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('smtp_settings')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('smtp_settings') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text text-white">{{translate('SMTP Settings')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('email_templates')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('email-templates.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text text-white">{{translate('Email Templates')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('third_party_settings')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('third_party_settings') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text text-white">{{translate('Third Party Settings')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('social_media_login_settings')
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('social_media_login') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text text-white">{{translate('Social Media Login')}}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                <!-- Staff -->
                @if (auth()->user()->can('show_staffs') || auth()->user()->can('show_staff_roles'))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text text-white">{{translate('Staffs')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('show_staffs')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('staffs.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])}}">
                                    <span class="aiz-side-nav-text text-white">{{translate('All staffs')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('show_staff_roles')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('roles.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])}}">
                                    <span class="aiz-side-nav-text text-white">{{translate('Staff Roles')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                <!-- System -->
                @if (auth()->user()->can('system_update') || auth()->user()->can('server_status'))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-dharmachakra aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text text-white">{{translate('System')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @can('system_update')
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('system_update') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text text-white">{{translate('Update')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('server_status')
                            <li class="aiz-side-nav-item">
                                <a href="{{route('system_server')}}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text text-white">{{translate('Server status')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                <!-- Addon Manager -->
                @can('addon_manager')
                    <li class="aiz-side-nav-item">
                        <a href="{{route('addons.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['addons.index', 'addons.create'])}}">
                            <i class="las la-wrench aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text text-white">{{translate('Addon Manager')}}</span>
                        </a>
                    </li>
                @endcan

            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
