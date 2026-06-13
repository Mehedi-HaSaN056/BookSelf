<?php
namespace App\Http\Controllers;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VendorsExport;
use App\Imports\VendorsImport;

class VendorController extends Controller {
    public function index() {
        $vendors = Vendor::withCount('books')->withSum('books','purchase_price')->orderBy('name')->get();
        return view('vendors.index', compact('vendors'));
    }
    public function store(Request $request) {
        $request->validate(['name'=>'required|string|max:255','email'=>'nullable|email','phone'=>'nullable|string|max:20','address'=>'nullable|string','website'=>'nullable|url','notes'=>'nullable|string']);
        Vendor::create($request->only('name','email','phone','address','website','notes'));
        return back()->with('success','Vendor added!');
    }
    public function update(Request $request, Vendor $vendor) {
        $request->validate(['name'=>'required|string|max:255','email'=>'nullable|email','phone'=>'nullable|string|max:20','address'=>'nullable|string','website'=>'nullable|url','notes'=>'nullable|string']);
        $vendor->update($request->only('name','email','phone','address','website','notes'));
        return back()->with('success','Vendor updated!');
    }
    public function destroy(Vendor $vendor) {
        $vendor->delete();
        return back()->with('success','Vendor deleted!');
    }
    public function exportExcel() {
        return Excel::download(new VendorsExport, 'vendors_'.date('Y-m-d').'.xlsx');
    }
    public function importExcel(Request $request) {
        $request->validate(['file'=>'required|mimes:xlsx,xls,csv|max:5120']);
        Excel::import(new VendorsImport, $request->file('file'));
        return back()->with('success','Vendors imported!');
    }
}
