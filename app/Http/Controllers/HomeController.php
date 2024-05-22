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

//        dd($status);
        return view('index', [
            'title' => "Home",
        ]);
    }


}
