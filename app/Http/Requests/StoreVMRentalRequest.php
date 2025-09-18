<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVMRentalRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'vm_id' => ['required','exists:vms,id'],
            'start_time' => ['required','date'],
            'end_time' => ['nullable','date','after_or_equal:start_time'],
            'purpose' => ['nullable','string','max:1000'],
        ];
    }
}
