<?php

namespace App\Http\Controllers\Operational;

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
        $ticket = VisitTicket::findOrFail($ticketId);

        // In a real app, uses DomPDF to generate PDF.
        // For MVP, we return a simple view or text.

        $data = [
            'ticket' => $ticket,
            'user' => Auth::user(), // Requestor
        ];

        // Assuming we have a view 'documents.surat_tugas'
        // return view('documents.surat_tugas', $data);

        return response()->json([
            'message' => 'Surat Tugas generation not implemented in MVP yet.',
            'ticket' => $ticket->visit_ticket_id
        ]);
    }
}
