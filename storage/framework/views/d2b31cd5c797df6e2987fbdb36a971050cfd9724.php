<?php
    $admin_logo=getSettingsValByName('company_logo');
    $ids     = parentId();
    $authUser=\App\Models\User::find($ids);
 $subscription = \App\Models\Subscription::find($authUser->subscription);
 $routeName=\Request::route()->getName();
?>
<aside class="codex-sidebar sidebar-<?php echo e($settings['sidebar_mode']); ?>">
    <div class="logo-gridwrap">
        <a class="codexbrand-logo" href="<?php echo e(route('home')); ?>">
            <img class="img-fluid"
                 src="<?php echo e(asset('images\Logo Utama.png')); ?>"
                 alt="Otto Parking">
        </a>
        <a class="codex-darklogo" href="<?php echo e(route('home')); ?>">
            <img class="img-fluid"
                 src="<?php echo e(asset('images\Logo Utama.png')); ?>"
                 alt="Otto Parking"></a>
        <div class="sidebar-action"><i data-feather="menu"></i></div>
    </div>
    <div class="icon-logo">
        <a href="<?php echo e(route('home')); ?>">
            <img class="img-fluid"
                 src="<?php echo e(asset('images\Logo Utama.png')); ?>"
                 alt="Otto Parking">
        </a>
    </div>
    <div class="codex-menuwrapper">
        <ul class="codex-menu custom-scroll" data-simplebar>
            <li class="cdxmenu-title">
                <h5><?php echo e(__('Home')); ?></h5>
            </li>
            <li class="menu-item <?php echo e(in_array($routeName,['dashboard',''])?'active':''); ?>">
                <a href="<?php echo e(route('dashboard')); ?>">
                    <div class="icon-item"><i data-feather="home"></i></div>
                    <span><?php echo e(__('Dashboard')); ?></span>
                </a>
            </li>
            <?php if(\Auth::user()->type=='super admin'): ?>
                <?php if(Gate::check('manage user')): ?>
                <li class="menu-item <?php echo e(in_array($routeName,['users.index','logged.history','role.index','role.create','role.edit'])?'active':''); ?>">
                    <a href="javascript:void(0);">
                        <div class="icon-item"><i data-feather="users"></i></div>
                        <span><?php echo e(__('Staff Management')); ?></span><i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="submenu-list"
                        style="display: <?php echo e(in_array($routeName,['users.index','logged.history','role.index','role.create','role.edit'])?'block':'none'); ?>">
                        <?php if(Gate::check('manage role')): ?>
                            <li class="menu-item <?php echo e(in_array($routeName,['role.index','role.create','role.edit'])?'active':''); ?>">
                                <a href="<?php echo e(route('role.index')); ?>"><?php echo e(__('Roles')); ?>  </a>
                            </li>
                        <?php endif; ?>
                        <?php if(Gate::check('manage user')): ?>
                            <li class="<?php echo e(in_array($routeName,['users.index'])?'active':''); ?>">
                                <a href="<?php echo e(route('users.index')); ?>"><?php echo e(__('Users')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(Gate::check('manage logged history') ): ?>
                            <li class="<?php echo e(in_array($routeName,['logged.history'])?'active':''); ?>">
                                <a href="<?php echo e(route('logged.history')); ?>"><?php echo e(__('Logged History')); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
            <?php else: ?>
                <?php if(Gate::check('manage user') || Gate::check('manage role') || Gate::check('manage logged history') ): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['users.index','logged.history','role.index','role.create','role.edit'])?'active':''); ?>">
                        <a href="javascript:void(0);">
                            <div class="icon-item"><i data-feather="users"></i></div>
                            <span><?php echo e(__('Staff Management')); ?></span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="submenu-list"
                            style="display: <?php echo e(in_array($routeName,['users.index','logged.history','role.index','role.create','role.edit'])?'block':'none'); ?>">
                            <?php if(Gate::check('manage role')): ?>
                                <li class="menu-item <?php echo e(in_array($routeName,['role.index','role.create','role.edit'])?'active':''); ?>">
                                    <a href="<?php echo e(route('role.index')); ?>"><?php echo e(__('Roles')); ?>  </a>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage user')): ?>
                                <li class="<?php echo e(in_array($routeName,['users.index'])?'active':''); ?>">
                                    <a href="<?php echo e(route('users.index')); ?>"><?php echo e(__('Users')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage logged history') ): ?>
                                <li class="<?php echo e(in_array($routeName,['logged.history'])?'active':''); ?>">
                                    <a href="<?php echo e(route('logged.history')); ?>"><?php echo e(__('Logged History')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        
            <?php if( Gate::check('manage hotel') ): ?>
                <li class="cdxmenu-title">
                    <h5><?php echo e(__('Hotel Management')); ?></h5>
                </li>
                <?php if(Gate::check('manage hotel')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['hotel.index'])?'active':''); ?>">
                        <a href="<?php echo e(route('hotel.index')); ?>">
                            <div class="icon-item"><i data-feather="file-text"></i></div>
                            <span><?php echo e(__('Compliment List')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                
              

            <?php endif; ?>
            <li class="cdxmenu-title">
                    <h5><?php echo e(__('Hotel Management')); ?></h5>
                </li>
                <?php if(!Gate::check('manage hotel')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['hotel.index'])?'active':''); ?>">
                        <a href="<?php echo e(route('hotel.index')); ?>">
                            <div class="icon-item"><i data-feather="file-text"></i></div>
                            <span><?php echo e(__('Compliment List')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

            <?php if( Gate::check('manage parking rate') ||  Gate::check('manage parking slot') ||  Gate::check('manage rfid vehicle') ||  Gate::check('manage parking') || Gate::check('manage contact') || Gate::check('manage support') || Gate::check('manage note') ): ?>
                <li class="cdxmenu-title">
                    <h5><?php echo e(__('Parking Capacity')); ?></h5>
                </li>

                <?php if(Gate::check('manage parking')): ?>
                <li class="menu-item <?php echo e(in_array($routeName,['parking.index','parking.show'])?'active':''); ?>">
                    <a href="<?php echo e(route('parking.index')); ?>">
                        <div class="icon-item"><i data-feather="trello"></i></div>
                        <span><?php echo e(__('Parked Vehicle')); ?></span>
                    </a>
                </li>
                <?php endif; ?>

            <?php endif; ?>


            <?php if( Gate::check('manage parking rate') ||  Gate::check('manage parking slot') ||  Gate::check('manage rfid vehicle') ||  Gate::check('manage parking') || Gate::check('manage contact') || Gate::check('manage support') || Gate::check('manage note') ): ?>
                <li class="cdxmenu-title">
                    <h5><?php echo e(__('Business Management')); ?></h5>
                </li>
                <?php if(Gate::check('manage parking rate')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['parking-rate.index'])?'active':''); ?>">
                        <a href="<?php echo e(route('parking-rate.index')); ?>">
                            <div class="icon-item"><i data-feather="file-text"></i></div>
                            <span><?php echo e(__('Parking Rate')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(Gate::check('manage parking slot')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['parking-slot.index'])?'active':''); ?>">
                        <a href="<?php echo e(route('parking-slot.index')); ?>">
                            <div class="icon-item"><i data-feather="map"></i></div>
                            <span><?php echo e(__('Parking Slot')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if(Gate::check('manage rfid vehicle')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['company.index'])?'active':''); ?>">
                        <a href="<?php echo e(route('company.index')); ?>">
                            <div class="icon-item"><i data-feather="truck"></i></div>
                            <span><?php echo e(__('Company')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if(Gate::check('manage rfid vehicle')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['rfid-vehicle.index'])?'active':''); ?>">
                        <a href="<?php echo e(route('rfid-vehicle.index')); ?>">
                            <div class="icon-item"><i data-feather="truck"></i></div>
                            <span><?php echo e(__('RFID Vehicle')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(Gate::check('manage rfid vehicle')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['rfid-extend.index'])?'active':''); ?>">
                        <a href="<?php echo e(route('rfid-extend.index')); ?>">
                            <div class="icon-item"><i data-feather="truck"></i></div>
                            <span><?php echo e(__('RFID Extend')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                
                

            <?php endif; ?>
            <?php if(\Auth::user()->type=='super admin' || \Auth::user()->type=='owner'): ?>
            <li class="cdxmenu-title">
                <h5><?php echo e(__('Report Transactions')); ?></h5>
            </li>

            

            <li class="menu-item <?php echo e(in_array($routeName,['report.hotel',''])?'active':''); ?>">
                <a href="<?php echo e(route('report.hotel')); ?>">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span><?php echo e(__('Report Transaksi Hotel')); ?></span>
                </a>
            </li>
            
            <li class="menu-item <?php echo e(in_array($routeName,['report.summary.qty',''])?'active':''); ?>">
                <a href="<?php echo e(route('report.summary.qty')); ?>">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span><?php echo e(__('Report Summary Qty')); ?></span>
                </a>
            </li>

            <li class="menu-item <?php echo e(in_array($routeName,['report.summary.amount',''])?'active':''); ?>">
                <a href="<?php echo e(route('report.summary.amount')); ?>">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span><?php echo e(__('Report Summary Amount')); ?></span>
                </a>
            </li>
            <li class="menu-item <?php echo e(in_array($routeName,['reportdaily.index',''])?'active':''); ?>">
                <a href="<?php echo e(route('reportdaily.index')); ?>">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span><?php echo e(__('Report Harian')); ?></span>
                </a>
            </li>

            <li class="menu-item <?php echo e(in_array($routeName,['report.on',''])?'active':''); ?>">
                <a href="<?php echo e(route('report.on')); ?>">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span><?php echo e(__('Report Close ON')); ?></span>
                </a>
            </li>

            <li class="menu-item <?php echo e(in_array($routeName,['report.pajak',''])?'active':''); ?>">
                <a href="<?php echo e(route('report.pajak')); ?>">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span><?php echo e(__('Report Pajak')); ?></span>
                </a>
            </li>
            
            
            <li class="cdxmenu-title">
                <h5><?php echo e(__('Report Member')); ?></h5>
            </li>
            <li class="menu-item <?php echo e(in_array($routeName,['reportmember.nonpayment',''])?'active':''); ?>">
                <a href="<?php echo e(route('reportmember.nonpayment')); ?>">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span><?php echo e(__('Riwayat Edit Data Member')); ?></span>
                </a>
            </li>

            <li class="menu-item <?php echo e(in_array($routeName,['reportmember.daily',''])?'active':''); ?>">
                <a href="<?php echo e(route('reportmember.daily')); ?>">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span><?php echo e(__('Report Perpanjangan Member')); ?></span>
                </a>
            </li>

            <?php endif; ?>

            <?php if(\Auth::user()->type=='super admin' || \Auth::user()->type=='owner'): ?>
            <li class="cdxmenu-title">
                <h5><?php echo e(__('Tanda Terima Member')); ?></h5>
            </li>

            

            <li class="menu-item <?php echo e(in_array($routeName,['tanda.terima.member',''])?'active':''); ?>">
                <a href="<?php echo e(route('tanda.terima.member')); ?>">
                    <div class="icon-item"><i data-feather="book"></i></div>
                    <span><?php echo e(__('Tanda Terima')); ?></span>
                </a>
            </li>
            

            <?php endif; ?>

            <?php if( Gate::check('manage parking zone') || Gate::check('manage gatetype') || Gate::check('manage vehicle_type') || Gate::check('manage floor')): ?>
                <li class="cdxmenu-title">
                    <h5><?php echo e(__('System Setup')); ?></h5>
                </li>
                <?php if(Gate::check('manage parking zone')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['parking-zone.index'])?'active':''); ?>">
                        <a href="<?php echo e(route('parking-zone.index')); ?>">
                            <div class="icon-item"><i data-feather="hard-drive"></i></div>
                            <span><?php echo e(__('Parking Zone')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(Gate::check('manage parking zone')): ?>
                <li class="menu-item <?php echo e(in_array($routeName,['gate-type.index'])?'active':''); ?>">
                    <a href="<?php echo e(route('gate-type.index')); ?>">
                        <div class="icon-item"><i data-feather="sliders"></i></div>
                        <span><?php echo e(__('Gate Type')); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(Gate::check('manage vehicle type')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['vehicle-type.index'])?'active':''); ?>">
                        <a href="<?php echo e(route('vehicle-type.index')); ?>">
                            <div class="icon-item"><i data-feather="sliders"></i></div>
                            <span><?php echo e(__('Vehicle Type')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(Gate::check('manage floor')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['floor.index'])?'active':''); ?>">
                        <a href="<?php echo e(route('floor.index')); ?>">
                            <div class="icon-item"><i data-feather="layers"></i></div>
                            <span><?php echo e(__('Parking Floor')); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(Gate::check('manage pricing packages') || Gate::check('manage pricing transation') || Gate::check('manage account settings') || Gate::check('manage password settings') || Gate::check('manage general settings') || Gate::check('manage company settings')): ?>
                <li class="cdxmenu-title">
                    <h5><?php echo e(__('System Settings')); ?></h5>
                </li>
                <?php if(Gate::check('manage pricing packages') || Gate::check('manage pricing transation')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['subscriptions.index','subscriptions.show','subscription.transaction'])?'active':''); ?>">
                        <a href="javascript:void(0);">
                            <div class="icon-item"><i data-feather="database"></i></div>
                            <span><?php echo e(__('Pricing')); ?></span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="submenu-list"
                            style="display: <?php echo e(in_array($routeName,['subscriptions.index','subscriptions.show','subscription.transaction'])?'block':'none'); ?>">
                            <?php if(Gate::check('manage pricing packages')): ?>
                                <li class="<?php echo e(in_array($routeName,['subscriptions.index','subscriptions.show'])?'active':''); ?>">
                                    <a href="<?php echo e(route('subscriptions.index')); ?>"><?php echo e(__('Packages')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage pricing transation')): ?>
                                <li class="<?php echo e(in_array($routeName,['subscription.transaction'])?'active':''); ?> ">
                                    <a href="<?php echo e(route('subscription.transaction')); ?>"><?php echo e(__('Transactions')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(Gate::check('manage coupon') || Gate::check('manage coupon history')): ?>
                    <li class="menu-item <?php echo e(in_array($routeName,['coupons.index','coupons.history'])?'active':''); ?>">
                        <a href="javascript:void(0);">
                            <div class="icon-item"><i data-feather="gift"></i></div>
                            <span><?php echo e(__('Coupons')); ?></span><i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="submenu-list"
                            style="display: <?php echo e(in_array($routeName,['coupons.index','coupons.history'])?'block':'none'); ?>">
                            <?php if(Gate::check('manage coupon')): ?>
                                <li class="<?php echo e(in_array($routeName,['coupons.index'])?'active':''); ?>">
                                    <a href="<?php echo e(route('coupons.index')); ?>"><?php echo e(__('All Coupon')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage coupon history')): ?>
                                <li class="<?php echo e(in_array($routeName,['coupons.history'])?'active':''); ?>">
                                    <a href="<?php echo e(route('coupons.history')); ?>"><?php echo e(__('Coupon History')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if(Gate::check('manage account settings') || Gate::check('manage password settings') || Gate::check('manage general settings') || Gate::check('manage company settings') || Gate::check('manage seo settings') || Gate::check('manage google recaptcha settings')): ?>
                    
                            <?php if(Gate::check('manage password settings')): ?>
                                <li class="<?php echo e(in_array($routeName,['setting.password'])?'active':''); ?>">
                                    <a href="<?php echo e(route('setting.password')); ?>"><?php echo e(__('Password Setting')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage general settings')): ?>
                                <li class="<?php echo e(in_array($routeName,['setting.general'])?'active':''); ?> ">
                                    <a href="<?php echo e(route('setting.general')); ?>"><?php echo e(__('General Setting')); ?></a>
                                </li>
                            <?php endif; ?>
                            
                            <?php if(Gate::check('manage email settings')): ?>
                                <li class="<?php echo e(in_array($routeName,['setting.smtp'])?'active':''); ?> ">
                                    <a href="<?php echo e(route('setting.smtp')); ?>"><?php echo e(__('SMTP Setting')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage payment settings')): ?>
                                <li class="<?php echo e(in_array($routeName,['setting.payment'])?'active':''); ?> ">
                                    <a href="<?php echo e(route('setting.payment')); ?>"><?php echo e(__('Payment Setting')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage seo settings')): ?>
                                <li class="<?php echo e(in_array($routeName,['setting.site.seo'])?'active':''); ?> ">
                                    <a href="<?php echo e(route('setting.site.seo')); ?>"><?php echo e(__('Site SEO Setting')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if(Gate::check('manage google recaptcha settings')): ?>
                                <li class="<?php echo e(in_array($routeName,['setting.google.recaptcha'])?'active':''); ?> ">
                                    <a href="<?php echo e(route('setting.google.recaptcha')); ?>"><?php echo e(__('ReCaptcha Setting')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

            <?php endif; ?>
            <li class="cdxmenu-title">
                <h5></h5>
            </li>
           

        </ul>
    </div>
</aside>
<!-- sidebar end-->
<?php /**PATH E:\Kerja\02. Intermark\Website Otto\resources\views/admin/menu.blade.php ENDPATH**/ ?>