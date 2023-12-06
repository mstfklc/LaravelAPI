<?php
namespace App\Http\Controllers;
use App\Models\OrderHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderHistoryController extends Controller
{
    public function listOrderHistory(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->ajax()) {
            $orders = OrderHistory::with(['product:id,name,price']);
            return Datatables::of($orders)
                ->addIndexColumn()
                ->make(true);
        }
        return view('orderHistory');
    }
}
