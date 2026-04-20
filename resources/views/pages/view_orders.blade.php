@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">
    <div style="width: 100%; max-width: 800px; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px;">
        <h2 style="font-size: 2rem; color: #d32f2f; margin-bottom: 20px;">View Orders</h2>
        <p>Here are your recent orders (demo data):</p>

        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="border-bottom: 2px solid #d32f2f;">
                    <th style="text-align: left; padding: 10px; color: #d32f2f;">Date</th>
                    <th style="text-align: left; padding: 10px; color: #d32f2f;">Size</th>
                    <th style="text-align: left; padding: 10px; color: #d32f2f;">Qty (trays)</th>
                    <th style="text-align: left; padding: 10px; color: #d32f2f;">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px;">2026-03-25</td>
                    <td style="padding: 10px;">Medium</td>
                    <td style="padding: 10px;">20</td>
                    <td style="padding: 10px;">Processing</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px;">2026-03-24</td>
                    <td style="padding: 10px;">Large</td>
                    <td style="padding: 10px;">10</td>
                    <td style="padding: 10px;">Delivered</td>
                </tr>
            </tbody>
        </table>

        <p style="margin-top: 20px;">You can use this page later for order history APIs.</p>
    </div>
</div>
@endsection