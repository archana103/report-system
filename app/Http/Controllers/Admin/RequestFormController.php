<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RequestForm;

class RequestFormController extends Controller
{
    public function index(Request $request)
    {
        $query = RequestForm::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('subject', 'like', '%' . $search . '%');
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.request_forms.index', compact('requests'));
    }

    public function destroy($id)
    {
        $requestForm = RequestForm::findOrFail($id);
        $requestForm->delete();

        return redirect()->back()->with('success', 'Request Form submission deleted successfully!');
    }
}
