<?php
namespace App\Http\Controllers;
use App\Models\{Book, Category, MonthlyBudget};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller {
    public function budget() {
        $budgets = MonthlyBudget::orderByDesc('year')->orderByDesc('month')->get();
        $year = request('year', date('Y'));
        $monthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $spent  = Book::whereYear('purchase_date',$year)->whereMonth('purchase_date',$m)->sum('purchase_price');
            $budget = MonthlyBudget::where('year',$year)->where('month',$m)->first();
            $monthlyData[] = ['month'=>$m,'month_name'=>date('F',mktime(0,0,0,$m,1)),'spent'=>$spent,'budget'=>$budget?->budget_amount??0];
        }
        return view('reports.budget', compact('monthlyData','year','budgets'));
    }
    public function setBudget(Request $request) {
        $request->validate(['year'=>'required|integer','month'=>'required|integer|min:1|max:12','budget_amount'=>'required|numeric|min:0']);
        MonthlyBudget::updateOrCreate(['year'=>$request->year,'month'=>$request->month],['budget_amount'=>$request->budget_amount,'notes'=>$request->notes]);
        return back()->with('success','Budget set!');
    }
    public function exportBudgetPdf() {
        $year = request('year', date('Y'));
        $monthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $spent  = Book::whereYear('purchase_date',$year)->whereMonth('purchase_date',$m)->sum('purchase_price');
            $budget = MonthlyBudget::where('year',$year)->where('month',$m)->first();
            $monthlyData[] = ['month'=>$m,'month_name'=>date('F',mktime(0,0,0,$m,1)),'spent'=>$spent,'budget'=>$budget?->budget_amount??0];
        }
        $pdf = Pdf::loadView('reports.budget_pdf', compact('monthlyData','year'));
        return $pdf->download("budget_report_{$year}.pdf");
    }
}
