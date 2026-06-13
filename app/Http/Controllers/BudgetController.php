<?php

namespace App\Http\Controllers;

use App\Models\MonthlyBudget;
use App\Models\Book;
use Illuminate\Http\Request;

class BudgetController extends Controller {

    public function index(Request $request) {
        $year = $request->year ?? now()->year;

        $budgets = MonthlyBudget::where('year', $year)->get()->keyBy('month');

        $spending = Book::selectRaw('MONTH(purchase_date) as month, SUM(purchase_price) as total, COUNT(*) as count')
            ->whereYear('purchase_date', $year)
            ->whereNotNull('purchase_date')
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $budget  = $budgets[$m]->budget_amount ?? 0;
            $spent   = $spending[$m]->total ?? 0;
            $count   = $spending[$m]->count ?? 0;
            $months[$m] = [
                'month'      => $m,
                'month_name' => date('F', mktime(0, 0, 0, $m, 1)),
                'budget'     => $budget,
                'spent'      => $spent,
                'count'      => $count,
                'remaining'  => $budget - $spent,
                'percent'    => $budget > 0 ? min(100, round(($spent / $budget) * 100)) : 0,
            ];
        }

        $years     = range(now()->year - 3, now()->year + 1);
        $totalBudget = array_sum(array_column($months, 'budget'));
        $totalSpent  = array_sum(array_column($months, 'spent'));

        return view('budget.index', compact('months', 'year', 'years', 'totalBudget', 'totalSpent'));
    }

    public function upsert(Request $request) {
        $data = $request->validate([
            'year'          => 'required|integer',
            'month'         => 'required|integer|min:1|max:12',
            'budget_amount' => 'required|numeric|min:0',
            'notes'         => 'nullable|string',
        ]);

        MonthlyBudget::updateOrCreate(
            ['year' => $data['year'], 'month' => $data['month']],
            ['budget_amount' => $data['budget_amount'], 'notes' => $data['notes'] ?? null]
        );

        return redirect()->route('budget.index', ['year' => $data['year']])->with('success', 'Budget updated!');
    }
}
