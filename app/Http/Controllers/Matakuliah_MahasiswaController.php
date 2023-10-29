<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use App\Models\Matakuliah;
use App\Models\Matakuliah_Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Matakuliah_MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected function Database() {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function show(string $id)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
        $matakuliah = Matakuliah_Mahasiswa::find($id);

        if ($matakuliah == null) {
            $response = [
                'error' => "Data Not Found",
            ];
            return response()->json($response, 404);
        }

        $matakuliahData = Matakuliah::find($matakuliah->id_matakuliah);
        $mahasiswa = mahasiswa::find($matakuliah->id_mahasiswa);
        $matakuliah->matakuliah = $matakuliahData;
        $matakuliah->mahasiswa = $mahasiswa;
        // $dosen->load('mahasiswa');
        $response = [
            "message" => "Data Successfully Retrieved",
            "data" => $matakuliah
        ];
        return response()->json($response, 200);

    }
    public function index(Request $request)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
        $query = Matakuliah::select(['matakuliah.kode', 'matakuliah.nama_matakuliah', 'matakuliah.daya_tampung', 'matakuliah.jadwal']);
        if ($query->count() == 0) {
            $response = [
                'error' => "Data Matakuliah Not Found",
            ];
            return response()->json($response, 404);
        }
        
        $search = $request->input('search');
        $sort = $request->input('sort');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('matakuliah.kode', 'like', "%$search%")
                    ->orWhere('matakuliah.nama_matakuliah', 'like', "%$search%");
            });
        }
        if ($sort != 'desc') {
            $query = $query->orderBy('matakuliah.nama_matakuliah', 'asc'); 
        } else {
            $query = $query->orderBy('matakuliah.nama_matakuliah', 'desc'); 
        }

        $query->with('mahasiswa');
        $query = $query->paginate(10);
        $response = [
            "message" => "Data Successfully Retrieved",
            "data" => $query
        ];
        return response()->json($response, 200);

    }
    // {
    //     if (!$this->Database()) {
    //         return response()->json(['message' => 'Failed to connect to the database'], 500);
    //     }

    //     $matakuliah = Matakuliah::with('mahasiswa')->get();
    //     return $matakuliah;
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }

        $validator = Validator::make($request->all(), [
            'id_mahasiswa' => 'required|numeric|exists:mahasiswa,nim',
            'id_matakuliah'=>'required|numeric|exists:matakuliah,kode'

        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $kelas = new Matakuliah_Mahasiswa;
        $id_mahasiswa = $request->input('id_mahasiswa');
        $id_matakuliah = $request->input('id_matakuliah');

        $kelas->id_matakuliah = $id_matakuliah;
        $kelas->id_mahasiswa = $id_mahasiswa;

        if (!$kelas->save()) {
            return response()->json(['error'=>'Cant Saved Data'], 404);
        }

        $response = [
            'message' => "Successfully Save Data",
            "data" => [
                "id_mahasiswa" => $id_mahasiswa,
                "id_matakuliah" => $id_mahasiswa 
            ]
        ];

        return response()->json($response, 201);
    }

    public function update(Request $request, string $id)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }

        $validator = Validator::make($request->all(), [
            'id_mahasiswa' => 'required|numeric|exists:mahasiswa,nim',
            'id_matakuliah'=>'required|numeric|exists:matakuliah,kode'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        
        $kelas = Matakuliah_Mahasiswa::find($id);
        if ($kelas == null) {
            return response()->json(['error'=>'Data Not Found'], 404);
        }

        if (!$kelas->update($request->all())) {
            return response() -> json(['error' => "Error update Data"], 500);
        }

        $mahasiswa = mahasiswa::find($request->input('id_mahasiswa'));
        $matakuliah = Matakuliah::find($request->input('id_matakuliah'));

        $response = [
            'message'=>'Data Successfully Update',
            'data' => [
                'id_mahasiswa' => $mahasiswa->nama,
                "id_matakuliah" => $matakuliah->nama_matakuliah
            ]
        ];

        return response()->json($response, 200);
    }

    public function destroy(string $id)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }

        $kelas = Matakuliah_Mahasiswa::find($id);
        if ($kelas == null) {
            return response()->json(['error'=>'Not Found Data'], 404);
        }

        if(!$kelas->delete()) {
            return response()->json(['error'=>'Server Error'], 500);
        }

        return response()->json(['message'=>'Data Successfully Delete'], 200);
        
    }
}
