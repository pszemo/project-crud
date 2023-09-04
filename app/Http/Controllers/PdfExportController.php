<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PdfExportController extends Controller
{
    public function exportToPDF(Request $request)
    {
        $projectName = $request->input('projectName');
        $projectStartFrom = $request->input('startDateFrom');
        $projectStartTo = $request->input('startDateTo');
        $projectEndFrom = $request->input('endDateFrom');
        $projectEndTo = $request->input('endDateTo');


        $projects = Project::query()
            ->when($projectName, function ($query) use ($projectName) {
                $query->where('projectName', 'like', "%$projectName%");
            })
            ->when($projectStartFrom, function ($query) use ($projectStartFrom) {
                $query->where('projectStart', '>=', $projectStartFrom);
            })
            ->when($projectStartTo, function ($query) use ($projectStartTo) {
                $query->where('projectStart', '<=', $projectStartTo);
            })
            ->when($projectEndFrom, function ($query) use ($projectEndFrom) {
                $query->where('projectEnd', '>=', $projectEndFrom);
            })
            ->when($projectEndTo, function ($query) use ($projectEndTo) {
                $query->where('projectEnd', '<=', $projectEndTo);
            })
            ->get();

        $data = [
            'title' => 'Lista projektów',
            'projects' => $projects,
        ];

        $mpdf = new Mpdf();

        $pdfContent = view('pdf.export', $data)->render();

        $mpdf->WriteHTML($pdfContent);

        return response($mpdf->Output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="export.pdf"',
        ]);
    }

}
