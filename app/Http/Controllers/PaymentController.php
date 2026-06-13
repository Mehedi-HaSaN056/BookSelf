<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Payment, Book};
use Raziul\Sslcommerz\Facades\Sslcommerz;

class PaymentController extends Controller
{
    public function index() {
        $payments = Payment::where('user_id', Auth::id())->latest()->paginate(15);
        $total    = Payment::where('user_id', Auth::id())->where('status','success')->sum('amount');
        return view('payments.index', compact('payments','total'));
    }

    public function create(Request $request) {
        $method = $request->get('method', 'bkash');
        $books  = Book::all();
        return view('payments.create', compact('method', 'books'));
    }

    public function store(Request $request) {
        // simulator code এখানে থাকবে
    }

    public function sslPay(Request $request) {
        $request->validate([
            'amount'      => 'required|numeric|min:10',
            'vendor_name' => 'required|string|max:255',
            'vendor_phone'=> 'required|string|max:20',
            'book_id'     => 'nullable|exists:books,id',
        ]);

        $transactionId = strtoupper(uniqid('TXN'));
        $user = Auth::user();

        Payment::create([
            'user_id'        => $user->id,
            'book_id'        => $request->book_id ?: null,
            'method'         => 'sslcommerz',
            'amount'         => $request->amount,
            'transaction_id' => $transactionId,
            'phone'          => $request->vendor_phone,
            'status'         => 'pending',
            'vendor_name'    => $request->vendor_name,
            'vendor_phone'   => $request->vendor_phone,
            'notes'          => $request->notes,
        ]);

        $response = Sslcommerz::setOrder($request->amount, $transactionId, 'Book Purchase')
            ->setCustomer($user->name, $user->email, $request->vendor_phone)
            ->setShippingInfo(1, 'Dhaka')
            ->makePayment();

        if ($response->success()) {
            return redirect($response->gatewayPageURL());
        }

        Payment::where('transaction_id', $transactionId)->delete();
        return back()->with('error', '❌ SSLCommerz connection failed!');
    }

    public function sslSuccess(Request $request) {
    $payment = Payment::where('transaction_id', $request->tran_id)->first();
    
    if (!$payment) {
        return redirect('/dashboard')->with('error', '❌ পেমেন্ট রেকর্ড পাওয়া যায়নি।');
    }

    $payment->update(['status' => 'success']);
    
    return redirect()->route('payments.index')
        ->with('success', '✅ পেমেন্ট সফল! TXN: ' . $payment->transaction_id);
}

    public function sslFail(Request $request) {
        Payment::where('transaction_id', $request->tran_id)
            ->update(['status' => 'failed']);
        return redirect()->route('payments.index')
            ->with('error', '❌ পেমেন্ট ব্যর্থ হয়েছে।');
    }

    public function sslCancel(Request $request) {
        Payment::where('transaction_id', $request->tran_id)
            ->update(['status' => 'failed']);
        return redirect()->route('payments.index')
            ->with('error', '⚠️ পেমেন্ট বাতিল করা হয়েছে।');
    }

    public function sslIpn(Request $request) {
        Payment::where('transaction_id', $request->tran_id)
            ->update(['status' => 'success']);
        return response()->json(['status' => 'ok']);
    }
}