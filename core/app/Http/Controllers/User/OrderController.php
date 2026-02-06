<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $pageTitle = 'Orders';
        $orders = Order::where('user_id', auth()->id())->with('contact');

        if (request()->search) {
            $search = request()->search;
            $orders->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhereHas('contact', function ($contact) use ($search) {
                        $contact->where('firstname', 'like', "%$search%")
                            ->orWhere('lastname', 'like', "%$search%")
                            ->orWhere('mobile', 'like', "%$search%");
                    });
            });
        }

        if (request()->status) {
            $orders->where('status', request()->status);
        }

        $orders = $orders->latest()->paginate(getPaginate());
        return view('Template::user.orders.index', compact('pageTitle', 'orders'));
    }

    public function details($id)
    {
        $pageTitle = 'Order Details';
        $order = Order::where('user_id', auth()->id())->with('contact')->findOrFail($id);
        return view('Template::user.orders.details', compact('pageTitle', 'order'));
    }

    public function statusUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,paid,shipped,completed',
        ]);

        $order = Order::where('user_id', auth()->id())->where('id', $request->id)->firstOrFail();
        $order->status = $request->status;
        $order->save();

        $notify[] = ['success', 'Order status updated successfully'];
        return back()->withNotify($notify);
    }
}
