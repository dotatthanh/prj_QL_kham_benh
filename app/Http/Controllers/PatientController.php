<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\StorePatientRequest;
use DB;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $patients = Patient::paginate(10);

        if ($request->search) {
            $patients = Patient::where('name', 'like', '%'.$request->search.'%')->paginate(10);
            $patients->appends(['search' => $request->search]);
        }

        $data = [
            'patients' => $patients
        ];

        return view('patient.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patient.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatientRequest $request)
    {
        try {
            DB::beginTransaction();

            $file_path = '';
            if ($request->file('avatar')) {
                $name = time().'_'.$request->avatar->getClientOriginalName();
                $file_path = 'uploads/avatar/patient/'.$name;
                Storage::disk('public_uploads')->putFileAs('avatar/patient', $request->avatar, $name);
            }
            
            $create = Patient::create([
                'code' => '',
                'name' => $request->name,
                'gender' => $request->gender,
                'birthday' => date("Y-m-d", strtotime($request->birthday)),
                'phone' => $request->phone,
                'address' => $request->address,
                'avatar' => $file_path,
            ]);

            $create->update([
                'code' => 'BN'.str_pad($create->id, 6, '0', STR_PAD_LEFT)
            ]);
            
            DB::commit();
            return redirect()->route('patients.index')->with('alert-success','Th??m b???nh nh??n th??nh c??ng!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','Th??m b???nh nh??n th???t b???i!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        $data = [
            'data_edit' => $patient
        ];

        return view('patient.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(StorePatientRequest $request, Patient $patient)
    {
        try {
            DB::beginTransaction();

            if ($request->file('avatar')) {
                $name = time().'_'.$request->avatar->getClientOriginalName();
                $file_path = 'uploads/avatar/patient/'.$name;
                Storage::disk('public_uploads')->putFileAs('avatar/patient', $request->avatar, $name);
                
                $patient->update([
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'birthday' => date("Y-m-d", strtotime($request->birthday)),
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'avatar' => $file_path,
                ]);
            }
            else {
                $patient->update([
                    'name' => $request->name,
                    'gender' => $request->gender,
                    'birthday' => date("Y-m-d", strtotime($request->birthday)),
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            }
            
            DB::commit();
            return redirect()->route('patients.index')->with('alert-success','S???a b???nh nh??n th??nh c??ng!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','S???a b???nh nh??n th???t b???i!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        try {
            DB::beginTransaction();

            if ($patient->healthCertifications->count() > 0) {
                return redirect()->back()->with('alert-error','X??a b???nh nh??n th???t b???i! B???nh nh??n '.$patient->name.' ??ang c?? gi???y kh??m b???nh.');
            }
            elseif ($patient->healthInsuranceCard) {
                return redirect()->back()->with('alert-error','X??a b???nh nh??n th???t b???i! B???nh nh??n '.$patient->name.' ??ang c?? th??? hi???m.');
            }
            elseif ($patient->serviceVouchers->count() > 0) {
                return redirect()->back()->with('alert-error','X??a b???nh nh??n th???t b???i! B???nh nh??n '.$patient->name.' ??ang c?? phi???u d???ch v???.');
            }
            elseif ($patient->prescriptions->count() > 0) {
                return redirect()->back()->with('alert-error','X??a b???nh nh??n th???t b???i! B???nh nh??n '.$patient->name.' ??ang c?? ????n thu???c.');
            }

            Patient::destroy($patient->id);
            
            DB::commit();
            return redirect()->route('patients.index')->with('alert-success','X??a b???nh nh??n th??nh c??ng!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert-error','X??a b???nh nh??n th???t b???i!');
        }
    }
}
