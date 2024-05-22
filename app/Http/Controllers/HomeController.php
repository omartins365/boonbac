<?php

namespace App\Http\Controllers;

use App\Base\Core;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Type;
use App\Models\User;
use App\Models\State;
use App\Models\Setting;
use App\Models\WalletEntry;
use Illuminate\Http\Request;
use PlanStatus;
use SubscriptionStatus;
use WalletEntryStatus;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('index');
        $this->middleware('auth:customer')->only('dashboard');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $t_date = now()->format("F j, Y h:i:s a");
        $timearr = [
//            "Now ({$t_date})" => now()->subMinutes(10),
            "Last 24 hours" => now()->subDay(),
//            "In 3 days" => now()->subDays(3),
            "In 7 days" => now()->subWeek(),
            "Last 30 days" => now()->subMonth(),
//            "All Time" => now()->subCenturies(3)
        ];
        $status = [];
        foreach ($timearr as $timeen => $lasttm) {
            $status[$timeen]["users"] = Customer::where('created_at', ">=", $lasttm)->count();
            $status[$timeen]["transactions"] = Transaction::where('created_at', ">=", $lasttm)->count();
            $status[$timeen]["successful_transactions"] = Transaction::where('created_at', ">=", $lasttm)->whereStatus(\GenioForge\Payments\Utils\Enums\TransactionStatus::SUCCESS)->count();
//            $status[$timeen]["wallet_balance"] = WalletEntry::where('created_at', ">=", $lasttm)->whereStatus(WalletEntryStatus::Approved)->sum('amount');
            $status[$timeen]["funded_to_wallet"] = Core::with_naira(WalletEntry::where('created_at', ">=", $lasttm)->where('amount', '>', 0)->whereStatus(WalletEntryStatus::Approved)->sum('amount'));
            $status[$timeen]["spent_from_wallet"] = Core::with_naira(negativeOf(WalletEntry::where('created_at', ">=", $lasttm)->where('amount', '<', 0)->whereStatus(WalletEntryStatus::Approved)->sum('amount')));
            $status[$timeen]["subscriptions"] = ((Subscription::where('created_at', ">=", $lasttm)
                ->where(
                    fn($query) =>
                    $query->whereStatus(SubscriptionStatus::Active)
                        ->orWhere('status', SubscriptionStatus::Expired)
                )->count()
            ));
            $status[$timeen]["active_subscriptions"] = ((Subscription::where('created_at', ">=", $lasttm)
                ->whereStatus(SubscriptionStatus::Active)->count()
            ));

        }

        $stat = [];

        $stat["users"] = Customer::count();
        $stat["all_transactions"] = Transaction::count();
        $stat["total_successful_transactions"] = Transaction::whereStatus(\GenioForge\Payments\Utils\Enums\TransactionStatus::SUCCESS)->count();
        $stat["total_funded_to_wallet"] = Core::with_naira(WalletEntry::where('amount', '>', 0)->whereStatus(WalletEntryStatus::Approved)->sum('amount'));
        $stat["spent_from_wallet"] = Core::with_naira(negativeOf(WalletEntry::where('amount', '<', 0)->whereStatus(WalletEntryStatus::Approved)->sum('amount')));
        $stat["total_wallet_balance"] = Core::with_naira(WalletEntry::whereStatus(WalletEntryStatus::Approved)->sum('amount'));
        $stat["all_time_subscription_count"] = ((Subscription::where(
            fn($query) =>
            $query->whereStatus(SubscriptionStatus::Active)
                ->orWhere('status', SubscriptionStatus::Expired)
        )->count()));

//        dd($status);
        return view('dash.home', [
            'title' => "Dashboard",
            'status' => $status,
            'stat' => $stat,
        ]);
    }


    public function index_p()
    {
        return view('customer.index', [
            'title' => "Welcome to " . config('app.name'),
            'plans' => Plan::whereStatus(PlanStatus::Published)->get(),
        ]);
    }

    public function dashboard()
    {  // dd($accounts->items());
        $accounts = (new WalletAccountController)->accounts();
        if ((request()->hasAny(['paymentReference','tx_ref'])) && authCustomer()){
            $tx = authCustomer()->transactions()->latest()->first()->verify();
            Core::add_message('<span class="'.$tx->getStatusColorClass().'"></span>'. $tx->desc .' status : '. $tx->status->name, );
            return redirect(route('customer.dashboard.home'));
        }
        return view('customer.dashboard.index', [
            'title' => "Dashboard",
            'accounts' =>  $accounts,
            'plans' => Plan::whereStatus(PlanStatus::Published)->get(),
            'transactions' => authCustomer()->transactions()->limit(10)->latest()->get(),
        ]);
    }
    public function profile()
    {  // dd($accounts->items());
        return view('customer.dashboard.profile', [
            'title' => "Profile",
        ]);
    }
    public function faq()
    {  // dd($accounts->items());
        return view('customer.faq', [
            'title' => "FAQ",
        ]);
    }
    public function offline()
    {
        // $owner = User::whereRank(2)->first();
        // $brand = $owner->brand_name ?? "";
        // $phone = str($owner->phone);
        // $wa_phone = str($owner->wa_phone);
        return view('public.offline', [
            // 'agent' => $owner,
            // 'brand' => $brand,
            // 'phone' => $phone,
            // 'wa_phone' => $wa_phone,
            // 'was_msg' => $was_msg ?? "",
            'title' => "No Internet Connection",
        ]);
    }

    public function vendor()
    {
        return view('index', [
            'title' => "Welcome",
        ]);
    }

    public function domain_home(){
        return view('customer.domain_index', [
            'title' => "Welcome",
        ]);
    }
}
