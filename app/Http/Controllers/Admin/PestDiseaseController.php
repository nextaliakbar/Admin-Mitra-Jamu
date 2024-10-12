<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PestDisease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class PestDiseaseController extends Controller
{
    private $messages = [
        'code.unique' => 'Kode sudah digunakan',
        'label.required' => 'Label harus diisi',
        'description.required' => 'Deskripsi harus diisi',
        'treatment.required' => 'Penanganan harus diisi',
        'treatment.array' => 'Penanganan harus berupa array',
        'treatment.min' => 'Penanganan minimal 1',
        'treatment.*.required' => 'Penanganan :position harus diisi',
        'treatment.*.distinct' => 'Penanganan :position tidak boleh sama dengan penanganan lain',
        'treatment.*.string' => 'Penanganan :position harus berupa string',
    ];

    public function index(Request $request)
    {
        $title = Lang::get('translation.Expert_System_PestDisease');
        $pestDiseases = PestDisease::orderByRaw('length(code), code')->get();

        // Convert treatment from json to array
        $pestDiseases->map(function ($item) {
            $item->treatment = json_decode($item->treatment);
            return $item;
        });

        if ($request->expectsJson()) {
            $pestDiseasesJson = PestDisease::paginate(10);
            $pestDiseasesJson->getCollection()->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'code' => $item->code,
                    'label' => $item->label,
                    'description' => $item->description,
                    'treatment' => json_decode($item->treatment),
                ];
            });
            return responseJson('success', 'Data retrieved successfully', $pestDiseasesJson, 200);
        }

        return view('pages._Main.ExpertSystem.PestDisease.index', compact('pestDiseases', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', Rule::unique('pest_diseases', 'code')->whereNull('deleted_at')],
            'label' => 'required',
            'description' => 'required',
            'treatment' => 'required|array|min:1',
            'treatment.*' => 'required|distinct|string',
        ], $this->messages);

        $pestDisease = PestDisease::create([
            'code' => $request->code,
            'label' => $request->label,
            'description' => $request->description,
            'treatment' => json_encode($request->treatment),
            'day' => $request->day ?? 0,
        ]);

        if (!$pestDisease) {
            return back()->withErrors(['error' => 'Something went wrong'])->withInput();
        }

        return redirect()->route('admin.pest-diseases.index');
    }

    public function create()
    {
        $title = str_replace('Data', 'Create', Lang::get('translation.Expert_System_PestDisease'));

        // check if there is any data in database
        // if there is no data, then create new code with P1
        if (PestDisease::count() == 0) {
            $newCode = 'P1';
        } else {
            // if there is data, then get the last code and increment by 1
            $newCode = PestDisease::orderByRaw('length(code), code')->get()->last()->code;
            // code is in format P1, P2, P3, etc
            // so we need to get the number and increment by 1
            $newCode = 'P' . (intval(substr($newCode, 1)) + 1);
        }

        return view('pages._Main.ExpertSystem.PestDisease.create', compact('title', 'newCode'))->with('success', 'Data created successfully');
    }

    public function edit($id)
    {
        $title = str_replace('Data', 'Edit', Lang::get('translation.Expert_System_PestDisease'));

        try {
            $pestDisease = PestDisease::findOrFail($id);
            // Convert treatment from json to array
            $pestDisease->treatment = json_decode($pestDisease->treatment);
            return view('pages._Main.ExpertSystem.PestDisease.edit', compact('title', 'pestDisease'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('admin.pest-diseases.index')
                ->withErrors(['error' => 'Data tidak ditemukan']);
        }
    }

    public function update(Request $request, PestDisease $pestDisease)
    {
        $request->validate([
            'code' => ['required', Rule::unique('pest_diseases', 'code')->ignore($pestDisease->id)->whereNull('deleted_at')],
            'label' => 'required',
            'description' => 'required',
            'treatment' => 'required|array|min:1',
            'treatment.*' => 'required|distinct|string',
            'day' => 'required|numeric',
        ], [
            ...$this->messages,
            'day.required' => 'Hari harus diisi',
            'day.numeric' => 'Hari harus berupa angka',
        ]);

        $pestDisease->update([
            'code' => $request->code,
            'label' => $request->label,
            'description' => $request->description,
            'treatment' => json_encode($request->treatment),
            'day' => $request->day,
        ]);

        if (!$pestDisease) {
            return back()->withErrors(['error' => 'Something went wrong'])->withInput();
        }
        return redirect()->route('admin.pest-diseases.index')->with('success', 'Data updated successfully');
    }

    public function show(PestDisease $pestDisease)
    {
        $title = str_replace('Data', 'Detail', Lang::get('translation.Expert_System_PestDisease'));
        $pestDisease->treatment = json_decode($pestDisease->treatment);

        $conditions = DB::table('conditions')
            ->whereNull('deleted_at')
            ->where('pest_disease_id', $pestDisease->id)
            ->orderByRaw('length(code), code')
            ->get();

        foreach ($conditions as $key => $condition) {
            $condition->is_after_code = DB::table('conditions')
                ->whereNull('deleted_at')
                ->where('id', $condition->is_after)
                ->first()->code ?? null;
            $condition->treatment = json_decode($condition->treatment);
        }

        $pestDisease->conditions = $conditions;

        return view('pages._Main.ExpertSystem.PestDisease.show', compact('title', 'pestDisease'));
    }

    public function destroy(PestDisease $pestDisease)
    {
        try {
            $pestDisease->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ]);
        }
    }
}
