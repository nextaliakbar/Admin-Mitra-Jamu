<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use App\Models\PestDisease;
use App\Models\Symptoms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule as ValidationRule;

class RuleController extends Controller
{
    public $title;

    public function __construct()
    {
        $this->title = Lang::get('translation.Expert_System_RuleBase');
    }

    public function index()
    {
        $title = $this->title;

        $rules = DB::table('rules')
            ->whereNull('rules.deleted_at')
            ->join('pest_diseases', 'rules.pest_disease_id', '=', 'pest_diseases.id')
            ->whereNull('pest_diseases.deleted_at')
            ->select('rules.id', 'rules.code', 'pest_diseases.label as pest_disease_label', 'pest_diseases.code as pest_disease_code')
            ->get();

        $rules->map(function ($item) {
            $item->pest_disease = [
                'label' => $item->pest_disease_label,
                'code' => $item->pest_disease_code,
            ];
            return $item;
        });

        foreach ($rules as $rule) {
            $symptoms = DB::table('rule_symptoms')
                ->whereNull('symptoms.deleted_at')
                ->join('symptoms', 'rule_symptoms.symptoms_id', '=', 'symptoms.id')
                ->where('rule_symptoms.rule_id', $rule->id)
                ->select('symptoms.label as symptom_label', 'symptoms.code as symptom_code')
                ->get();

            $symptoms = $symptoms->map(function ($item) {
                return [
                    'label' => $item->symptom_label,
                    'code' => $item->symptom_code,
                ];
            });
            $rule->symptom = $symptoms;
        }

        $rules->map(function ($item) {
            unset($item->pest_disease_label);
            unset($item->pest_disease_code);
            return $item;
        });

        return view('pages._Main.ExpertSystem.Rules.index', compact('rules', 'title'));
    }

    public function create()
    {
        $pestDiseases = PestDisease::whereNotIn('id', Rule::pluck('pest_disease_id'))->orderByRaw('length(code), code')->get();
        $symptoms = Symptoms::orderByRaw('length(code), code')->get();
        $title = 'Tambah Rule';

        if (Rule::count() == 0) {
            $newCode = 'R1';
        } else {
            $newCode = Rule::orderByRaw('length(code), code')->get()->last()->code;
            $newCode = 'R' . (intval(substr($newCode, 1)) + 1);
        }
        return view('pages._Main.ExpertSystem.Rules.create', compact('pestDiseases', 'symptoms', 'title', 'newCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', ValidationRule::unique('rules', 'code')->whereNull('deleted_at')],
            'pest_disease_id' => ['required', 'exists:pest_diseases,id', ValidationRule::unique('rules', 'pest_disease_id')->whereNull('deleted_at')],
            'symptom_id' => 'required|array|min:1',
            'symptom_id.*' => 'required|distinct|exists:symptoms,id',
        ]);

        $rule = Rule::create([
            'code' => $request->code,
            'pest_disease_id' => $request->pest_disease_id,
        ]);

        if (!$rule) return redirect()->back()->with('error', 'Rule failed to create')->withInput($request->all());

        foreach ($request->symptom_id as $symptom_id) {
            $rule->symptoms()->attach($symptom_id);
        }

        return redirect()->route('admin.rules.index')->with('success', 'Rule created successfully');
    }

    public function edit(Rule $rule)
    {
        $pestDiseases = PestDisease::whereNotIn('id', Rule::pluck('pest_disease_id'))
            ->orWhere('id', $rule->pest_disease_id)
            ->orderByRaw('length(code), code')->get();
        $symptoms = Symptoms::orderByRaw('length(code), code')->get();
        $title = 'Edit Rule ' . $rule->code;

        $selectedSymptoms = $rule->symptoms->pluck('id')->toArray();

        return view('pages._Main.ExpertSystem.Rules.edit', compact('rule', 'pestDiseases', 'symptoms', 'title', 'selectedSymptoms'));
    }

    public function update(Request $request, Rule $rule)
    {
        try {
            $request->validate([
                'code' => 'required',
                'pest_disease_id' => 'required',
            ]);

            $rule->update([
                'code' => $request->code,
                'pest_disease_id' => $request->pest_disease_id,
            ]);

            $rule->symptoms()->sync($request->symptom_id);

            return redirect()->route('admin.rules.index')->with('success', 'Rule updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Rule failed to update')->withInput($request->all());
        }
    }

    public function destroy(Rule $rule)
    {
        try {
            $rule->delete();
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

    public function history()
    {
        $title = 'History Diagnosis';
        $diagnose = DB::table('diagnoses')
            ->join('customers', 'diagnoses.customer_id', '=', 'customers.id')
            ->join('pest_diseases', 'diagnoses.pest_disease_id', '=', 'pest_diseases.id')
            ->select('diagnoses.history', 'diagnoses.created_at', 'diagnoses.updated_at', 'customers.name as customer_name', 'pest_diseases.label as pest_disease_label')
            ->get();

        $diagnose->map(function ($item) {
            $item->history = json_decode($item->history);
            return $item;
        });
        return view('pages._Main.ExpertSystem.Rules.history', compact('title', 'diagnose'));
    }
}
