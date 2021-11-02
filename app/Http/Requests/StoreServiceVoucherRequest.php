<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patient_id' => 'required', 
            'medical_service_id' => 'required', 
            'user_id' => 'required', 
            'start_date' => 'required|date', 
            'end_date' => 'required|date', 
            'total_money' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'patient_id.required' => 'Tên bệnh nhân là trường bắt buộc.', 
            'medical_service_id.required' => 'Dịch vụ khám là trường bắt buộc.', 
            'user_id.required' => 'Bác sĩ là trường bắt buộc.', 
            'total_money.required' => 'Giá là trường bắt buộc.',
            'total_money.min' => 'Giá nhỏ nhất là :min VNĐ.',
            'start_date.required' => 'Từ ngày là trường bắt buộc.',
            'start_date.date' => 'Từ ngày không đúng định dạng.',
            'end_date.required' => 'Đến ngày là trường bắt buộc.',
            'end_date.date' => 'Đến ngày không đúng định dạng.',
        ];
    }
}
