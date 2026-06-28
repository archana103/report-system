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

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');

        $query->orderBy($sortBy, $sortDir);

        if ($request->has('export') && $request->export == 'true') {
            return response()->json($query->get());
        }

        $limit = $request->get('limit', 20);
        $data = $query->paginate($limit);

        return response()->json($data);
    }

    public function destroy($id)
    {
        $requestForm = RequestForm::findOrFail($id);
        $requestForm->delete();

        return response()->json(['message' => 'Record deleted successfully!']);
    }
}
