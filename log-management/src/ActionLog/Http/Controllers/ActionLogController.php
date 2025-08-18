<?php

namespace Arpanihan\LogManagement\ActionLog\Http\Controllers;

use App\Http\Controllers\Controller;
use Arpanihan\LogManagement\ActionLog\Models\ActionLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ActionLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ActionLog::query();

            // Apply filters
            if ($request->filled('user_name')) {
                $query->where('user_name', 'like', '%' . $request->user_name . '%');
            }
            if ($request->filled('module')) {
                $query->where('module', 'like', '%' . $request->module . '%');
            }
            if ($request->filled('action')) {
                $query->where('action', 'like', '%' . $request->action . '%');
            }
            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', Carbon::parse($request->from_date)->format('Y-m-d'));
            }
            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', fn($log) => Carbon::parse($log->created_at)->format('M j, Y – g:i A'))
                ->editColumn('action', function ($log) {
                    $actionClass = match(strtolower($log->action)) {
                        'created', 'project created' => 'success',
                        'updated', 'project updated' => 'warning',
                        'deleted', 'project deleted' => 'danger',
                        'login', 'logged in' => 'success',
                        'logout' => 'secondary',
                        'login failed' => 'danger',
                        default => 'secondary'
                    };
                    return '<span class="badge bg-' . $actionClass . ' text-uppercase px-3 py-1">' . $log->action . '</span>';
                })
                ->editColumn('message', fn($log) => '<div class="text-wrap text-start" title="' . e($log->message) . '">' . \Str::limit($log->message, 100) . '</div>')
                ->editColumn('url', fn($log) => '<div class="text-wrap text-start"><a href="' . e($log->url) . '" target="_blank" class="text-decoration-none">' . \Str::limit($log->url, 60) . '</a></div>')
                ->rawColumns(['action', 'message', 'url'])
                ->make(true);
        }

        return view('actionlog::index');
    }
}
