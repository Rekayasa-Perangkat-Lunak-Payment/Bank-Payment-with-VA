<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\InstitutionAdminController;
use App\Models\Institution;
use App\Models\InstitutionAdmin;
use App\Models\Transaction;
use App\Models\VirtualAccount;
use App\Models\PaymentPeriod;
use App\Models\Invoice;

class PageController extends Controller
{
    public function showloginPage()
    {
        return view('pages.login'); // You can change this to the actual login page view name.
    }

    public function dashboardPage()
    {
        // dd(Auth::user());
        // if (Auth::user()->role == 'bank_admin') {
        //     return view('pages.dashboardBank');
        // }else if (Auth::user()->role == 'institution_admin') {
        //     return view('pages.dashboardInstitution');
        // }else{
        //     return view('pages.login');
        // }
        $active_va = VirtualAccount::where('is_active', 1)->where('expired_at', '>', date('Y-m-d'))->count();
        $payment_period = PaymentPeriod::where('month', date('m'))->select('id', 'semester', 'year', 'month')->first();
        $active_virtual_accounts = VirtualAccount::with(['student.institution'])
            ->where('is_active', true)
            ->where('expired_at', '>', date('Y-m-d'))->get();


        return view('pages.dashboardInstitution', compact('active_va', 'payment_period', 'virtual_account_students'));
    }

    public function settingsPage()
    {
        return view('pages.settings');
    }

    public function instituteListPage()
    {
        return view('pages.instituteList');
    }

    public function institutePage($id)
    {
        return view('pages.institute', compact('id'));
    }

    public function addInstitutePage()
    {
        return view('pages.addInstitute');
    }

    public function profilePage()
    {
        return view('pages.profile');
    }

    public function userInstituteListPage(Request $request)
    {
        $response = app(InstitutionAdminController::class)->index($request);
        $userInstitutions = json_decode($response->getContent(), true);
        // dd($userInstitutions);
        return view('pages.userInstituteList', compact('userInstitutions'));
    }

    public function userInstitutePage($id)
    {
        $userInstitute = InstitutionAdmin::findOrFail($id);
        return view('pages.userInstitute', compact('userInstitute'));
    }
    public function addUserInstitutePage()
    {
        return view('pages.addUserInstitute');
    }

    public function studentListPage()
    {
        $institutions = Institution::all();
        return view('pages.studentList', compact('institutions'));
    }

    public function addStudentPage()
    {
        $institutions = Institution::all();
        return view('pages.addStudent', compact('institutions'));
    }

    public function studentPage($id)
    {
        return view('pages.student', compact('id'));
    }

    public function paymentPeriodListPage()
    {
        return view('pages.paymentPeriodList');
    }

    public function paymentPeriodPage($id)
    {
        return view('pages.paymentPeriod', compact('id'));
    }

    public function virtualAccountPage($id)
    {
        return view('pages.virtualAccount', compact('id'));
    }

    public function virtualAccountListPage()
    {
        return view('pages.virtualAccountList');
    }
    public function invoicePage($id)
    {
        return view('pages.invoice', compact('id'));
    }

    public function invoiceListPage()
    {
        return view('pages.invoiceList');
    }

    public function transactionsPage()
    {
        $transactions = Transaction::all();
        return view('pages.transactions', compact('transactions'));
    }

    public function transactionPage($id)
    {
        return view('pages.transaction', compact('id'));
    }

    public function bulkCreateVirtualAccounts($paymentPeriodId, $institutionId)
    {
        return view('pages.virtualAccountCreate', ['paymentPeriodId' => $paymentPeriodId, 'institutionId' => $institutionId]);
    }
}
