<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Symptoms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class SymptomsController extends Controller
{
    public $title;

    public function __construct()
    {
        $this->title = Lang::get('translation.Expert_System_Symptom');
    }

    public function index(Request $request)
    {
        $title = $this->title;
        $symptoms = Symptoms::orderByRaw('length(code), code')->get();

        if ($request->expectsJson()) {
            $symptomsJson = $symptoms->map(function ($item) {
                return [
                    'code' => $item->code,
                    'label' => $item->label,
                ];
            });
            return responseJson('success', 'Data retrieved successfully', $symptomsJson, 200);
        }

        return view('pages._Main.ExpertSystem.Symptoms.index', compact('symptoms', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Symptoms::count() == 0) {
            $newCode = 'G1';
        } else {
            $newCode = Symptoms::orderByRaw('length(code), code')->get()->last()->code;
            $newCode = 'G' . (intval(substr($newCode, 1)) + 1);
        }

        $title = 'Tambah Gejala';

        return view('pages._Main.ExpertSystem.Symptoms.create', ['title' => $title, 'newCode' => $newCode]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', Rule::unique('symptoms', 'code')->whereNull('deleted_at')],
            'label' => 'required',
        ]);

        $symptom = Symptoms::create([
            'code' => $request->code,
            'label' => $request->label,
        ]);

        if (!$symptom) {
            return back()->with('error', 'Data gagal ditambahkan')->withInput();
        }

        return redirect()->route('admin.symptoms.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $symptom = Symptoms::find($id);
            $title = 'Edit Gejala ' . ' ' . $symptom->code;
            return view('pages._Main.ExpertSystem.Symptoms.edit', ['title' => $title, 'symptom' => $symptom]);
        } catch (\Throwable $th) {
            return redirect()->route('admin.symptoms.index')->withErrors(['error' => 'Data tidak ditemukan']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'label' => 'required',
        ]);

        $symptom = Symptoms::find($id);
        $symptom->code = $request->code;
        $symptom->label = $request->label;
        $symptom->save();

        return redirect()->route('admin.symptoms.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Symptoms $symptom)
    {
        try {
            $symptom->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal dihapus',
            ]);
        }
    }
}
