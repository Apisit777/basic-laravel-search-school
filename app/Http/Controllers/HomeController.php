<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Food;
use App\Models\TrnDonaTotambon;
use App\Models\User;
use App\Models\user_permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search_school = TrnDonaTotambon::select(
            'id', 'doc_datetime', 'doc_no', 'event', 'doc_refer', 'flag', 'cancel_date', 'cancel_user', 'member_id', 'do_befor', 'do_reedem',
            'do_balance', 'donation_use', 'tb_id', 'school_id', 'remark', 'type_member', 'reg_user', 'reg_time', 'upd_user', 'upd_time', 'time_up'
        )
        ->get();

        // dd($search_school);
        return view('searchSchool', compact('search_school'));
    }

    public function role(Request $request)
    {
        return view('auth.role');
    }
    public function roleByPass(Request $request)
    {

        return response()->json(['status' => 'success', 'route' => '/product_master/pd_master']);

        // dd($request);
        // $dataForm = $request['dataRole'];
        // $decodedDataForm = json_decode($dataForm, true);

        // dd([
        //     'request1' => $request['username'],
        //     'request2' => $request['name_position'],
        //     'decodedDataForm' => $decodedDataForm
        // ]);
        // // dd($decodedDataForm);
        // if (is_array($decodedDataForm) && isset($decodedDataForm['data']['roles'])) {
        //     $roles = $decodedDataForm['data']['roles'];
        //     dd($roles);
        // } else {
        //     dd('Error: Could not decode JSON or roles key is missing');
        // }
    
        // if (in_array($roles, $request['name_position'])) {

        // }

        // if (!empty($userRole)) {
        //     $defaultRole = $userRole;

        //     // dd($userRole);
        //     Auth::login($user, true);
        //     return response()->json(['status' => 'success', 'default_role' => $defaultRole, 'route' => '/product_master/pd_master']);
        // } else {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'No roles assigned to the user'
        //     ], 400);
        // }
    }
    
    public function search_school(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $doc_no = $request->input('doc_no');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        $field_detail = ['trn_dona_totambons.doc_no', 'trn_dona_totambons.member_id'];

        $data = TrnDonaTotambon::select(
            'id', 'doc_datetime', 'doc_no', 'event', 'doc_refer', 'flag', 'cancel_date', 'cancel_user', 'member_id', 'do_befor', 'do_reedem',
            'do_balance', 'donation_use', 'tb_id', 'school_id', 'remark', 'type_member', 'reg_user', 'reg_time', 'upd_user', 'upd_time', 'time_up'
        )
        ->orderBy('id', 'ASC');


        if (null != $doc_no) {
            $data = $data->where(function ($data) use ($doc_no, $field_detail) {
                for ($i = 0; $i < count($field_detail); $i++) {
                    $data->orWhere($field_detail[$i], 'like', '%'.$doc_no.'%');
                }
            });
        }

        if (null != $date_start && null != $date_end) {
            $data = $data->whereBetween('trn_dona_totambons.doc_datetime', ["$date_start", "$date_end"]);
        } elseif (null != $date_start) {
            $data = $data->where('trn_dona_totambons.doc_datetime', '=', "$date_start");
        }

        // dd($data);
        $data = $data->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Home $home)
    {
        //
    }

    public function home()
    {

//         SELECT *
// FROM pro_develops_all
// WHERE ((BRAND_ORIGINAL != 'CPS' 
//         AND PRODUCT != ''
//         AND BARCODE != '')
//        OR (BRAND_ORIGINAL = 'CPS'
//            AND PRODUCT NOT IN (
//                SELECT PRODUCT
//                FROM pro_develops_all
//                WHERE BRAND_ORIGINAL = 'LL'
//            )
//            AND PRODUCT != ''
//            AND BARCODE != ''))
//   AND BRAND_ORIGINAL = 'OP'
//   AND PRODUCT NOT REGEXP '^2' ORDER BY `BRAND_ORIGINAL` DESC





        // Tranfer to product1_clean
        // SELECT * 
        // FROM `product1s_all`
        // WHERE 
        //     (`BRAND_ORIGINAL` = 'OP' AND 
        //         ((`PRODUCT` REGEXP '^2' AND LENGTH(`PRODUCT`) = 5)
        //             OR (`PRODUCT` REGEXP '^1' AND LENGTH(`PRODUCT`) = 7)
        //         )
        //     ) 
        //     OR 
        //     (`BRAND_ORIGINAL` = 'CPS' AND 
        //         ((`PRODUCT` REGEXP '^3' AND LENGTH(`PRODUCT`) = 5) 
        //             OR (`PRODUCT` REGEXP '^7' AND LENGTH(`PRODUCT`) = 5)
        //             OR (`PRODUCT` REGEXP '^1' AND LENGTH(`PRODUCT`) = 7)
        //         )
        //     )
        //     OR 
        //     (`BRAND_ORIGINAL` = 'GNC' AND 
        //         ((LENGTH(`PRODUCT`) = 6) 
        //             OR (LENGTH(`PRODUCT`) = 10 AND barcode != 'CANCEL')        
        //         )
        //     )
        //     OR
        //     (`BRAND_ORIGINAL` = 'BB' AND 
        //         (`PRODUCT` REGEXP '^[6]' AND LENGTH(`PRODUCT`) = 5)
        //     )
        //     OR 
        //     (`BRAND_ORIGINAL` = 'LL' AND 
        //         (`PRODUCT` REGEXP '^[3]' AND LENGTH(`PRODUCT`) = 5)
        //     )
        //     OR 
        //     (`BRAND_ORIGINAL` = 'KTY' AND 
        //         (`PRODUCT` REGEXP '^[1]' AND LENGTH(`PRODUCT`) = 5)
        //     )
        // ORDER BY `PRODUCT` ASC;

        // Tranfer to product_channels
        // SELECT *
        // FROM `product1s_all`
        // WHERE
        //     (
        //         `BRAND_ORIGINAL` = 'OP' AND(
        //             (
        //                 `PRODUCT` REGEXP '^[2]' AND LENGTH(PRODUCT) = 5
        //             ) OR(
        //                 `PRODUCT` REGEXP '^[1]' AND LENGTH(PRODUCT) = 7
        //             ) OR(
        //                 `PRODUCT` REGEXP '^[1]' AND LENGTH(PRODUCT) = 5
        //             )
        //         ) OR(
        //             `BRAND_ORIGINAL` = 'CPS' AND(
        //                 (
        //                     `PRODUCT` REGEXP '^[3]' AND LENGTH(PRODUCT) = 5
        //                 ) OR(
        //                     `PRODUCT` REGEXP '^[7]' AND LENGTH(PRODUCT) = 5
        //                 ) OR(
        //                     `PRODUCT` REGEXP '^[1]' AND LENGTH(PRODUCT) = 7
        //                 ) OR(
        //                     `PRODUCT` REGEXP '^[1]' AND LENGTH(PRODUCT) = 5
        //                 )
        //             )
        //         ) OR(
        //             `BRAND_ORIGINAL` = 'GNC' AND(
        //                 LENGTH(PRODUCT) = 6 OR(
        //                     LENGTH(PRODUCT) = 10 AND `barcode` != 'CANCEL'
        //                 )
        //             )
        //         ) OR(
        //             `BRAND_ORIGINAL` = 'BB' AND(
        //                 (
        //                     `PRODUCT` REGEXP '^[6]' AND LENGTH(PRODUCT) = 5
        //                 ) OR(
        //                     `PRODUCT` REGEXP '^[1]' AND LENGTH(PRODUCT) = 5
        //                 )
        //             )
        //         ) OR(
        //             `BRAND_ORIGINAL` = 'LL' AND(
        //                 (
        //                     `PRODUCT` REGEXP '^[3]' AND LENGTH(PRODUCT) = 5
        //                 ) OR(
        //                     `PRODUCT` REGEXP '^[1]' AND LENGTH(PRODUCT) = 5
        //                 )
        //             )
        //         ) OR(
        //             `BRAND_ORIGINAL` = 'KTY' AND `PRODUCT` REGEXP '^[1]' AND LENGTH(PRODUCT) = 5
        //         )
        //     )
        // ORDER BY `PRODUCT` ASC;

        // SELECT BRAND_ORIGINAL, COUNT(*) AS BrandCount
        // FROM product1s_all
        // WHERE 
        //     (BRAND_ORIGINAL = 'CPS' AND 
        //         ((PRODUCT REGEXP '^3' AND LENGTH(PRODUCT) = 5) 
        //         OR (PRODUCT REGEXP '^7' AND LENGTH(PRODUCT) = 5)
        //         )
        //     )
        // GROUP BY BRAND_ORIGINAL
        // ORDER BY PRODUCT ASC;

        // SELECT BRAND, COUNT(*) AS BrandCount
        // FROM product1s_clean
        // WHERE 
        //     (BRAND = 'OP' AND 
        //         (PRODUCT REGEXP '^2' AND LENGTH(PRODUCT) = 5)
        //     OR (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 5)
        //     ) 
        //     OR 
        //     (BRAND = 'CPS' AND 
        //         ((PRODUCT REGEXP '^3' AND LENGTH(PRODUCT) = 5) 
        //         OR (PRODUCT REGEXP '^7' AND LENGTH(PRODUCT) = 5)
        //         OR (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 5)
        //         )
        //     )
        //     OR 
        //             (BRAND = 'GNC' AND 
        //                 ((LENGTH(PRODUCT) = 6) 
        //                     OR (LENGTH(PRODUCT) = 10 AND barcode != 'CANCEL')  
        //                 OR (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 5)
        //                 )
        //             )
        //             OR
        //             (BRAND = 'BB' AND 
        //                 (PRODUCT REGEXP '^[6]' AND LENGTH(PRODUCT) = 5)
        //             OR (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 5)
        //             )
        //             OR 
        //             (BRAND = 'LL' AND 
        //                 (PRODUCT REGEXP '^[3]' AND LENGTH(PRODUCT) = 5)
        //                 OR (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 5)
        //             )
        //             OR 
        //             (BRAND = 'KTY' AND 
        //                 (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 5)
        //             )
        // GROUP BY BRAND
        // ORDER BY PRODUCT ASC;

        // $productsAll = DB::table('product1s_all')
        //     ->where(function ($query) {
        //         $query->where('BRAND_ORIGINAL', 'OP')
        //             ->where(function ($subQuery) {
        //                 $subQuery->where(function ($innerQuery) {
        //                     $innerQuery->where('PRODUCT', 'REGEXP', '^2')
        //                             ->whereRaw('LENGTH(PRODUCT) = 5');
        //                 })->orWhere(function ($innerQuery) {
        //                     $innerQuery->where('PRODUCT', 'REGEXP', '^1')
        //                             ->whereRaw('LENGTH(PRODUCT) = 7');
        //                 });
        //             });
        //         $query->orWhere(function ($subQuery) {
        //             $subQuery->where('BRAND_ORIGINAL', 'CPS')
        //                 ->where(function ($innerQuery) {
        //                     $innerQuery->where(function ($deepQuery) {
        //                         $deepQuery->where('PRODUCT', 'REGEXP', '^3')
        //                                 ->whereRaw('LENGTH(PRODUCT) = 5');
        //                     })->orWhere(function ($deepQuery) {
        //                         $deepQuery->where('PRODUCT', 'REGEXP', '^7')
        //                                 ->whereRaw('LENGTH(PRODUCT) = 5');
        //                     })->orWhere(function ($deepQuery) {
        //                         $deepQuery->where('PRODUCT', 'REGEXP', '^1')
        //                                 ->whereRaw('LENGTH(PRODUCT) = 7');
        //                     });
        //                 });
        //         });
        //         $query->orWhere(function ($subQuery) {
        //             $subQuery->where('BRAND_ORIGINAL', 'GNC')
        //                 ->where(function ($innerQuery) {
        //                     $innerQuery->whereRaw('LENGTH(PRODUCT) = 6')
        //                             ->orWhere(function ($deepQuery) {
        //                                 $deepQuery->whereRaw('LENGTH(PRODUCT) = 10')
        //                                             ->where('barcode', '!=', 'CANCEL');
        //                             });
        //                 });
        //         });
        //         $query->orWhere(function ($subQuery) {
        //             $subQuery->where('BRAND_ORIGINAL', 'BB')
        //                 ->where('PRODUCT', 'REGEXP', '^[6]')
        //                 ->whereRaw('LENGTH(PRODUCT) = 5');
        //         });
        //         $query->orWhere(function ($subQuery) {
        //             $subQuery->where('BRAND_ORIGINAL', 'LL')
        //                 ->where('PRODUCT', 'REGEXP', '^[3]')
        //                 ->whereRaw('LENGTH(PRODUCT) = 5');
        //         });
        //         $query->orWhere(function ($subQuery) {
        //             $subQuery->where('BRAND_ORIGINAL', 'KTY')
        //                 ->where('PRODUCT', 'REGEXP', '^[1]')
        //                 ->whereRaw('LENGTH(PRODUCT) = 5');
        //         });
        //     })
        //     ->orderBy('PRODUCT', 'ASC')
        //     ->get();
        // ->toArray();

        // SELECT *
        // FROM product1s_all
        // WHERE 
        //     (BRAND_ORIGINAL = 'LL' AND 
        //         ((PRODUCT REGEXP '^[3]' AND LENGTH(PRODUCT) = 5)
        //             OR (BRAND_ORIGINAL = 'KTY' AND PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 5)
        //             )
        //     )  
        // ORDER BY PRODUCT ASC;

        // วัสดุสิ้นเปลือง && สินค้าขาย
//         SELECT *
// FROM `product1s_all`
// WHERE 
//     (
//         -- OP Brand
//         (BRAND_ORIGINAL = 'OP' AND (
//             (PRODUCT REGEXP '^[2]' AND LENGTH(PRODUCT) = 5)
//             OR (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 7)
//              OR PRODUCT IN (
//                 SELECT PRODUCT
//                 FROM `product1s_all`
//                 WHERE PRODUCT REGEXP '^[8-9]'
//                 GROUP BY PRODUCT
//                 HAVING COUNT(*) = 1
//             )
//         ))
//         OR
//         -- CPS Brand
//         (BRAND_ORIGINAL = 'CPS' AND (
//             (PRODUCT REGEXP '^[3]' AND LENGTH(PRODUCT) = 5)
//             OR (PRODUCT REGEXP '^[7]' AND LENGTH(PRODUCT) = 5)
//             OR (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 7)
//              OR PRODUCT IN (
//                 SELECT PRODUCT
//                 FROM `product1s_all`
//                 WHERE PRODUCT REGEXP '^[8-9]'
//                 GROUP BY PRODUCT
//                 HAVING COUNT(*) = 1
//             )
//         ))
//         OR
//         -- GNC Brand
//         (BRAND_ORIGINAL = 'GNC' AND (
//             LENGTH(PRODUCT) = 6
//             OR (LENGTH(PRODUCT) = 10 AND barcode != 'CANCEL')
//              OR PRODUCT IN (
//                 SELECT PRODUCT
//                 FROM `product1s_all`
//                 WHERE PRODUCT REGEXP '^[8-9]'
//                 GROUP BY PRODUCT
//                 HAVING COUNT(*) = 1
//             )
//         ))
//         OR
//         -- BB Brand
//         (BRAND_ORIGINAL = 'BB' AND (
//             (PRODUCT REGEXP '^[6]' AND LENGTH(PRODUCT) = 5)
//              OR PRODUCT IN (
//                 SELECT PRODUCT
//                 FROM `product1s_all`
//                 WHERE PRODUCT REGEXP '^[8-9]'
//                 GROUP BY PRODUCT
//                 HAVING COUNT(*) = 1
//             )
//         ))
//         OR
//         -- LL Brand
//         (BRAND_ORIGINAL = 'LL' AND (
//             (PRODUCT REGEXP '^[3]' AND LENGTH(PRODUCT) = 5)
//              OR PRODUCT IN (
//                 SELECT PRODUCT
//                 FROM `product1s_all`
//                 WHERE PRODUCT REGEXP '^[8-9]'
//                 GROUP BY PRODUCT
//                 HAVING COUNT(*) = 1
//             )
//         ))
//         OR
//         -- KTY Brand
//         (BRAND_ORIGINAL = 'KTY' AND (
//             (PRODUCT REGEXP '^[1]' AND LENGTH(PRODUCT) = 5)
//              OR PRODUCT IN (
//                 SELECT PRODUCT
//                 FROM `product1s_all`
//                 WHERE PRODUCT REGEXP '^[8-9]'
//                 GROUP BY PRODUCT
//                 HAVING COUNT(*) = 1
//             )
//         ))
//     )
// ORDER BY PRODUCT ASC;

        $productsAll = DB::table('product1s_all')
            ->where(function ($query) {
                $query->where('BRAND_ORIGINAL', 'OP')
                    ->where(function ($subQuery) {
                        $subQuery->where(function ($innerQuery) {
                            $innerQuery->where('PRODUCT', 'REGEXP', '^[2]')
                                    ->whereRaw('LENGTH(PRODUCT) = 5');
                        })->orWhere(function ($innerQuery) {
                            $innerQuery->where('PRODUCT', 'REGEXP', '^[1]')
                                    ->whereRaw('LENGTH(PRODUCT) = 7');
                        })->orWhere(function ($deepQuery) {
                            $deepQuery->where('PRODUCT', 'REGEXP', '^[1]')
                                    ->whereRaw('LENGTH(PRODUCT) = 5');
                        });
                    });
                $query->orWhere(function ($subQuery) {
                    $subQuery->where('BRAND_ORIGINAL', 'CPS')
                        ->where(function ($innerQuery) {
                            $innerQuery->where(function ($deepQuery) {
                                $deepQuery->where('PRODUCT', 'REGEXP', '^[3]')
                                        ->whereRaw('LENGTH(PRODUCT) = 5');
                            })->orWhere(function ($deepQuery) {
                                $deepQuery->where('PRODUCT', 'REGEXP', '^[7]')
                                        ->whereRaw('LENGTH(PRODUCT) = 5');
                            })->orWhere(function ($deepQuery) {
                                $deepQuery->where('PRODUCT', 'REGEXP', '^[1]')
                                        ->whereRaw('LENGTH(PRODUCT) = 7');
                            })->orWhere(function ($deepQuery) {
                                $deepQuery->where('PRODUCT', 'REGEXP', '^[1]')
                                        ->whereRaw('LENGTH(PRODUCT) = 5');
                            });
                        });
                });
                $query->orWhere(function ($subQuery) {
                    $subQuery->where('BRAND_ORIGINAL', 'GNC')
                        ->where(function ($innerQuery) {
                            $innerQuery->whereRaw('LENGTH(PRODUCT) = 6')
                                    ->orWhere(function ($deepQuery) {
                                        $deepQuery->whereRaw('LENGTH(PRODUCT) = 10')
                                                    ->where('barcode', '!=', 'CANCEL');
                                    });
                        });
                });
                $query->orWhere(function ($subQuery) {
                    $subQuery->where('BRAND_ORIGINAL', 'BB')
                        ->where(function ($innerQuery) {
                            $innerQuery->where(function ($deepQuery) {
                                $deepQuery->where('PRODUCT', 'REGEXP', '^[6]')
                                    ->whereRaw('LENGTH(PRODUCT) = 5');
                            })->orWhere(function ($deepQuery) {
                                $deepQuery->where('PRODUCT', 'REGEXP', '^[1]')
                                        ->whereRaw('LENGTH(PRODUCT) = 5');
                            });
                        });
                });
                $query->orWhere(function ($subQuery) {
                    $subQuery->where('BRAND_ORIGINAL', 'LL')
                        ->where(function ($innerQuery) {
                            $innerQuery->where(function ($deepQuery) {
                                $deepQuery->where('PRODUCT', 'REGEXP', '^[3]')
                                    ->whereRaw('LENGTH(PRODUCT) = 5');
                            })->orWhere(function ($deepQuery) {
                                $deepQuery->where('PRODUCT', 'REGEXP', '^[1]')
                                        ->whereRaw('LENGTH(PRODUCT) = 5');
                            });
                        });
                })
                ->orWhere(function ($query) {
                    $query->where('BRAND_ORIGINAL', 'KTY')
                            ->where('PRODUCT', 'REGEXP', '^[1]')
                            ->whereRaw('LENGTH(PRODUCT) = 5');
                });
            })
        ->orderBy('PRODUCT', 'ASC')
        ->toSql();

        dd($productsAll);
        return view('home');
    }

    public function listBrandOp(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_op = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND_ORIGINAL, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND_ORIGINAL = 'op') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND_ORIGINAL', '=', 'op')
            ->groupBy(DB::raw('BRAND_ORIGINAL, LEFT(product, 1)'));

        // dd($result_op);
        $data = $result_op->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandCps(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_cps = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND_ORIGINAL, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND_ORIGINAL = 'cps') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND_ORIGINAL', '=', 'cps')
            ->groupBy(DB::raw('BRAND_ORIGINAL, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_cps->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandSsup(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_cps = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND_ORIGINAL, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND_ORIGINAL = 'ssup') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND_ORIGINAL', '=', 'ssup')
            ->groupBy(DB::raw('BRAND_ORIGINAL, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_cps->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandGnc(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_gnc = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND_ORIGINAL, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND_ORIGINAL = 'gnc') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND_ORIGINAL', '=', 'gnc')
            ->groupBy(DB::raw('BRAND_ORIGINAL, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_gnc->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandKm(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_km = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND_ORIGINAL, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND_ORIGINAL = 'km') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND_ORIGINAL', '=', 'km')
            ->groupBy(DB::raw('BRAND_ORIGINAL, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_km->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandKshop(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_kshop = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND_ORIGINAL, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND_ORIGINAL = 'kty') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND_ORIGINAL', '=', 'kty')
            ->groupBy(DB::raw('BRAND_ORIGINAL, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_kshop->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandKshopcr(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_kshopcr = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND = 'kshopcr') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND', '=', 'kshopcr')
            ->groupBy(DB::raw('BRAND, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_kshopcr->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandKmcr(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_kmcr = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND = 'kmcr') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND', '=', 'kmcr')
            ->groupBy(DB::raw('BRAND, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_kmcr->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandDealer(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_dealer = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND = 'dealer') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND', '=', 'dealer')
            ->groupBy(DB::raw('BRAND, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_dealer->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandBb(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_bb = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND_ORIGINAL, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND_ORIGINAL = 'bb') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND_ORIGINAL', '=', 'bb')
            ->groupBy(DB::raw('BRAND_ORIGINAL, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_bb->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandLl(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_ll = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND_ORIGINAL, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND_ORIGINAL = 'll') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[0-9]'")
            ->where('BRAND_ORIGINAL', '=', 'll')
            ->groupBy(DB::raw('BRAND_ORIGINAL, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_ll->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandEmpty(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_empty = DB::table('product1s_all as p')
            ->selectRaw("
                CONCAT(BRAND, ' = ', LEFT(product, 1)) AS `Number`, 
                COUNT(*) AS `Count`, 
                (SELECT COUNT(*) 
                FROM product1s_all 
                WHERE LEFT(product, 1) = LEFT(p.product, 1) 
                AND BRAND = '') AS `Total`
            ")
            ->whereRaw("product REGEXP '^[A-Z]'")
            ->where('BRAND', '=', '')
            ->groupBy(DB::raw('BRAND, LEFT(product, 1)'));

        // dd($result_cps);
        $data = $result_empty->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
    public function listBrandOpClean(Request $request)
    {
        $limit = $request->input('length'); // limit per page
        $request->merge([
            'page' => ceil(($request->input('start') + 1) / $limit),
        ]);

        $result_op_clean = DB::table('product1s_all')
            ->where('BRAND_ORIGINAL', 'op')
            ->where(function ($query) {
                $query->where('PRODUCT', 'REGEXP', '^2')
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('PRODUCT', 'REGEXP', '^1')
                                ->whereRaw('LENGTH(PRODUCT) != 5');
                    });
            })
            ->orderBy('PRODUCT', 'asc');
            // ->get();

        // dd($result_cps);
        $data = $result_op_clean->paginate($limit);
        $totalRecords = $data->total();
        $totalRecordwithFilter = $data->count();
        $response = [
            'draw' => intval($request->draw),
            'iTotalRecords' => $totalRecordwithFilter,
            'iTotalDisplayRecords' => $totalRecords,
            'aaData' => $data->items(),
        ];

        return response()->json($response);
    }
}
