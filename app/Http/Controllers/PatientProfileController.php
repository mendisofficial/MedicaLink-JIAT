<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientProfileController extends Controller
{
    public function index(){
        $patient = auth()->guard('patient')->user();

        return view('patient.dashboard', compact('patient'));
    }

    public function showSearchPage() {
        $patient = auth()->guard('patient')->user();

        return view('patient.search', compact('patient'));
    }

    // Handles all patient vaccinations related GET data operations for javascript requests
    public function handleVaccinationData(Request $request){
        // validate request data
        $validatedData = $request->validate([
            'id' => 'required|int'
        ]);

        // Id if the patient
        $id = $validatedData['id'];

        $vaccinations = Vaccination::where('patient_id', $id)->with('hospital', 'vaccineName.vaccineBrand')->get();

        return response()->json($vaccinations);
    }

    // Handles all patient medical report related GET data operations for javascript requests
    public function handleReportData(Request $request){

        // Get the user object from the session
        $patient = auth()->guard('patient')->user();

        $reportData = MedicalRecord::where('patient_id', $patient->id)->with('hospital')->get();

        return response()->json($reportData);
    }

    // Handles patient vaccination search for javascript requests
    public function searchVaccinationData(Request $request){

        // validate request data
        $validatedData = $request->validate([
            'query' => 'nullable|string|max:255',
            'type' => 'nullable|string'
        ]);

        $patient = auth()->guard('patient')->user();

        // Id of the patient
        $id = $patient->id;
        $searchQuery = $validatedData['query'] ?? '';
        $type = $validatedData['type'] ?? 'title';

        //$vaccinations = Vaccination::where('patient_id', $id)->get();
        if($type == 'title'){

            $vaccinations = Vaccination::where('patient_id', $id)
            ->whereHas('vaccineName', function ($query) use($searchQuery){

                $query->whereHas('vaccineBrand', function ($query) use($searchQuery){

                    $query->where('brand_name','like', '%'. $searchQuery. '%');
                });
            })
            ->with('hospital','vaccineName.vaccineBrand',)->get();
        }
        else if($type == 'location'){

            $vaccinations = Vaccination::where('patient_id', $id)
            ->whereHas('hospital', function ($query) use($searchQuery){

                $query->where('name','like', '%'.$searchQuery.'%');
            })
            ->with('hospital', 'vaccineName.vaccineBrand')->get();
        }
        else{

            $vaccinations = Vaccination::where('patient_id', $id)
            ->where(function ($query) use($searchQuery){

                $query->whereHas('vaccineName', function ($query) use($searchQuery){

                    $query->whereHas('vaccineBrand', function ($query) use($searchQuery){

                        $query->where('brand_name','like', '%'. $searchQuery. '%');
                    });
                })
                ->orWhereHas('hospital', function ($query) use($searchQuery){

                    $query->where('name','like', '%'.$searchQuery.'%');
                });
            })
            ->with('hospital','vaccineName.vaccineBrand')->get();
        }

        return response()->json($vaccinations);
    }

    // Handles patient medical report search for javascript requests
    public function searchReportData(Request $request){

        // validate request
        $validatedData = $request->validate([
            'query' => 'nullable|string',
            'type' => 'nullable|string'
        ]);

        $patient = auth()->guard('patient')->user();

        $id = $patient->id;
        $searchQuery = $validatedData['query'];
        $type = $validatedData['type'] ?? 'title';

        if($type == 'title'){
            $reportData = MedicalRecord::where('patient_id', $id)
            ->where('record_type', 'like', '%'.$searchQuery.'%')
            ->with('hospital')->get();
        }
        else if($type == 'location'){

            $reportData = MedicalRecord::where('patient_id', $id)
            ->whereHas('hospital', function ($query) use($searchQuery){

                $query->where('name', 'like', '%'.$searchQuery.'%');
            })
            ->with('hospital')->get();
        }
        else{

            $reportData = MedicalRecord::where('patient_id', $id)
            ->where(function ($query) use($searchQuery){

                $query->where('record_type', 'like', '%'.$searchQuery.'%')
                ->orWhereHas('hospital', function ($query) use($searchQuery){

                    $query->where('name', 'like', '%'.$searchQuery.'%');
                });
            })
            ->with('hospital')->get();
        }

        return response()->json($reportData);
    }
}
