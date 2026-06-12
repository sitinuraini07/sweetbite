<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'day'); // day, month, year
        $date = $request->get('date', date('Y-m-d'));
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $query = Transaction::whereIn('status', ['delivered', 'completed']);

        if ($filter == 'day') {
            $query->whereDate('created_at', $date);
        } elseif ($filter == 'month') {
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        } elseif ($filter == 'year') {
            $query->whereYear('created_at', $year);
        }

        $transactions = $query->latest()->get();
        $totalRevenue = $transactions->sum('total_price');

        return view('admin.revenue.index', compact('transactions', 'totalRevenue', 'filter', 'date', 'month', 'year'));
    }

    public function downloadPdf(Request $request)
    {
        $filter = $request->get('filter', 'day');
        $date = $request->get('date', date('Y-m-d'));
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $query = Transaction::whereIn('status', ['delivered', 'completed']);

        if ($filter == 'day') {
            $query->whereDate('created_at', $date);
            $label = "Tanggal " . Carbon::parse($date)->format('d M Y');
        } elseif ($filter == 'month') {
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
            $label = "Bulan " . Carbon::create()->month($month)->format('F') . " " . $year;
        } elseif ($filter == 'year') {
            $query->whereYear('created_at', $year);
            $label = "Tahun " . $year;
        }

        $transactions = $query->latest()->get();
        $totalRevenue = $transactions->sum('total_price');

        $pdf = PDF::loadView('admin.revenue.pdf', compact('transactions', 'totalRevenue', 'filter', 'label'));
        return $pdf->download('Laporan_Pendapatan_' . $filter . '_' . date('Ymd') . '.pdf');
    }

    public function downloadExcel(Request $request)
    {
        $filter = $request->get('filter', 'day');
        $date = $request->get('date', date('Y-m-d'));
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $query = Transaction::whereIn('status', ['delivered', 'completed']);

        if ($filter == 'day') {
            $query->whereDate('created_at', $date);
            $label = "Tanggal " . Carbon::parse($date)->format('d M Y');
        } elseif ($filter == 'month') {
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
            $label = "Bulan " . Carbon::create()->month($month)->format('F') . " " . $year;
        } elseif ($filter == 'year') {
            $query->whereYear('created_at', $year);
            $label = "Tahun " . $year;
        }

        $transactions = $query->latest()->get();
        $totalRevenue = $transactions->sum('total_price');

        $filename = 'Laporan_Pendapatan_' . $filter . '_' . date('Ymd') . '.xls';

        $html = view('admin.revenue.excel', compact('transactions', 'totalRevenue', 'filter', 'label'))->render();

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'max-age=0');
    }
}
