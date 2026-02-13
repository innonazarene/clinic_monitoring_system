<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\MaritimeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaritimeDocumentController extends Controller
{
    public function store(Request $request, Student $student)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'description' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $path = $file->store('maritime-documents', 'public');

        $student->maritimeDocuments()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'description' => $request->description,
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function download(MaritimeDocument $document)
    {
        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    public function destroy(MaritimeDocument $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted.');
    }
}
