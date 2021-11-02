<?php

namespace App\Http\Controllers;

use App\Models\ServiceVoucher;
use App\Models\ServiceVoucherDetail;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\StoreServiceVoucherDetailRequest;

class ServiceVoucherDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $service_voucher = ServiceVoucher::findOrFail($request->service_voucher_id);

        $data = [
            'service_voucher' => $service_voucher,
        ];

        return view('service-voucher-detail.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceVoucherDetailRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $create = ServiceVoucherDetail::create([
                'date' => date("Y-m-d", strtotime($request->date)),
                'result' => $request->result,
                'service_voucher_id' => $request->service_voucher_id,
            ]);
            
            DB::commit();
            return redirect()->route('service_vouchers.index')->with('alert-success','Thêm chi tiết phiếu dịch vụ thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','Thêm chi tiết phiếu dịch vụ thất bại!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceVoucherDetail  $serviceVoucherDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceVoucherDetail $serviceVoucherDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceVoucherDetail  $serviceVoucherDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceVoucherDetail $serviceVoucherDetail)
    {
        $data = [
            'data_edit' => $serviceVoucherDetail,
            'service_voucher' => $serviceVoucherDetail->serviceVoucher,
        ];

        return view('service-voucher-detail.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceVoucherDetail  $serviceVoucherDetail
     * @return \Illuminate\Http\Response
     */
    public function update(StoreServiceVoucherDetailRequest $request, ServiceVoucherDetail $serviceVoucherDetail)
    {
        try {
            DB::beginTransaction();
            
            $serviceVoucherDetail->update([
                'date' => date("Y-m-d", strtotime($request->date)),
                'result' => $request->result,
            ]);

            DB::commit();
            return redirect()->route('service_vouchers.edit', $serviceVoucherDetail->serviceVoucher->id)->with('alert-success', 'Cập nhật chi tiết phiếu dịch vụ thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error', 'Cập nhật chi tiết phiếu dịch vụ thất bại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceVoucherDetail  $serviceVoucherDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceVoucherDetail $serviceVoucherDetail)
    {
        
    }

    public function delete(ServiceVoucherDetail $serviceVoucherDetail)
    {
        try {
            DB::beginTransaction();

            ServiceVoucherDetail::destroy($serviceVoucherDetail->id);

            DB::commit();
            return redirect()->back()->with('alert-success', 'Xóa phiếu dịch vụ thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error', 'Xóa phiếu dịch vụ thất bại!');
        }
    }
}
