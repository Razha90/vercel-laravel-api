<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\DosenPembimbing;
use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DosenPembimbingController extends Controller
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

    public function show(string $id) {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
        $dosen = DosenPembimbing::find($id);

        if ($dosen == null) {
            $response = [
                'error' => "Data Not Found",
            ];
            return response()->json($response, 404);
        }

        $dosenData = Dosen::find($dosen->id_dosen);
        $mahasiswa = mahasiswa::find($dosen->id_mahasiswa);
        $dosen->dosen = $dosenData;
        $dosen->mahasiswa = $mahasiswa;
        // $dosen->load('mahasiswa');
        $response = [
            "message" => "Data Successfully Retrieved",
            "data" => $dosen
        ];
        return response()->json($response, 200);

    }

    public function index(Request $request)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
        $query = Dosen::select(['dosen.nim', 'dosen.nama', 'dosen.kontak', 'dosen.email', 'mahasiswa.nama'])->leftJoin('mahasiswa', 'mahasiswa.nim', '=', 'dosen.nim');
        if ($query->count() == 0) {
            $response = [
                'error' => "Data Dosen Not Found",
            ];
            return response()->json($response, 404);
        }
        
        $search = $request->input('search');
        $sort = $request->input('sort');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('dosen.nim', 'like', "%$search%")
                    ->orWhere('dosen.nama', 'like', "%$search%")
                    ->orWhere('dosen.kontak', 'like', "%$search%")
                    ->orWhere('dosen.email', 'like', "%$search%");
            });
        }
        if ($sort != 'desc') {
            $query = $query->orderBy('dosen.nama', 'asc'); 
        } else {
            $query = $query->orderBy('dosen.nama', 'desc'); 
        }

        $query->with('mahasiswa');
        $query = $query->paginate(10);
        $response = [
            "message" => "Data Successfully Retrieved",
            "data" => $query
        ];
        return response()->json($response, 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
        $validator = Validator::make($request->all(),[
            "id_dosen" => "required|exists:dosen,nim",
            "id_mahasiswa" => "required|exists:mahasiswa,nim"
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $id_dosen = $request->input('id_dosen');
        $id_mahasiswa = $request->input('id_mahasiswa');

        $dosenPembimbing = new DosenPembimbing;
        $dosenPembimbing->id_dosen = $id_dosen;
        $dosenPembimbing->id_mahasiswa = $id_mahasiswa;

        if (!$dosenPembimbing->save()) {
            return response()->json(['error' => 'Failed to save, Database Server Problem'], 500);
        };
        $dosen = Dosen::find($id_dosen);
        $mahasiswa = mahasiswa::find($id_mahasiswa);

        $response = [
            'message' => 'Data Dosen Successfully Created',
            'data' => [
                "id_dosen" => $dosen->nama,
                "id_mahasiswa" => $mahasiswa->nama
            ]
        ];
        return response()->json($response, 201);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
        $validator = Validator::make($request->all(),[
            "id_dosen" => "required|exists:dosen,nim",
            "id_mahasiswa" => "required|exists:mahasiswa,nim"
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        $dosenPembimbing = DosenPembimbing::find($id);
        if ($dosenPembimbing == null) {
            return response()->json(['error'=>'Cannot Find Id'], 404);
        }
        $dosenPembimbing->update($request->all());
        $id_dosen = $request->input('id_dosen');
        $id_mahasiswa = $request->input('id_mahasiswa');

        $dosen = Dosen::find($id_dosen);
        $mahasiswa = mahasiswa::find($id_mahasiswa);
        $response = [
            'message' => 'Data Dosen Successfully Update',
            'data' => [
                "id_dosen" => $dosen->nama,
                "id_mahasiswa" => $mahasiswa->nama
            ]
        ];
        return response()->json($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
        $dosenPembimbing = DosenPembimbing::where('id',$id);
        if (!$dosenPembimbing->delete()) {
            return response()->json(['error'=>'Delete is Failed'], 404);
        }

        return response()->json(["message"=>"Successfully"], 200);
    }
}
