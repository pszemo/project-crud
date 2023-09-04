<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class XlsExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function exportToXLS(Request $request)
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['ID', 'Nazwa', 'Początek', 'Koniec', 'Opis']; // Replace with your column names
        $sheet->fromArray([$headers], null, 'A1');

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
            ->get(['id','projectName','projectStart','projectEnd','projectDescription']);

        $dataRows = $projects->toArray();
        $sheet->fromArray($dataRows, null, 'A2');
        $filePath = public_path('exports/exported_data.xlsx');
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
        return response()->download($filePath, 'exported_data.xlsx');

    }

}
