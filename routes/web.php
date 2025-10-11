<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ParkingZoneController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\ParkingRateController;
use App\Http\Controllers\ParkingSlotController;
use App\Http\Controllers\RfidVehicleController;
use App\Http\Controllers\RfidExtendVehicleController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GateTypeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\MemberProductController;
use App\Http\Controllers\ReportSummaryController;
use App\Http\Controllers\ReportONController;
use App\Http\Controllers\ReportDailyController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ReportMemberDailyController;
use App\Http\Controllers\ReportMemberNonPaymentController;
use App\Http\Controllers\ReportHotelController;
use App\Http\Controllers\TandaTerimaController;
use App\Http\Controllers\ReportPajakController;
use App\Http\Controllers\ReportVoucher;
use App\Http\Controllers\ReportVoucherTrueBlueController;
use Illuminate\Routing\Router;
use Maatwebsite\Excel\Row;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class,'index'])->middleware(
    [

        'XSS',
    ]
);
Route::get('home', [HomeController::class,'index'])->name('home')->middleware(
    [

        'XSS',
    ]
);
Route::get('dashboard', [HomeController::class,'index'])->name('dashboard')->middleware(
    [

        'XSS',
    ]
);

//-------------------------------User-------------------------------------------

Route::resource('users', UserController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


//-------------------------------Subscription-------------------------------------------



Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

    Route::resource('subscriptions', SubscriptionController::class);
    Route::get('coupons/history', [CouponController::class,'history'])->name('coupons.history');
    Route::delete('coupons/history/{id}/destroy', [CouponController::class,'historyDestroy'])->name('coupons.history.destroy');
    Route::get('coupons/apply', [CouponController::class, 'apply'])->name('coupons.apply');
    Route::resource('coupons', CouponController::class);
    Route::get('subscription/transaction', [SubscriptionController::class,'transaction'])->name('subscription.transaction');
}
);

//-------------------------------Subscription Payment-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

    Route::post('subscription/{id}/stripe/payment', [SubscriptionController::class,'stripePayment'])->name('subscription.stripe.payment');
}
);
//-------------------------------Settings-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',

        ],
    ], function (){
    Route::get('settings/account', [SettingController::class,'account'])->name('setting.account');
    Route::post('settings/account', [SettingController::class,'accountData'])->name('setting.accountsave');
    Route::delete('settings/account/delete', [SettingController::class,'accountDelete'])->name('setting.account.delete');

    Route::get('settings/password', [SettingController::class,'password'])->name('setting.password');
    Route::post('settings/password', [SettingController::class,'passwordData'])->name('setting.passwordsave');

    Route::get('settings/general', [SettingController::class,'general'])->name('setting.general');
    Route::post('settings/general', [SettingController::class,'generalData'])->name('setting.generalsave');

    Route::get('settings/smtp', [SettingController::class,'smtp'])->name('setting.smtp');
    Route::post('settings/smtp', [SettingController::class,'smtpData'])->name('setting.smtpsave');

    Route::get('settings/payment', [SettingController::class,'payment'])->name('setting.payment');
    Route::post('settings/payment', [SettingController::class,'paymentData'])->name('setting.paymentsave');

    // Route::get('settings/company', [SettingController::class,'company'])->name('setting.company');
    // Route::post('settings/company', [SettingController::class,'companyData'])->name('setting.companysave');

    Route::get('language/{lang}', [SettingController::class,'lanquageChange'])->name('language.change');
    Route::post('theme/settings', [SettingController::class,'themeSettings'])->name('theme.settings');

    Route::get('settings/site-seo', [SettingController::class,'siteSEO'])->name('setting.site.seo');
    Route::post('settings/site-seo', [SettingController::class,'siteSEOData'])->name('setting.site.seosave');

    Route::get('settings/google-recaptcha', [SettingController::class,'googleRecaptcha'])->name('setting.google.recaptcha');
    Route::post('settings/google-recaptcha', [SettingController::class,'googleRecaptchaData'])->name('setting.google.recaptchasave');
}
);


//-------------------------------Role & Permissions-------------------------------------------
Route::resource('user_permission', PermissionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('role', RoleController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);




//-------------------------------Note-------------------------------------------
Route::resource('note', NoticeBoardController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Contact-------------------------------------------
Route::resource('contact', ContactController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);


//-------------------------------Support-------------------------------------------

Route::post('support/reply/{id}', [SupportController::class,'reply'])->name('support.reply')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('support', SupportController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------logged History-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {

    Route::get('logged/history', [UserController::class,'loggedHistory'])->name('logged.history');
    Route::get('logged/{id}/history/show', [UserController::class,'loggedHistoryShow'])->name('logged.history.show');
    Route::delete('logged/{id}/history', [UserController::class,'loggedHistoryDestroy'])->name('logged.history.destroy');
});

//-------------------------------Parking Zone-------------------------------------------
Route::resource('parking-zone', ParkingZoneController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Vehicle Type-------------------------------------------
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {

    Route::resource('vehicle-type', VehicleTypeController::class);
    Route::get('zone/{id}/type', [VehicleTypeController::class,'getvehicleType'])->name('zone.type');
});



//-------------------------------Floor-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {

    Route::resource('floor', FloorController::class);
    Route::get('zone/{id}/floor', [FloorController::class,'getFloor'])->name('zone.floor');
});

