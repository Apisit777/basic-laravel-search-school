<?php

namespace App\Http\Controllers\ImportExcel;

use App\Http\Controllers\Controller;
use App\Imports\DiaryReadImport;
use App\Imports\DiaryReadImportLimited;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;

class ImportController extends Controller
{
    /**
     * แปลง .xls → .xlsx (PhpSpreadsheet มี bug encoding กับ .xls บางไฟล์)
     */
    private function convertXlsToXlsx($file): string
    {
        $spreadsheet = IOFactory::load($file->getRealPath());
        $tmpPath = tempnam(sys_get_temp_dir(), 'xls_') . '.xlsx';
        $writer = new XlsxWriter($spreadsheet);
        $writer->save($tmpPath);
        $spreadsheet->disconnectWorksheets();
        return $tmpPath;
    }

    /**
     * Import file — ถ้าเป็น .xls แปลงเป็น .xlsx ก่อน
     */
    private function importFile($file): DiaryReadImport
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $import = new DiaryReadImportLimited;

        if ($ext === 'xls') {
            $tmpPath = $this->convertXlsToXlsx($file);
            Excel::import($import, $tmpPath);
            @unlink($tmpPath);
        } else {
            Excel::import($import, $file);
        }

        return $import;
    }

    /**
     * เชื่อมต่อ database 10.20.10.35 -> table trn_diary1
     */

    public function index()
    {
        // dd($managePrices);

        return view('importexcel.index');
    }

    public function getDiary(Request $request)
    {
        $limit = (int) $request->input('length', 20);
        $start = (int) $request->input('start', 0);

        // $query = DB::connection('mysql_diary')
        $query = DB::connection('mysql_external')
            ->table('trn_diary1')
            ->join('trn_diary2', 'trn_diary1.doc_no', '=', 'trn_diary2.doc_no')
            ->select(
                'trn_diary1.company_id',
                'trn_diary1.doc_no',
                'trn_diary1.doc_date',
                'trn_diary1.doc_time',
                'trn_diary1.doc_tp',
                'trn_diary1.corporation_id',
                'trn_diary1.branch_id',
                'trn_diary1.member_id',
                'trn_diary2.product_id'
            );

        if ($request->filled('doc_no')) {
            $query->where('trn_diary1.doc_no', $request->input('doc_no'));
        }

        if ($request->filled('date_month')) {
            $query->whereRaw("DATE_FORMAT(trn_diary1.doc_date, '%Y-%m') = ?", [$request->input('date_month')]);
        } elseif ($request->filled('doc_date_from') && $request->filled('doc_date_to')) {
            $query->whereBetween('trn_diary1.doc_date', [
                $request->input('doc_date_from'),
                $request->input('doc_date_to'),
            ]);
        } elseif ($request->filled('doc_date')) {
            $query->where('trn_diary1.doc_date', $request->input('doc_date'));
        }

        if ($request->filled('corporation_id')) {
            $query->where('trn_diary1.corporation_id', $request->input('corporation_id'));
        }

        if ($request->filled('branch_id')) {
            $query->where('trn_diary1.branch_id', $request->input('branch_id'));
        }

        if ($request->filled('member_id')) {
            $query->where('trn_diary1.member_id', $request->input('member_id'));
        }

        if ($request->filled('doc_tp')) {
            $query->where('trn_diary1.doc_tp', $request->input('doc_tp'));
        }

        if ($request->filled('product_id')) {
            $query->where('trn_diary2.product_id', $request->input('product_id'));
        }

        $totalRecords = $query->count();

        $query->orderBy('trn_diary1.doc_date', 'desc')
              ->orderBy('trn_diary1.doc_time', 'desc');

        if ($limit > 0) {
            $query->skip($start)->take($limit);
        }

        $records = $query->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecords,
            'data' => $records,
        ]);
    }

    /**
     * ดึงข้อมูลจาก external DB (laravel_product_master_external)
     * trn_diary1 + trn_diary2 → แสดงหน้าบ้าน
     */
    public function getDiaryExternal(Request $request)
    {
        $limit = (int) $request->input('length', 20);
        $start = (int) $request->input('start', 0);

        $query = DB::connection('mysql_external')
            ->table('trn_diary1')
            ->join('trn_diary2', 'trn_diary1.doc_no', '=', 'trn_diary2.doc_no')
            ->select(
                'trn_diary1.company_id',
                'trn_diary1.doc_no',
                'trn_diary1.doc_date',
                'trn_diary1.doc_tp',
                'trn_diary1.branch_id',
                'trn_diary2.product_id'
            );

        if ($request->filled('doc_no')) {
            $query->where('trn_diary1.doc_no', 'like', '%' . $request->input('doc_no') . '%');
        }

        if ($request->filled('date_month')) {
            $query->whereRaw("DATE_FORMAT(trn_diary1.doc_date, '%Y-%m') = ?", [$request->input('date_month')]);
        }

        $totalRecords = $query->count();

        $query->orderBy('trn_diary1.doc_date', 'desc');

        if ($limit > 0) {
            $query->skip($start)->take($limit);
        }

        $records = $query->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecords,
            'data' => $records,
        ]);
    }

    /**
     * Preview เปรียบเทียบ 2 ไฟล์ก่อน Import
     * แสดง summary: TI รวม, TO แยกตาม branch
     */
    public function previewCompare(Request $request)
    {
        ini_set('memory_limit', '2G');
        set_time_limit(300);

        $request->validate([
            'file1' => 'required|mimes:xlsx,xls,csv',
            'file2' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            $importTO = $this->importFile($request->file('file1'));
            $importTI = $this->importFile($request->file('file2'));

            if ($importTO->totalQty === 0 && $importTI->totalQty === 0) {
                return response()->json(['status' => false, 'message' => 'ไฟล์ไม่มีข้อมูล'], 400);
            }

            $matched = ($importTO->totalQty === $importTI->totalQty);

            return response()->json([
                'status'  => true,
                'matched' => $matched,
                'ti'      => $importTI->totalQty,
                'to'      => $importTO->totalQty,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'อ่านไฟล์ไม่สำเร็จ: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Import ทั้ง TO + TI พร้อมกัน
     * เปรียบเทียบ 2 ไฟล์: sum(quantity) และ sum(amount) ต้องตรงกัน
     * TO → trn_diary1, TI → trn_diary2
     * Group by branch_id (1 branch = 1 doc_no)
     */
    public function importBoth(Request $request)
    {
        ini_set('memory_limit', '1G');

        $request->validate([
            'file1' => 'required|mimes:xlsx,xls,csv',
            'file2' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            $conn = DB::connection('mysql_external');

            // อ่านไฟล์ด้วย chunk reading (ประหยัด memory)
            $importTO = new DiaryReadImport;
            Excel::import($importTO, $request->file('file1'));

            $importTI = new DiaryReadImport;
            Excel::import($importTI, $request->file('file2'));

            // ========== เปรียบเทียบ 2 ไฟล์ ==========
            if ($importTO->totalQty !== $importTI->totalQty) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Quantity ไม่ตรงกัน! TO = ' . $importTO->totalQty . ', TI = ' . $importTI->totalQty,
                ], 400);
            }

            if (round($importTO->totalAmount, 2) !== round($importTI->totalAmount, 2)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Amount ไม่ตรงกัน! TO = ' . number_format($importTO->totalAmount, 2) . ', TI = ' . number_format($importTI->totalAmount, 2),
                ], 400);
            }

            $companyId = 'CPS';
            $companyPrefix = str_replace('S', '', $companyId); // CP
            $month = now()->format('m');

            // ========== Import TO → trn_diary1 ==========
            foreach ($importTO->branches as $branchId => $data) {
                $toDocNo = $this->generateDocNo($conn, $companyPrefix, $branchId, 'TO', $month);

                $conn->table('trn_diary1')->insert([
                    'doc_no'         => $toDocNo,
                    'company_id'     => $companyId,
                    'corporation_id' => $companyId,
                    'branch_id'      => $branchId,
                    'doc_date'       => now()->format('Y-m-d'),
                    'doc_time'       => now()->format('H:i:s'),
                    'doc_tp'         => 'TO',
                    'quantity'       => $data['quantity'],
                    'amount'         => $data['amount'],
                ]);
            }

            // สร้าง TI summary ใน trn_diary1
            $firstBranch = array_key_first($importTO->branches) ?? '';
            $tiSummaryDocNo = $this->generateDocNo($conn, $companyPrefix, $firstBranch, 'TI', $month);

            $conn->table('trn_diary1')->insert([
                'doc_no'         => $tiSummaryDocNo,
                'company_id'     => $companyId,
                'corporation_id' => $companyId,
                'branch_id'      => $firstBranch,
                'doc_date'       => now()->format('Y-m-d'),
                'doc_time'       => now()->format('H:i:s'),
                'doc_tp'         => 'TI',
                'quantity'       => $importTO->totalQty,
                'amount'         => $importTO->totalAmount,
            ]);

            // ========== Import TI → trn_diary2 ==========
            foreach ($importTI->branches as $branchId => $data) {
                $tiDocNo = $this->generateDocNo($conn, $companyPrefix, $branchId, 'TI', $month);

                $conn->table('trn_diary2')->insert([
                    'doc_no'         => $tiDocNo,
                    'company_id'     => $companyId,
                    'corporation_id' => $companyId,
                    'branch_id'      => $branchId,
                    'doc_date'       => now()->format('Y-m-d'),
                    'doc_time'       => now()->format('H:i:s'),
                    'doc_tp'         => 'TI',
                    'quantity'       => $data['quantity'],
                    'amount'         => $data['amount'],
                ]);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Import สำเร็จ! TO ' . count($importTO->branches) . ' สาขา, TI ' . count($importTI->branches) . ' สาขา (Qty: ' . $importTO->totalQty . ', Amount: ' . number_format($importTO->totalAmount, 2) . ')',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Import ไม่สำเร็จ: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ดึงสถานะ Transfer จาก status_transfer
     * TI → IDC panel, TO → KM panel
     * คำนวณ % จาก quantity / total_quantity
     */
    public function getTransferStatus(Request $request)
    {
        $query = DB::connection('mysql_external')->table('status_transfer');

        if ($request->filled('date_month')) {
            // date_month = "2026-03" → filter by reg_date month
            $query->whereRaw("DATE_FORMAT(reg_date, '%Y-%m') = ?", [$request->input('date_month')]);
        }

        $rows = $query->get();

        if ($rows->isEmpty()) {
            return response()->json(['status' => false]);
        }

        // Group by status_location (IDC / KM)
        $idcRows = $rows->where('status_location', 'IDC');
        $kmRows  = $rows->where('status_location', 'KM');

        $idcTotal = $idcRows->sum('total_quantity');
        $idcDone  = $idcRows->sum('quantity');
        $idcPct   = $idcTotal > 0 ? min(100, round(($idcDone / $idcTotal) * 100)) : 0;

        $kmTotal = $kmRows->sum('total_quantity');
        $kmDone  = $kmRows->sum('quantity');
        $kmPct   = $kmTotal > 0 ? min(100, round(($kmDone / $kmTotal) * 100)) : 0;

        return response()->json([
            'status'   => true,
            'idc_pct'  => $idcPct,
            'km_pct'   => $kmPct,
            'idc_rows' => (int) $idcDone,
            'km_rows'  => (int) $kmDone,
        ]);
    }

    /**
     * สร้าง doc_no จาก com_doc_no
     * Format: CP6980TO-02-00000001
     * CP = company_id ตัด S, 6980 = branch_id, TO/TI = doc_tp, 02 = เดือน, 8 หลัก = running
     */
    private function generateDocNo($conn, $companyPrefix, $branchId, $docTp, $month)
    {
        // ดู doc_no ปัจจุบันจาก com_doc_no
        $record = $conn->table('com_doc_no')
            ->where('doc_tp', $docTp)
            ->first();

        if ($record && $record->doc_no) {
            // ตัดเลข running 8 หลักสุดท้ายออกมา
            $currentNo = (int) substr($record->doc_no, -8);
            $newNo = $currentNo + 1;
        } else {
            $newNo = 1;
        }

        // Build: CP6980TO-02-00000001
        $docNo = $companyPrefix . $branchId . $docTp . '-' . $month . '-' . str_pad($newNo, 8, '0', STR_PAD_LEFT);

        // อัพเดท com_doc_no
        if ($record) {
            $conn->table('com_doc_no')
                ->where('doc_tp', $docTp)
                ->update(['doc_no' => $docNo]);
        } else {
            $conn->table('com_doc_no')->insert([
                'doc_tp' => $docTp,
                'doc_no' => $docNo,
            ]);
        }

        return $docNo;
    }
}
