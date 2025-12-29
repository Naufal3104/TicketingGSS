<?php

namespace App\Http\Controllers\TechnicalSupport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitTicket;
use App\Models\VisitDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Upload a document (BAST, Evidence, etc.)
     */
    public function upload(Request $request)
    {
        $request->validate([
            'visit_ticket_id' => 'required|exists:visit_tickets,visit_ticket_id',
            'document_type' => 'required|in:SURAT_TUGAS,SURAT_JALAN,BAST_SIGNED,EVIDENCE_PHOTO,OTHER',
            'file' => 'required|file|max:10240', // Max 10MB
            'description' => 'nullable|string'
        ]);

        $ticket = VisitTicket::where('visit_ticket_id', $request->visit_ticket_id)->firstOrFail();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::slug($request->document_type) . '.' . $file->getClientOriginalExtension();

            // Store in public/documents/{ticket_id}
            $path = $file->storeAs('public/documents/' . $ticket->visit_ticket_id, $filename);
            // URL accessible via storage link
            $url = Storage::url($path);

            $document = VisitDocument::create([
                'visit_ticket_id' => $ticket->visit_ticket_id,
                'uploader_id' => Auth::id(),
                'document_type' => $request->document_type,
                'file_url' => $url,
                'file_name' => $filename,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully.',
                'data' => $document
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded.'], 400);
    }

    /**
     * Download Surat Tugas (Mock Generation for MVP)
     */
    public function downloadSuratTugas($ticketId)
    {
        $ticket = VisitTicket::with(['customer', 'assignment.ts'])->where('visit_ticket_id', $ticketId)->firstOrFail();

        return view('operational.documents.surat-tugas', compact('ticket'));
    }
}
