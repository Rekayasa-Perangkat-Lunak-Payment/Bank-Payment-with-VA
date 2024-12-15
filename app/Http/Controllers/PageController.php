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
        return view('pages.login');
    }

    public function dashboardPage()
    {
        $payment_period = PaymentPeriod::where('month', date('m'))->select('id', 'semester', 'year', 'month')->first();

        return view('pages.dashboard', compact('payment_period'));
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

    public function bulkCreateVirtualAccounts($id)
    {
        return view('pages.virtualAccountCreate', compact('id'));
    }

    public function itemTypePage($id){
        return view('pages.itemType', compact('id'));
    }
}
