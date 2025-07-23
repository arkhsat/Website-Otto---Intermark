<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\Custom;
use App\Models\NoticeBoard;
use App\Models\PackageTransaction;
use App\Models\Parking;
use App\Models\ParkingSlot;
use App\Models\ParkingZone;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            $start = strtotime(date('Y-m'));
            $end = strtotime(date('Y-12'));
            $currentDate = $start;
            $month = date('m', $currentDate);
    
            if (\Auth::user()->type == 'super admin') {
                $result['totalOrganization'] = User::where('type', 'owner')->count();
                $result['totalSubscription'] = Subscription::count();
                $result['totalTransaction'] = PackageTransaction::count();
                $result['totalIncome'] = PackageTransaction::sum('amount');
                $result['totalNote'] = NoticeBoard::where('parent_id', parentId())->count();
                $result['totalContact'] = Contact::where('parent_id', parentId())->count();
    
                $result['organizationByMonth'] = $this->organizationByMonth();
                $result['paymentByMonth'] = $this->paymentByMonth();
    
                return view('dashboard.super_admin', compact('result'));
            } else {
                // Date Range Setup
                $startDate = Carbon::today()->startOfDay()->toDateTimeString();
                $endDate = Carbon::today()->endOfDay()->toDateTimeString();
                $startMonth = Carbon::now()->startOfMonth()->startOfDay();
                $endMonth = Carbon::now()->endOfMonth()->endOfDay();
    
                // Transactions today (datetransact)
                $transactionsToday = DB::table('transactions')
                    ->whereBetween('datetransact', [$startDate, $endDate])
                    ->get();
    
                // Transactions out today (dateout)
                $transactionsOutToday = DB::table('transactions')
                    ->whereBetween('dateout', [$startDate, $endDate])
                    ->where('alreadyout', 'x')
                    ->get();
    
                // Transactions out this month
                $transactionsThisMonthOut = DB::table('transactions')
                    ->whereBetween('dateout', [$startMonth, $endMonth])
                    ->where('alreadyout', 'x')
                    ->get();
    
                // Mobil & Motor Count
                $result['totalmobil'] = $transactionsToday->where('vehicleid', 'Mobil')->count();
                $result['totalmotor'] = $transactionsToday->where('vehicleid', 'Motor')->count();
                $result['totaloutmobil'] = $transactionsOutToday->where('vehicleid', 'Mobil')->count();
                $result['totalout'] = $transactionsOutToday->where('vehicleid', 'Motor')->count();
    
                // Payment Method Count
                $result['mandiri'] = $transactionsOutToday->where('paymentby', 'Mandiri')->count();
                $result['bca'] = $transactionsOutToday->where('paymentby', 'BCA')->count();
                $result['bri'] = $transactionsOutToday->where('paymentby', 'BRI')->count();
                $result['bni'] = $transactionsOutToday->where('paymentby', 'BNI')->count();
    
                // Income
                $result['todayIncome'] = $transactionsOutToday->sum('cost');
                $result['monthlyincome'] = $transactionsThisMonthOut->sum('cost');
                $result['income'] = $this->getIncome();
                $result['monthlyIncome'] = Parking::where('parent_id', parentId())
                    ->whereMonth('entry_date', $month)
                    ->sum('amount');
    
                // Member Transactions
                $result['membermobilout'] = $transactionsThisMonthOut
                    ->where('statusparking', 'Member')
                    ->where('vehicleid', 'Mobil')
                    ->count();
    
                $result['membermotorin'] = $transactionsThisMonthOut
                    ->where('statusparking', 'Member')
                    ->where('vehicleid', 'Motor')
                    ->count();
    
                // Others
                $result['qty'] = $this->getQty();
                $result['availableSlot'] = ParkingSlot::where('parent_id', parentId())
                    ->where('is_available', 1)
                    ->count();
                $result['settings'] = settings();
    
                return view('dashboard.index', compact('result'));
            }
        } else {
            if (!file_exists(setup())) {
                header('location:install');
                die();
            } else {
                $landingPage = getSettingsValByName('landing_page');
                return $landingPage == 'on' ? view('layouts.landing') : redirect()->route('login');
            }
        }
    }
    

    public function getIncome()
    {
        $result = [
            'label' => [],
            'data' => [],
        ];
    
        // Mulai dari 13 hari yang lalu sampai hari ini (total 14 hari)
        $startDate = Carbon::now()->subDays(13);
    
        for ($i = 0; $i < 14; $i++) {
            $currentDay = $startDate->copy()->addDays($i);
            $startOfDay = $currentDay->startOfDay()->toDateTimeString();
            $endOfDay = $currentDay->endOfDay()->toDateTimeString();
    
            $sumIncome = Transaction::whereBetween('dateout', [$startOfDay, $endOfDay])->sum('cost');
    
            $result['label'][] = $currentDay->format('d-M');
            $result['data'][] = $sumIncome;
        }
    
        return $result;
    }

    public function getQty()
    {
        $result = [
            'label' => [],
            'data' => [],
        ];
    
        // Ambil 14 hari ke belakang, termasuk hari ini
        $startDate = Carbon::now()->subDays(13);
    
        for ($i = 0; $i < 14; $i++) {
            $currentDay = $startDate->copy()->addDays($i);
            $startOfDay = $currentDay->startOfDay()->toDateTimeString();
            $endOfDay = $currentDay->endOfDay()->toDateTimeString();
    
            $count = Transaction::whereBetween('dateout', [$startOfDay, $endOfDay])
                ->count('transactionid');
    
            $result['label'][] = $currentDay->format('d-M');
            $result['data'][] = $count;
        }
    
        return $result;
    }
    


    public function organizationByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));
        $currentDate = $start;
        $organization = [];
        while ($currentDate <= $end) {
            $organization['label'][] = date('M-Y', $currentDate);
            $month = date('m', $currentDate);
            $year = date('Y', $currentDate);
            $organization['data'][] = User::where('type', 'owner')->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
            $currentDate = strtotime('+1 month', $currentDate);
        }
        return $organization;
    }

    public function paymentByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));
        $currentDate = $start;
        $payment = [];
        while ($currentDate <= $end) {
            $payment['label'][] = date('M-Y', $currentDate);
            $month = date('m', $currentDate);
            $year = date('Y', $currentDate);
            $payment['data'][] = PackageTransaction::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('amount');
            $currentDate = strtotime('+1 month', $currentDate);
        }
        return $payment;
    }

}
