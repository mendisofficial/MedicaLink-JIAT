<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Vaccination;
use App\Models\VaccineBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    protected static ?string $password;

    // Admin dashboard
    public function dashboard()
    {
        // Get the total number of patients in the system
        $totalPatients = Patient::count();

        // Get the admin's hospital ID (assuming you have a method to get the current admin's hospital)
        $adminHospitalId = auth()->user()->hospital_id;

        // Get the total number of patients from the admin's hospital
        $hospitalPatients = Patient::where('registered_by', $adminHospitalId)->count();

        // Get the total number of patients from the admin's hospital this month
        $hospitalPatientsThisMonth = Patient::where('registered_by', $adminHospitalId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get the last 5 newly created accounts from the admin's hospital
        $newAccounts = Patient::where('registered_by', $adminHospitalId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get the last 10 recent updates on medical records and vaccinations from the admin's hospital
        $medicalRecords = MedicalRecord::where('hospital_id', $adminHospitalId)
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        $vaccinations = Vaccination::where('hospital_id', $adminHospitalId)
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        // Merge and sort the collections
        $recentUpdates = $medicalRecords->merge($vaccinations)->sortByDesc('updated_at')->take(10);

        return view('admin.dashboard', compact('totalPatients', 'hospitalPatients', 'hospitalPatientsThisMonth', 'newAccounts', 'recentUpdates'));
    }

    // All patients search with nic as default
    public function searchPatientForm(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'query' => 'nullable|string|max:255',
            'type' => 'nullable|string'
        ]);

        // If no query parameter is provided, display all patients
        if (!$request->filled('query')) {
            $patients = Patient::with('hospital')->get();
            $searchQuery = '';
            $type = 'nic';
        } else {
            // Get the search query and type
            $searchQuery = $validatedData['query'];
            $type = $validatedData['type'] ?? 'nic';

            // Perform the search based on the type
            if ($type == 'hospital') {
                // If the user searches by hospital
                $patients = Patient::whereHas('hospital', function ($query) use ($searchQuery) {
                    $query->where('name', 'like', '%' . $searchQuery . '%');
                })->with('hospital')->get();
            } else {
                // Default search by NIC or other types like name
                $patients = Patient::where($type, 'like', '%' . $searchQuery . '%')->with('hospital')->get();
            }
        }

        // Return the view with the search results
        return view('admin.search_patient', [
            'patients' => $patients,
            'query' => $searchQuery,
            'type' => $type
        ]);
    }

    // Show the patient profile
    public function showPatientProfile($id)
    {
        $patient = Patient::with('hospital')->findOrFail($id);

        // Calculate and add the age attribute
        $patient->age = Carbon::parse($patient->date_of_birth)->age;

        return view('admin.profile_overview',compact('patient'));
    }

    // Show the patient profile reports (vaccinations and medical records)
    public function showPatientProfileReports($id)
    {
        $patient = Patient::findOrFail($id);
        return view('admin.profile_reports', compact('id', 'patient'));
    }

    public function showAddPatientForm()
    {
        return view('admin.add_patient');
    }

    public function storePatient(Request $request)
    {
        $validatedData = $request->validate([
            'nic' => 'required|string|max:255|unique:patients',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'gender' => 'required|string',
            'blood_group' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'contact_number' => 'required|string|max:15',
            'file' => 'nullable|file|mimes:jpg,png|max:2048'
        ]);

        $url = ''; // Url of the attachment
        if ($request->hasFile('file') && $request->file('file')->isValid()){
            $path = $request->file('file')->store('uploads/patient', 'public'); // 'uploads' is the directory, 'public' is the disk
            $url = Storage::url($path);
        }

        $password = Str::random(10); // Generate a random password

        $patient = Patient::create([
            'nic' => $validatedData['nic'],
            'name' => $validatedData['name'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'address' => $validatedData['address'],
            'gender' => $validatedData['gender'],
            'blood_group' => $validatedData['blood_group'],
            'height' => $validatedData['height'],
            'weight' => $validatedData['weight'],
            'contact_number' => $validatedData['contact_number'],
            'password' => Hash::make($password),
            'profile_photo_path' => $url,
            'registered_by' => auth()->user()->hospital_id,
        ]);

        return redirect()->route('admin.addPatientForm')->with('success', 'Patient registered successfully! NIC: '.$patient->nic.' Password: '.$password);
    }

    public function showManagePatients(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'query' => 'nullable|string|max:255',
            'type' => 'nullable|string'
        ]);

        //Get the hospital id of the current user object
        $hospitalId = auth()->guard('admin')->user()->hospital_id;

        //If none of the parameters are provided
        if(!$request->filled(['query'])){
            $patients = Patient::where('registered_by',$hospitalId)->with('hospital')->get();
        }else
        {
            $searchQuery = $validatedData['query'];
            $type = $validatedData['type'] ?? 'name';

            if($type == 'hospital'){
                // If the user searches by the hospital
                $patients = Patient::where('registered_by',$hospitalId)->whereHas('hospital', function ($query) use ($searchQuery) {
                    $query->where('name', 'like', '%' . $searchQuery . '%');

                })->with('hospital')->get();
            }
            else{
                $patients = Patient::where('registered_by',$hospitalId)->where($type,'like','%'.$searchQuery.'%')->with('hospital')->get();
            }
        }

        $patients = ($patients !== null)? $patients : [];

        return view('admin.manage_patient',
        ['patients' => $patients, 'query' => $searchQuery ?? '', 'type' => $type ?? 'name']);
    }

    public function searchPatient(Request $request)
    {
        // Validate the request
        $request->validate([
            'nic' => 'required|string|max:255',
        ]);

        // Get the NIC from the request
        $nic = $request->input('nic');

        // Perform your search logic here
        $patient = Patient::where('nic', $nic)->first();

        // Check if patient is found
        if ($patient) {
            // Return view with patient data
            return view('admin.search_patient', compact('patient'));
        } else {
            // Handle the case where no patient is found
            return redirect()->back()->with('error', 'Patient not found.');
        }
    }

    // Handles all patient vaccinations related GET data operations for javascript requests
    public function handlePatientVaccinationData(Request $request){

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
    public function handlePatienReportData(Request $request){

        // Handle
        $validatedData = $request->validate([
            'id' => 'required|int'
        ]);

        $id = $validatedData['id'];

        $reportData = MedicalRecord::where('patient_id', $id)->with('hospital')->get();

        return response()->json($reportData);
    }

    public function destroyPatient($id){
        $patient = Patient::find($id);

        if (!$patient) {
            return redirect()->route('admin.managePatients')->with('error', 'Patient not found');
        }

        // Delete related medical records first
        $patient->medicalRecords()->delete();
        $patient->vaccinations()->delete();

        $patient->delete();

        return redirect()->route('admin.managePatients')->with('success', 'Patient deleted successfully');
    }

    // Handles patient vaccination search for javascript requests
    public function searchPatientVaccinationData(Request $request){

        // validate request data
        $validatedData = $request->validate([
            'id' => 'required|int',
            'query' => 'nullable|string|max:255',
            'type' => 'nullable|string'
        ]);

        // Id of the patient
        $id = $validatedData['id'];
        $searchQuery = $validatedData['query'] ?? '';
        $type = $validatedData['type'] ?? 'title';

        if($type == 'title'){

            $vaccinations = Vaccination::where('patient_id', $id)
                ->whereHas('vaccineName', function ($query) use($searchQuery){

                    $query->whereHas('vaccineBrand', function ($query) use($searchQuery){
                        $query->where('brand_name','like', '%'.$searchQuery.'%');
                    });
            })
            ->with('hospital','vaccineName.vaccineBrand')->get();
        }
        else if($type == 'location'){

            $vaccinations = Vaccination::where('patient_id', $id)
            ->whereHas('hospital', function ($query) use($searchQuery){

                $query->where('name','like', '%'.$searchQuery.'%');
            })
            ->with('hospital','vaccineName.vaccineBrand')->get();
        }
        else{
            $vaccinations = Vaccination::where('patient_id', $id)
            ->where(function ($query) use($searchQuery){

                $query->whereHas('vaccineName', function ($query) use($searchQuery){

                    $query->whereHas('vaccineBrand', function ($query) use($searchQuery){
                        $query->where('brand_name','like', '%'.$searchQuery.'%');
                    });
                })
                ->orWhereHas('hospital', function ($query) use($searchQuery){

                    $query->where('name','like', '%'.$searchQuery.'%');
                });
            })
            ->with('hospital','vaccineName.vaccineBrand')->get();
        }

        //Get the hospital id of the current user object
        $hospitalId = auth()->guard('admin')->user()->hospital_id;

        foreach ( $vaccinations as $vaccination ){
            $vaccination->isEditable = ($vaccination->hospital_id == $hospitalId);
        }

        return response()->json($vaccinations);
    }

    // Handles patient medical report search for javascript requests
    public function searchPatienReportData(Request $request){

        // Handle
        $validatedData = $request->validate([
            'id' => 'required|int',
            'query' => 'nullable|string',
            'type' => 'nullable|string'
        ]);

        $id = $validatedData['id'];
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

        //Get the hospital id of the current user object
        $hospitalId = auth()->guard('admin')->user()->hospital_id;

        foreach ( $reportData as $rData ){
            $rData->isEditable = ($rData->hospital_id == $hospitalId);
        }

        return response()->json($reportData);
    }

    public function getVaccineBrands()
    {
        $vaccineBrands = VaccineBrand::with('vaccineNames')->get();
        return response()->json($vaccineBrands);
    }

    // Update a vaccination record
    public function updateVaccination(Request $request)
    {

        $request->validate([
            'vaccination_id' => 'required|string',
            'vaccine_id' => 'required|int',
            'date_administered' => 'required|date',
            'dose' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $vaccination = Vaccination::findOrFail($request->input('vaccination_id'));
        $vaccination->vaccine_id = $request->input('vaccine_id');
        $vaccination->date_administered = $request->input('date_administered');
        $vaccination->dose = $request->input('dose');
        $vaccination->description = $request->input('description');
        $vaccination->save();

        return response()->json(['success' => true, 'message' => 'Vaccination updated successfully']);
    }

    // Insert a vaccination record
    public function insertVaccination(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|int',
            'vaccine_id' => 'required|int',
            'date_administered' => 'required|date',
            'dose' => 'required|string',
            'description' => 'nullable|string',
        ]);

        //Get the hospital id of the current user object
        $hospitalId = auth()->guard('admin')->user()->hospital_id;

        $vaccination = Vaccination::create([
            'patient_id' => $request->input('patient_id'),
            'hospital_id' => $hospitalId,
            'vaccine_id' => $request->input('vaccine_id'),
            'date_administered' => $request->input('date_administered'),
            'dose' => $request->input('dose'),
            'description' => $request->input('description')
        ]);

        if(! $vaccination){
            return response()->json(['success' => false, 'message' => 'Insertion faliure'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Vaccination inserted successfully']);
    }

    // Insert a Medical record
    public function insertMedicalRecord(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|int',
            'record_type' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048'
        ]);

        //Get the hospital id of the current user object
        $hospitalId = auth()->guard('admin')->user()->hospital_id;

        $url = ''; // Url of the attachment
        if ($request->hasFile('file') && $request->file('file')->isValid()){
            $path = $request->file('file')->store('uploads/medicalRecords', 'public'); // 'uploads' is the directory, 'public' is the disk
            $url = Storage::url($path);
        }

        $medicalRecord = MedicalRecord::create([
            'patient_id' => $request->input('patient_id'),
            'hospital_id' => $hospitalId,
            'record_type' => $request->input('record_type'),
            'description' => $request->input('description'),
            'file_path' => $url
        ]);

        if(! $medicalRecord){
            return response()->json(['success' => false, 'message' => 'Insertion faliure'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Medical Record inserted successfully']);
    }

    // Insert a Medical record
    public function updateMedicalRecord(Request $request)
    {
        $request->validate([
            'record_id' => 'required|int',
            'record_type' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx'
        ]);

        // Find and update the record
        $medicalRecord = MedicalRecord::findOrFail($request->input('record_id'));

        $url = ''; // Url of the attachment
        if ($request->hasFile('file') && $request->file('file')->isValid()){
            $path = $request->file('file')->store('uploads/medicalRecords', 'public'); // 'uploads' is the directory, 'public' is the disk
            $url = Storage::url($path);
        }

        $medicalRecord->record_type = $request->input('record_type');
        $medicalRecord->description = $request->input('description');
        $medicalRecord->file_path = $url;
        $medicalRecord->save();

        if(! $medicalRecord){
            return response()->json(['success' => false, 'message' => 'Update faliure'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Medical Record Updated successfully']);
    }

}
