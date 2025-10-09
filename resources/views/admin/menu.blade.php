@php
    $admin_logo=getSettingsValByName('company_logo');
    $ids     = parentId();
    $authUser=\App\Models\User::find($ids);
 $subscription = \App\Models\Subscription::find($authUser->subscription);
 $routeName=\Request::route()->getName();
@endphp
<aside class="codex-sidebar sidebar-{{$settings['sidebar_mode']}}">
    <div class="logo-gridwrap">
        <a class="codexbrand-logo" href="{{route('home')}}">
            <img class="img-fluid"
                 src="{{ asset('images\Logo Utama.png') }}"
                 alt="Otto Parking">
        </a>
        <a class="codex-darklogo" href="{{route('home')}}">
            <img class="img-fluid"
                 src="{{ asset('images\Logo Utama.png') }}"
                 alt="Otto Parking"></a>
        <div class="sidebar-action"><i data-feather="menu"></i></div>
    </div>
    <div class="icon-logo">
        <a href="{{route('home')}}">
            <img class="img-fluid"
                 src="{{ asset('images\Logo Utama.png') }}"
                 alt="Otto Parking">
        </a>
    </div>
    <div class="codex-menuwrapper">
        <ul class="codex-menu custom-scroll" data-simplebar>
            <li class="cdxmenu-title">
                <h5>{{__('Home')}}</h5>
            </li>
            <li class="menu-item {{in_array($routeName,['dashboard',''])?'active':''}}">
                <a href="{{route('dashboard')}}">
                    <div class="icon-item"><i data-feather="home"></i></div>
                    <span>{{__('Dashboard')}}</span>
                </a>
            </li>
            @if(\Auth::user()->type=='super admin')
                @if(Gate::check('manage user'))
                <li class="menu-item {{in_array($routeName,['users.index','logged.history','role.index','role.create','role.edit'])?'active':''}}">
                    <a href="javascript:void(0);">
                        <div class="icon-item"><i data-feather="users"></i></div>
                        <span>{{__('Staff Management')}}</span><i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="submenu-list"
                        style="display: {{in_array($routeName,['users.index','logged.history','role.index','role.create','role.edit'])?'block':'none'}}">
                        @if(Gate::check('manage role'))
                            <li class="menu-item {{in_array($routeName,['role.index','role.create','role.edit'])?'active':''}}">
                                <a href="{{route('role.index')}}">{{__('Roles')}}  </a>
                            </li>
                        @endif
                        @if(Gate::check('manage user'))
                            <li class="{{in_array($routeName,['users.index'])?'active':''}}">
                                <a href="{{route('users.index')}}">{{__('Users')}}</a>
                            </li>
                        @endif
                        @if(Gate::check('manage logged history') )
                            <li class="{{in_array($routeName,['logged.history'])?'active':''}}">
                                <a href="{{route('logged.history')}}">{{__('Logged History')}}</a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif
            @else
                @if(Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage logged history') )
                    <li class="menu-item {{in_array($routeName,['users.index','logged.history','role.index','role.create','role.edit'])?'active':''}}">
                        <a href="javascript:void(0);">
                            <div class="icon-item"><i data-feather="users"></i></div>
                            <span>{{__('Staff Management')}}</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="submenu-list"
                            style="display: {{in_array($routeName,['users.index','logged.history','role.index','role.create','role.edit'])?'block':'none'}}">
                            @if(Gate::check('manage role'))
                                <li class="menu-item {{in_array($routeName,['role.index','role.create','role.edit'])?'active':''}}">
                                    <a href="{{route('role.index')}}">{{__('Roles')}}  </a>
                                </li>
                            @endif
                            @if(Gate::check('manage user'))
                                <li class="{{in_array($routeName,['users.index'])?'active':''}}">
                                    <a href="{{route('users.index')}}">{{__('Users')}}</a>
                                </li>
                            @endif
                            @if(Gate::check('manage logged history') )
                                <li class="{{in_array($routeName,['logged.history'])?'active':''}}">
                                    <a href="{{route('logged.history')}}">{{__('Logged History')}}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif
        
            @if( Gate::check('manage hotel') )
                <li class="cdxmenu-title">
                    <h5>{{__('Hotel Management')}}</h5>
                </li>
                @if(Gate::check('manage hotel'))
                    <li class="menu-item {{in_array($routeName,['hotel.index'])?'active':''}}">
                        <a href="{{route('hotel.index')}}">
                            <div class="icon-item"><i data-feather="file-text"></i></div>
                            <span>{{__('Compliment List')}}</span>
                        </a>
                    </li>
                @endif
                
              

            @endif
            <li class="cdxmenu-title">
                    <h5>{{__('Hotel Management')}}</h5>
                </li>
                @if(!Gate::check('manage hotel'))
                    <li class="menu-item {{in_array($routeName,['hotel.index'])?'active':''}}">
                        <a href="{{route('hotel.index')}}">
                            <div class="icon-item"><i data-feather="file-text"></i></div>
                            <span>{{__('Compliment List')}}</span>
                        </a>
                    </li>
                @endif

            @if( Gate::check('manage parking rate') ||  Gate::check('manage parking slot') ||  Gate::check('manage rfid vehicle') ||  Gate::check('manage parking') || Gate::check('manage contact') || Gate::check('manage support') || Gate::check('manage note') )
                <li class="cdxmenu-title">
                    <h5>{{__('Parking Capacity')}}</h5>
                </li>

                @if(Gate::check('manage parking'))
                <li class="menu-item {{in_array($routeName,['parking.index','parking.show'])?'active':''}}">
                    <a href="{{route('parking.index')}}">
                        <div class="icon-item"><i data-feather="trello"></i></div>
                        <span>{{__('Parked Vehicle')}}</span>
                    </a>
                </li>
                @endif

            @endif


            @if( Gate::check('manage parking rate') ||  Gate::check('manage parking slot') ||  Gate::check('manage rfid vehicle') ||  Gate::check('manage parking') || Gate::check('manage contact') || Gate::check('manage support') || Gate::check('manage note') )
                <li class="cdxmenu-title">
                    <h5>{{__('Business Management')}}</h5>
                </li>
                @if(Gate::check('manage parking rate'))
                    <li class="menu-item {{in_array($routeName,['parking-rate.index'])?'active':''}}">
                        <a href="{{route('parking-rate.index')}}">
                            <div class="icon-item"><i data-feather="file-text"></i></div>
                            <span>{{__('Parking Rate')}}</span>
                        </a>
                    </li>
                @endif
                @if(Gate::check('manage parking slot'))
                    <li class="menu-item {{in_array($routeName,['parking-slot.index'])?'active':''}}">
                        <a href="{{route('parking-slot.index')}}">
                            <div class="icon-item"><i data-feather="map"></i></div>
                            <span>{{__('Parking Slot')}}</span>
                        </a>
                    </li>
                @endif
                
                @if(Gate::check('manage rfid vehicle'))
                    <li class="menu-item {{in_array($routeName,['company.index'])?'active':''}}">
                        <a href="{{route('company.index')}}">
                            <div class="icon-item"><i data-feather="truck"></i></div>
                            <span>{{__('Company')}}</span>
                        </a>
                    </li>
                @endif
                
                @if(Gate::check('manage rfid vehicle'))
                    <li class="menu-item {{in_array($routeName,['rfid-vehicle.index'])?'active':''}}">
                        <a href="{{route('rfid-vehicle.index')}}">
                            <div class="icon-item"><i data-feather="truck"></i></div>
                            <span>{{__('RFID Vehicle')}}</span>
                        </a>
                    </li>
                @endif

                @if(Gate::check('manage rfid vehicle'))
                    <li class="menu-item {{in_array($routeName,['rfid-extend.index'])?'active':''}}">
                        <a href="{{route('rfid-extend.index')}}">
                            <div class="icon-item"><i data-feather="truck"></i></div>
                            <span>{{__('RFID Extend')}}</span>
                        </a>
                    </li>
                @endif

                {{-- @if(Gate::check('manage parking'))
                    <li class="menu-item {{in_array($routeName,['parked.vehicle'])?'active':''}}">
                        <a href="{{route('parked.vehicle')}}">
                            <div class="icon-item"><i data-feather="slash"></i></div>
                            <span>{{__('Parked Vehicle')}}</span>
                        </a>
                    </li>
                @endif --}}
                {{-- @if(Gate::check('manage parking'))
                    <li class="menu-item {{in_array($routeName,['parked.member.motor'])?'active':''}}">
                        <a href="{{route('parked.member.motor')}}">
                            <div class="icon-item"><i data-feather="bycle"></i></div>
                            <span>{{__('Parked Member Motor')}}</span>
                        </a>
                    </li>
                @endif
                @if(Gate::check('manage parking'))
                    <li class="menu-item {{in_array($routeName,['parked.member.mobil'])?'active':''}}">
                        <a href="{{route('parked.member.mobil')}}">
                            <div class="icon-item"><i data-feather="car"></i></div>
                            <span>{{__('Parked Member Mobil')}}</span>
                        </a>
                    </li>
                @endif
                @if(Gate::check('manage contact'))
                    <li class="menu-item {{in_array($routeName,['contact.index'])?'active':''}}">
                        <a href="{{route('contact.index')}}">
                            <div class="icon-item"><i data-feather="phone-call"></i></div>
                            <span>{{__('Contacts')}}</span>
                        </a>
                    </li>
                @endif

                @if(Gate::check('manage note'))
                    <li class="menu-item {{in_array($routeName,['note.index'])?'active':''}} ">
                        <a href="{{route('note.index')}}">
                            <div class="icon-item"><i data-feather="file-text"></i></div>
                            <span>{{__('Notes')}}</span>
                        </a>
                    </li>
                @endif --}}

            @endif
            @if(\Auth::user()->type=='super admin' || \Auth::user()->type=='owner')
            <li class="cdxmenu-title">
                <h5>{{__('Report Transactions')}}</h5>
            </li>

            {{-- <li class="menu-item {{in_array($routeName,['report.summary.amount',''])?'active':''}}">
                <a href="{{route('report.summary.amount')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Settlement')}}</span>
                </a>
            </li> --}}

            <li class="menu-item {{in_array($routeName,['report.hotel',''])?'active':''}}">
                <a href="{{route('report.hotel')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Transaksi Hotel')}}</span>
                </a>
            </li>
            
            <li class="menu-item {{in_array($routeName,['report.summary.qty',''])?'active':''}}">
                <a href="{{route('report.summary.qty')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Summary Qty')}}</span>
                </a>
            </li>

            <li class="menu-item {{in_array($routeName,['report.summary.amount',''])?'active':''}}">
                <a href="{{route('report.summary.amount')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Summary Amount')}}</span>
                </a>
            </li>

            {{-- Untuk Voucher True Blue --}}
            {{-- <li class="menu-item {{in_array($routeName,['report.summary.voucher.hotel',''])?'active':''}}">
                <a href="{{route('report.summary.voucher.hotel')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Penggunaan Voucher Hotel')}}</span>
                </a>
            </li> --}}

            {{-- Untuk Vocuher Gelael --}}
            <li class="menu-item {{in_array($routeName,['report.voucher.gelael',''])?'active':''}}">
                <a href="{{route('report.voucher.gelael')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Penggunaan Voucher Gelael')}}</span>
                </a>
            </li>
            
            <li class="menu-item {{in_array($routeName,['reportdaily.index',''])?'active':''}}">
                <a href="{{route('reportdaily.index')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Harian')}}</span>
                </a>
            </li>

            <li class="menu-item {{in_array($routeName,['report.on',''])?'active':''}}">
                <a href="{{route('report.on')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Close ON')}}</span>
                </a>
            </li>

            <li class="menu-item {{in_array($routeName,['report.pajak',''])?'active':''}}">
                <a href="{{route('report.pajak')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Pajak')}}</span>
                </a>
            </li>
            
            
            <li class="cdxmenu-title">
                <h5>{{__('Report Member')}}</h5>
            </li>
            <li class="menu-item {{in_array($routeName,['reportmember.nonpayment',''])?'active':''}}">
                <a href="{{route('reportmember.nonpayment')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Riwayat Edit Data Member')}}</span>
                </a>
            </li>

            <li class="menu-item {{in_array($routeName,['reportmember.daily',''])?'active':''}}">
                <a href="{{route('reportmember.daily')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Perpanjangan Member')}}</span>
                </a>
            </li>

            @endif

            @if(\Auth::user()->type=='super admin' || \Auth::user()->type=='owner')
            <li class="cdxmenu-title">
                <h5>{{__('Tanda Terima Member')}}</h5>
            </li>

            {{-- <li class="menu-item {{in_array($routeName,['report.summary.amount',''])?'active':''}}">
                <a href="{{route('report.summary.amount')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Report Settlement')}}</span>
                </a>
            </li> --}}

            <li class="menu-item {{in_array($routeName,['tanda.terima.member',''])?'active':''}}">
                <a href="{{route('tanda.terima.member')}}">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span>{{__('Tanda Terima')}}</span>
                </a>
            </li>
            

            @endif

            @if( Gate::check('manage parking zone') || Gate::check('manage gatetype') || Gate::check('manage vehicle_type') || Gate::check('manage floor'))
                <li class="cdxmenu-title">
                    <h5>{{__('System Setup')}}</h5>
                </li>
                @if(Gate::check('manage parking zone'))
                    <li class="menu-item {{in_array($routeName,['parking-zone.index'])?'active':''}}">
                        <a href="{{route('parking-zone.index')}}">
                            <div class="icon-item"><i data-feather="hard-drive"></i></div>
                            <span>{{__('Parking Zone')}}</span>
                        </a>
                    </li>
                @endif
                @if(Gate::check('manage parking zone'))
                <li class="menu-item {{in_array($routeName,['gate-type.index'])?'active':''}}">
                    <a href="{{route('gate-type.index')}}">
                        <div class="icon-item"><i data-feather="sliders"></i></div>
                        <span>{{__('Gate Type')}}</span>
                    </a>
                </li>
                @endif
                @if(Gate::check('manage vehicle type'))
                    <li class="menu-item {{in_array($routeName,['vehicle-type.index'])?'active':''}}">
                        <a href="{{route('vehicle-type.index')}}">
                            <div class="icon-item"><i data-feather="sliders"></i></div>
                            <span>{{__('Vehicle Type')}}</span>
                        </a>
                    </li>
                @endif
                @if(Gate::check('manage floor'))
                    <li class="menu-item {{in_array($routeName,['floor.index'])?'active':''}}">
                        <a href="{{route('floor.index')}}">
                            <div class="icon-item"><i data-feather="layers"></i></div>
                            <span>{{__('Parking Floor')}}</span>
                        </a>
                    </li>
                @endif
            @endif
            @if(Gate::check('manage pricing packages') || Gate::check('manage pricing transation') || Gate::check('manage account settings') || Gate::check('manage password settings') || Gate::check('manage general settings') || Gate::check('manage company settings'))
                <li class="cdxmenu-title">
                    <h5>{{__('System Settings')}}</h5>
                </li>
                @if(Gate::check('manage pricing packages') || Gate::check('manage pricing transation'))
                    <li class="menu-item {{in_array($routeName,['subscriptions.index','subscriptions.show','subscription.transaction'])?'active':''}}">
                        <a href="javascript:void(0);">
                            <div class="icon-item"><i data-feather="database"></i></div>
                            <span>{{__('Pricing')}}</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="submenu-list"
                            style="display: {{in_array($routeName,['subscriptions.index','subscriptions.show','subscription.transaction'])?'block':'none'}}">
                            @if(Gate::check('manage pricing packages'))
                                <li class="{{in_array($routeName,['subscriptions.index','subscriptions.show'])?'active':''}}">
                                    <a href="{{route('subscriptions.index')}}">{{__('Packages')}}</a>
                                </li>
                            @endif
                            @if(Gate::check('manage pricing transation'))
                                <li class="{{in_array($routeName,['subscription.transaction'])?'active':''}} ">
                                    <a href="{{route('subscription.transaction')}}">{{__('Transactions')}}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Gate::check('manage coupon') || Gate::check('manage coupon history'))
                    <li class="menu-item {{in_array($routeName,['coupons.index','coupons.history'])?'active':''}}">
                        <a href="javascript:void(0);">
                            <div class="icon-item"><i data-feather="gift"></i></div>
                            <span>{{__('Coupons')}}</span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="submenu-list"
                            style="display: {{in_array($routeName,['coupons.index','coupons.history'])?'block':'none'}}">
                            @if(Gate::check('manage coupon'))
                                <li class="{{in_array($routeName,['coupons.index'])?'active':''}}">
                                    <a href="{{route('coupons.index')}}">{{__('All Coupon')}}</a>
                                </li>
                            @endif
                            @if(Gate::check('manage coupon history'))
                                <li class="{{in_array($routeName,['coupons.history'])?'active':''}}">
                                    <a href="{{route('coupons.history')}}">{{__('Coupon History')}}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Gate::check('manage account settings') || Gate::check('manage password settings') || Gate::check('manage general settings') || Gate::check('manage company settings') || Gate::check('manage seo settings') || Gate::check('manage google recaptcha settings'))
                    {{-- <li class="menu-item {{in_array($routeName,['setting.account','setting.password','setting.general','setting.company','setting.smtp','setting.payment','setting.site.seo','setting.google.recaptcha'])?'active':''}}">
                        <a href="javascript:void(0);">
                            <div class="icon-item"><i data-feather="settings"></i></div>
                            <span>{{__('Settings')}}</span><i class="fa fa-angle-down"></i></a>
                        <ul class="submenu-list "
                            style="display: {{in_array($routeName,['setting.account','setting.password','setting.general','setting.company','setting.smtp','setting.payment','setting.site.seo','setting.google.recaptcha'])?'block':'none'}}">
                            @if(Gate::check('manage account settings'))
                                <li class="{{in_array($routeName,['setting.account'])?'active':''}} ">
                                    <a href="{{route('setting.account')}}">{{__('Account Setting')}}</a>
                                </li>
                            @endif --}}
                            @if(Gate::check('manage password settings'))
                                <li class="{{in_array($routeName,['setting.password'])?'active':''}}">
                                    <a href="{{route('setting.password')}}">{{__('Password Setting')}}</a>
                                </li>
                            @endif
                            @if(Gate::check('manage general settings'))
                                <li class="{{in_array($routeName,['setting.general'])?'active':''}} ">
                                    <a href="{{route('setting.general')}}">{{__('General Setting')}}</a>
                                </li>
                            @endif
                            {{-- @if(Gate::check('manage company settings'))
                                <li class="{{in_array($routeName,['setting.company'])?'active':''}}">
                                    <a href="{{route('setting.company')}}">{{__('Company Setting')}}</a>
                                </li>
                            @endif --}}
                            @if(Gate::check('manage email settings'))
                                <li class="{{in_array($routeName,['setting.smtp'])?'active':''}} ">
                                    <a href="{{route('setting.smtp')}}">{{__('SMTP Setting')}}</a>
                                </li>
                            @endif
                            @if(Gate::check('manage payment settings'))
                                <li class="{{in_array($routeName,['setting.payment'])?'active':''}} ">
                                    <a href="{{route('setting.payment')}}">{{__('Payment Setting')}}</a>
                                </li>
                            @endif
                            @if(Gate::check('manage seo settings'))
                                <li class="{{in_array($routeName,['setting.site.seo'])?'active':''}} ">
                                    <a href="{{route('setting.site.seo')}}">{{__('Site SEO Setting')}}</a>
                                </li>
                            @endif
                            @if(Gate::check('manage google recaptcha settings'))
                                <li class="{{in_array($routeName,['setting.google.recaptcha'])?'active':''}} ">
                                    <a href="{{route('setting.google.recaptcha')}}">{{__('ReCaptcha Setting')}}</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

            @endif
            <li class="cdxmenu-title">
                <h5></h5>
            </li>
           

        </ul>
    </div>
</aside>
<!-- sidebar end-->
