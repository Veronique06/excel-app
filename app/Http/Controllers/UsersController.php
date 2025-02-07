<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        // Importation du fichier
        Excel::import(new UsersImport, $request->file('file'));

        // return redirect('/')->with('success', 'Importation réussie !');

        session()->flash('success', 'Importation réussie !');
        return back();

        // return response()->json(['message' => 'Importation réussie !'], 200);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}