//-------------------------------Gate Type-------------------------------------------

Route::resource('gate-type', GateTypeController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Parking Rate-------------------------------------------

Route::resource('parking-rate', ParkingRateController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//-------------------------------Parking Slot-------------------------------------------


Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {

    Route::resource('parking-slot', ParkingSlotController::class);
    Route::get('zone/{zid}/floor/{fid}/type/{tid}', [ParkingSlotController::class,'getSlot'])->name('zone.floor.slot');
    Route::get('vehicle_id/{vehicleid}', [MemberProductController::class,'getVehicleProduct'])->name('vehicleid');
    Route::get('membertype/{membertype}', [MemberProductController::class,'getMemberProduct'])->name('membertype');
});

//-------------------------------Gate-------------------------------------------

Route::resource('gate', GateController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);
//-------------------------------RFID Vehicle-------------------------------------------

Route::resource('rfid-vehicle', RfidVehicleController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Route::resource('rfid-extend', RfidExtendVehicleController::class)->middleware(
//     [
//         'auth',
//         'XSS',
//     ]
// );

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {
        Route::get('rfid-extend', [RfidExtendVehicleController::class, 'index'])->name('rfid-extend.index');
        Route::get('rfid-extend/{id}/extend', [RfidExtendVehicleController::class, 'extend'])->name('rfid-extend.extend');
        Route::put('rfid-extend/{id}/update', [RfidExtendVehicleController::class, 'update'])->name('rfid-extend.update');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {

    Route::resource('rfid-vehicle', RfidVehicleController::class);
    
    // Route::get('rfid-vehicle/edit')
    // Route::get('rfid-vehicle/extend/{eid}', [RfidVehicleController::class,'extend'])->name('rfid-vehicle.extend');
   
});

//-------------------------------Parking-------------------------------------------


Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {

    Route::resource('parking', ParkingController::class);
    Route::patch('parking/{transactionid}/close', [ParkingController::class,'close'])->name('parking.close');
    Route::get('parking/zone/{zid}/floor/{fid}/type/{tid}', [ParkingController::class,'getSlot'])->name('parking.zone.floor.slot');
    Route::get('parking/{id}/exit/{amount}', [ParkingController::class,'exitVehicle'])->name('parking.exit.vehicle');
    Route::post('parking/{id}/exit', [ParkingController::class,'exitVehicleData'])->name('exit.vehicle.store');
    Route::get('parked/vehicle', [ParkingController::class,'parkedVehicle'])->name('parked.vehicle');
    Route::get('parked/member/motor', [ParkingController::class,'memberMotor'])->name('parked.member.motor');
    Route::get('parked/member/mobil', [ParkingController::class,'memberMobil'])->name('parked.member.mobil');
    Route::get('parking/{id}/thermal/print', [ParkingController::class,'thermalPrint'])->name('parking.thermal.print');
});

//-------------------------------Plan Payment-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

    Route::post('subscription/{id}/bank-transfer', [PaymentController::class, 'subscriptionBankTransfer'])->name('subscription.bank.transfer');
    Route::get('subscription/{id}/bank-transfer/action/{status}', [PaymentController::class, 'subscriptionBankTransferAction'])->name('subscription.bank.transfer.action');
    Route::post('subscription/{id}/paypal', [PaymentController::class, 'subscriptionPaypal'])->name('subscription.paypal');
    Route::get('subscription/{id}/paypal/{status}', [PaymentController::class, 'subscriptionPaypalStatus'])->name('subscription.paypal.status');
}
);

