<?php

namespace App\Http\Controllers\AccountPanel;


use App\Exports\ParserExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountPanel\ParserRequest;
use App\Models\ParserLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ParserController extends Controller
{
    public function __construct() {
        set_time_limit(0);
    }

    public function loadParser(): View
    {
        $title = 'Parser';
        $activeNav = 'Parser';
        return view('AccountPanel.parser', compact('title', 'activeNav'));
    }

    public function parse(ParserRequest $request): JsonResponse
    {
        try {
            $date = explode('_', explode('.', $request->file('file')->getClientOriginalName())[0])[1];
            Storage::putFileAs(
                'public/temp', $request->file('file'), 'raw' . '.' . $request->file('file')->getClientOriginalExtension()
            );
            array_map('unlink', glob(storage_path() . '/app/public/download/*'));
            array_map('unlink', glob(public_path() . '/storage/download/*'));
            $fileName = 'excel_' . time() . '_' . implode('_', explode(' ', $date)) . '.xlsx';
            Excel::store(new ParserExport($date), 'download/' . $fileName, 'public');
            ParserLog::create(['user_id' => auth()->user()->id, 'file_name' => $fileName, 'status' => 'Completed']);
            return response()->json(['message' => 'File Parsed Successfully', 'payload' => $fileName], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
