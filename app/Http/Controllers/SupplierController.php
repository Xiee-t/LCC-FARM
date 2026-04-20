<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function dashboard()
    {
        return view('supplier.dashboard');
    }

    public function inventory()
    {
        return view('supplier.inventory');
    }

    public function updateInventory(Request $request, $id)
    {
        // Logic to update stock levels
        return back()->with('success', 'Inventory updated.');
    }

    public function orders()
    {
        return view('supplier.orders');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        // Logic to change order status (e.g., 'Shipped')
        return back()->with('success', 'Status updated.');
    }
}