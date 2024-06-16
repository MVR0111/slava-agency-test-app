<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessExcelFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UploadController extends Controller
{
    public function index(Request $request): View
    {
        return view('upload-excel', ['request' => $request]);
    }

    public function upload(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx'
        ]);

        if ($validator->fails()) {
            flash()->error($validator->errors()->first());
            return redirect()->back()->withInput();
        }

        $file = $request->file('file');
        $filePath = $file->store('uploads');

        ProcessExcelFile::dispatch($filePath);

        flash()->success('File successfully upload!');
        return redirect()->back();
    }
}