//-------------------------------Report-------------------------------------------

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

    // Route::resource('reportsummary', ReportSummaryController::class, 'getamountreport')->name('report.summary');
    Route::get('/report-amount-summary', [ReportSummaryController::class, 'getAmountReport'])->name('report.summary.amount');
    Route::get('/report-amount-summary/pdf', [ReportSummaryController::class, 'downloadpdfAmount'])->name('report.summary.amount.pdf');
    Route::get('/report-amount-summary/excel', [ReportSummaryController::class, 'downloadexcelAmount'])->name('report.summary.amount.excel');
    Route::get('/report-qty-summary', [ReportSummaryController::class, 'getQtyReport'])->name('report.summary.qty');
    Route::get('/report-qty-summary/pdf', [ReportSummaryController::class, 'downloadpdfQty'])->name('report.summary.qty.pdf'); 
    Route::get('/report-qty-summary/excel', [ReportSummaryController::class, 'downloadexcelQty'])->name('report.summary.qty.excel');
}
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

        Route::get('/report-member-summary-daily', [ReportMemberDailyController::class, 'getmemberReport'])->name('reportmember.daily');
        Route::get('/report-member-summary-daily/pdf', [ReportMemberDailyController::class, 'downloadpdfMember'])->name('reportmember.daily.pdf');
        Route::get('/report-member-summary-daily/excel', [ReportMemberDailyController::class, 'downloadexcelMember'])->name('reportmember.daily.excel');
}
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

        Route::get('/report-member-nonpayment', [ReportMemberNonPaymentController::class, 'getmemberReport'])->name('reportmember.nonpayment');
        Route::get('/report-member-nonpayment/pdf', [ReportMemberNonPaymentController::class, 'downloadpdfMember'])->name('reportmember.nonpayment.pdf');
        Route::get('/report-member-nonpayment/excel', [ReportMemberNonPaymentController::class, 'downloadexcelMember'])->name('reportmember.nonpayment.excel');
}
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){
   
    Route::resource('company', CompanyController::class);
    // Route::get('/company/create', [CompanyController::class, 'create'])->name('company.create');
    // Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    // Route::post('/company/store', [CompanyController::class, 'store'])->name('company.store');
}
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

    
    Route::get('/reportdaily-summary', [ReportDailyController::class, 'getPaymentReport'])->name('reportdaily.index');
    Route::get('/reportdaily-summary/pdf', [ReportDailyController::class, 'downloadPdfDaily'])->name('reportdaily.index.pdf');
    Route::get('/reportdaily-summary/excel', [ReportDailyController::class, 'downloadExcelDaily'])->name('reportdaily.index.excel');
     
}
);


Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

    Route::get('report-tanda-terima', [TandaTerimaController::class, 'index'])->name('tanda.terima.member');
    Route::get('tanda-terima', [TandaTerimaController::class, 'show'])->name('tanda.terima.view');

}
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

    Route::get('report-hotel', [ReportHotelController::class, 'index'])->name('report.hotel');

    Route::get('report-hotel-trx', [ReportHotelController::class, 'dataTrxHotel'])->name('report.hotel.trx');

    Route::get('report-hotel/pdfSBSR', [ReportHotelController::class, 'downloadPDF'])->name('report.hotel.SBSR.pdf');
    Route::get('report-hotel/excelSBSR', [ReportHotelController::class, 'downloadExcel'])->name('report.hotel.SBSR.excel');

    Route::get('report-hotel/pdfSCSR', [ReportHotelController::class, 'downloadPDF'])->name('report.hotel.SCSR.pdf');
    Route::get('report-hotel/excelSCSR', [ReportHotelController::class, 'downloadExcel'])->name('report.hotel.SCSR.excel');
}
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){

    Route::get('report-on', [ReportONController::class, 'index'])->name('report.on');
    Route::get('report-on/pdf', [ReportONController::class, 'downloadPdf'])->name('report.on.pdf');
    Route::get('report-on/excel', [ReportONController::class, 'downloadExcel'])->name('report.on.excel');
}
);

// Route::group(
//     [
//         'middleware' => [
//             'auth',
//             'XSS',
//         ],
//     ], function (){

//     Route::get('reportsummary/', [ReportSummaryController::class, 'index'])->name('report.index');
//     Route::get('report/reportsummary', [ReportSummaryController::class, 'reportsummary'])->name('report.reportsummary');
     
// }
// );
Route::resource('reporttransaction', TransactionController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);



Route::resource('hotel', HotelController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('rfidextend', RfidVehicleController::class)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {
        Route::get('report-pajak', [ReportPajakController::class, 'index'])->name('report.pajak');
        Route::get('report-pajak-data', [ReportPajakController::class, 'data'])->name('report.pajak.data');
        Route::get('report-pajak-print', [ReportPajakController::class, 'generate'])->name('report.pajak.print');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {
        Route::get('report-voucher', [ReportVoucher::class, 'index'])->name('report.voucher.gelael');
        Route::get('report-voucher-pdf', [ReportVoucher::class, 'downloadPDF'])->name('report.voucher.gelael.pdf');
        Route::get('report-voucher-excel', [ReportVoucher::class, 'downloadExcel'])->name('report.voucher.gelael.excel');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {
        Route::get('report-voucher', [ReportVoucherTrueBlueController::class, 'index'])->name('report.voucher.trueblue');
        Route::get('report-voucher-trueblue-pdf', [ReportVoucherTrueBlueController::class, 'downloadPDF'])->name('report.voucher.trueblue.pdf');
        Route::get('report-voucher-trueblue-excel', [ReportVoucherTrueBlueController::class, 'downloadExcel'])->name('report.voucher.trueblue.excel');
    }
);


