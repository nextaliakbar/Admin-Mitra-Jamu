<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use App\Models\PestDisease;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConditionController extends Controller
{
    public function edit($id)
    {
        try {
            $condition = Condition::findOrFail($id);
            $title = 'Edit Kondisi ' . $condition->code;

            $isAfterOptions = Condition::where('id', '!=', $condition->id)
                ->where('pest_disease_id', $condition->pest_disease_id)
                ->get()
                ->map(function ($item) use ($condition) {
                    return [
                        'id' => $item->id,
                        'text' => $item->value,
                        'selected' => $condition->is_after == $item->id,
                    ];
                });

            return view('pages._Main.ExpertSystem.PestDisease.Condition.edit', compact('title', 'condition', 'isAfterOptions'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('admin.pest-disease.index')
                ->withErrors(['error' => 'Data tidak ditemukan']);
        }
    }

    public function show($id)
    {
        $condition = Condition::findOrFail($id);
        return responseJson('success', 'Data retrieved successfully', $condition, 200);
    }

    public function update(Request $request)
    {
        $condition = Condition::findOrFail($request->id);

        $request->validate([
            'status' => 'required|in:IMPROVED,WORSENED,HEALED,DIED',
            'value' => 'required|string',
            'treatment' => 'required|array|min:1',
            'treatment.*' => 'required|distinct|string',
            'is_after' => ['nullable', 'integer', Rule::exists('conditions', 'id')->where(function ($query) use ($condition) {
                $query->where('pest_disease_id', $condition->pest_disease_id);
            })],
            'day' => 'integer',
        ], [
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status harus salah satu dari: IMPROVED, WORSENED, HEALED, DIED',
            'value.required' => 'Kondisi harus diisi',
            'value.string' => 'Kondisi harus berupa string',
            'treatment.required' => 'Penanganan harus diisi',
            'treatment.array' => 'Penanganan harus berupa array',
            'treatment.min' => 'Penanganan minimal 1',
            'treatment.*.required' => 'Penanganan harus diisi',
            'treatment.*.distinct' => 'Penanganan tidak boleh sama',
            'treatment.*.string' => 'Penanganan harus berupa string',
            'is_after.integer' => 'Tampil setelah harus berupa angka',
            'is_after.exists' => 'Kondisi tidak ditemukan',
            'day.integer' => 'Hari harus berupa angka',
        ]);

        if ($request->day != 0) {
            $conditions = Condition::where('pest_disease_id', $condition->pest_disease_id)
                ->where('id', '!=', $condition->id)
                ->get();

            $conditions->push($request);

            $isDay0Exist = false;
            foreach ($conditions as $key => $value) {
                if ($value->day == 0) {
                    $isDay0Exist = true;
                    break;
                }
            }

            if (!$isDay0Exist) {
                return back()->withErrors(['day' => 'Tidak dapat mengubah hari menjadi selain 0 karena tidak ada kondisi dengan hari 0'])->withInput();
            }
        }

        $condition->update([
            'status' => $request->status,
            'value' => $request->value,
            'treatment' => $request->treatment,
            'is_after' => $request->is_after,
            'day' => $request->day ?? 0,
        ]);

        if (!$condition) {
            return back()->withErrors(['error' => 'Something went wrong'])->withInput();
        }

        return redirect()->route('admin.pest-diseases.show', $condition->pest_disease_id)->with('success', 'Data updated successfully');
    }

    public function create($pestDiseaseId)
    {
        $title = 'Tambah Kondisi';

        $codePestDisease = PestDisease::findOrFail($pestDiseaseId)->code;
        $codePestDisease = substr($codePestDisease, 1);

        $newCode = 'C' . $codePestDisease . '-' . (Condition::where('pest_disease_id', $pestDiseaseId)->count() + 1);

        $isAfterOptions = Condition::where('pest_disease_id', $pestDiseaseId)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->value,
                ];
            });

        return view('pages._Main.ExpertSystem.PestDisease.Condition.add', compact('title', 'newCode', 'isAfterOptions', 'pestDiseaseId'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'pest_disease_id' => ['required', Rule::exists('pest_diseases', 'id')->where(function ($query) use ($request) {
                $query->where('id', $request->pest_disease_id);
                $query->whereNull('deleted_at');
            })],
            'code' => ['required', Rule::unique('conditions', 'code')->whereNull('deleted_at')],
            'status' => 'required|in:IMPROVED,WORSENED,HEALED,DIED',
            'value' => 'required|string',
            'treatment' => 'required|array|min:1',
            'treatment.*' => 'required|distinct|string',
            'is_after' => ['nullable', 'integer', Rule::exists('conditions', 'id')->where(function ($query) use ($request) {
                $query->where('pest_disease_id', $request->pest_disease_id);
            })],
            'day' => 'nullable|integer',
        ], [
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status harus salah satu dari: IMPROVED, WORSENED, HEALED, DIED',
            'value.required' => 'Kondisi harus diisi',
            'value.string' => 'Kondisi harus berupa string',
            'treatment.required' => 'Penanganan harus diisi',
            'treatment.array' => 'Penanganan harus berupa array',
            'treatment.min' => 'Penanganan minimal 1',
            'treatment.*.required' => 'Penanganan harus diisi',
            'treatment.*.distinct' => 'Penanganan tidak boleh sama',
            'treatment.*.string' => 'Penanganan harus berupa string',
            'is_after.integer' => 'Tampil setelah harus berupa angka',
            'is_after.exists' => 'Kondisi tidak ditemukan',
            'day.integer' => 'Hari harus berupa angka',
        ]);

        $condition = Condition::create([
            'pest_disease_id' => $request->pest_disease_id,
            'code' => $request->code,
            'status' => $request->status,
            'value' => $request->value,
            'treatment' => $request->treatment,
            'is_after' => $request->is_after,
            'day' => $request->day ?? 0,
        ]);

        if (!$condition) {
            return back()->withErrors(['error' => 'Something went wrong'])->withInput();
        }
        return redirect()->route('admin.pest-diseases.show', $request->pest_disease_id)->with('success', 'Data created successfully');
    }

    public function destroy($id)
    {
        $condition = Condition::findOrFail($id);
        $condition->delete();

        return responseJson('success', 'Berhasil menghapus data kondisi');
    }
}
