<?php

namespace App\Http\Controllers;

use App\Models\HealthCertification;
use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePrescriptionRequest;
use DB;
use Illuminate\Database\Eloquent\Builder;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prescriptions = Prescription::paginate(10);

        if ($request->search) {
            $prescriptions = Prescription::whereHas('patient', function (Builder $query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            })->paginate(10);
            $prescriptions->appends(['search' => $request->search]);
        }

        $data = [
            'prescriptions' => $prescriptions
        ];

        return view('prescription.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $patients = Patient::all();
        $users = User::all();
        $medicines = Medicine::all();

        $data = [
            'medicines' => $medicines,
            'patients' => $patients,
            'users' => $users,
            'request' => $request,
        ];
        
        if ($request->health_certification_id) {
            $health_certification = HealthCertification::findOrFail($request->health_certification_id);
            $data['health_certification'] = $health_certification;
        }

        return view('prescription.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePrescriptionRequest $request)
    {
        $is_health_insurance_card = $request->is_health_insurance_card ? 1 : 0;

        try {
            DB::beginTransaction();

            $create_precription = Prescription::create([
                'code' => '',
                'patient_id' => $request->patient_id,
                'user_id' => $request->user_id,
                'total_money' => 0,
                'status' => 0,
                'is_health_insurance_card' => $is_health_insurance_card,
                'health_certification_id' => $request->health_certification_id,
            ]);

            $total_money = 0;
            foreach($request->prescription_details as $prescription_detail) {
                $medicine = Medicine::findOrFail($prescription_detail['medicine_id']);
                
                if ($is_health_insurance_card == 0) {
                    $total = $medicine->price * $prescription_detail['amount'];
                    $total_money += $total;
                }
                else {
                    $total = 0;
                }

                PrescriptionDetail::create([
                    'prescription_id' => $create_precription->id,
                    'medicine_id' => $prescription_detail['medicine_id'],
                    'amount' => $prescription_detail['amount'],
                    'price' => $medicine->price,
                    'total_money' => $total,
                    'use' => $prescription_detail['use'],
                ]);

            }

            $create_precription->update([
                'code' => 'DT'.str_pad($create_precription->id, 6, '0', STR_PAD_LEFT),
                'total_money' => $total_money,
            ]);

            
            DB::commit();

            if ($request->health_certification_id) {
                return redirect()->route('health_certifications.index')->with('alert-success','Th??m ????n thu???c th??nh c??ng!');
            }

            return redirect()->route('prescriptions.index')->with('alert-success','Th??m ????n thu???c th??nh c??ng!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','Th??m ????n thu???c th???t b???i!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function show(Prescription $prescription)
    {
        $data = [
            'prescription' => $prescription,
        ];

        return view('prescription.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function edit(Prescription $prescription)
    {
        $patients = Patient::all();
        $users = User::all();
        $medicines = Medicine::all();

        $data = [
            'medicines' => $medicines,
            'patients' => $patients,
            'users' => $users,
            'data_edit' => $prescription,
        ];

        return view('prescription.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function update(StorePrescriptionRequest $request, Prescription $prescription)
    {
        $is_health_insurance_card = $request->is_health_insurance_card ? 1 : 0;

        try {
            DB::beginTransaction();

            $prescription->prescriptionDetails()->delete();

            $total_money = 0;
            foreach($request->prescription_details as $prescription_detail) {
                $medicine = Medicine::findOrFail($prescription_detail['medicine_id']);
                
                if ($is_health_insurance_card == 0) {
                    $total = $medicine->price * $prescription_detail['amount'];
                    $total_money += $total;
                }
                else {
                    $total = 0;
                }

                PrescriptionDetail::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $prescription_detail['medicine_id'],
                    'amount' => $prescription_detail['amount'],
                    'price' => $medicine->price,
                    'total_money' => $total,
                    'use' => $prescription_detail['use'],
                ]);

            }

            $prescription->update([
                'user_id' => $request->user_id,
                'patient_id' => $request->patient_id,
                'is_health_insurance_card' => $is_health_insurance_card,
                'total_money' => $total_money,
            ]);

            
            DB::commit();
            return redirect()->route('prescriptions.index')->with('alert-success','C???p nh???t ????n thu???c th??nh c??ng!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','C???p nh???t ????n thu???c th???t b???i!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prescription $prescription)
    {
        try {
            DB::beginTransaction();

            Prescription::destroy($prescription->id);

            $prescription->prescriptionDetails()->delete();
            
            DB::commit();
            return redirect()->route('prescriptions.index')->with('alert-success','X??a ????n thu???c th??nh c??ng!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','X??a ????n thu???c th???t b???i!');
        }
    }

    public function confirmPayment(Prescription $prescription)
    {
        try {
            DB::beginTransaction();

            $prescription->update([
                'status' => 1
            ]);
            
            DB::commit();
            return redirect()->route('prescriptions.index')->with('alert-success','X??c nh???n thanh to??n th??nh c??ng!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','X??c nh???n thanh to??n th???t b???i!');
        }
    }

    public function print(Prescription $prescription)
    {
        $data = [
            'prescription' => $prescription,
        ];

        return view('prescription.print', $data);
    }
}
