@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #333; margin-bottom: 20px;">Manage Inventory</h1>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f5f5f5;">
                <th style="padding: 12px;">Product</th>
                <th style="padding: 12px;">Current Stock</th>
                <th style="padding: 12px;">Price</th>
                <th style="padding: 12px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px;">{{ $product->name }}</td>
                <td style="padding: 12px;">{{ $product->stock }}</td>
                <td style="padding: 12px;">₱{{ $product->price }}</td>
                <td style="padding: 12px;">
                    <form method="POST" action="{{ route('supplier-update-inventory', $product->id) }}" style="display: inline;">
                        @csrf
                        <input type="number" name="stock" value="{{ $product->stock }}" min="0">
                        <button type="submit" style="background: #d32f2f; color: white; border: none; padding: 6px 12px; border-radius: 4px;">Update</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

