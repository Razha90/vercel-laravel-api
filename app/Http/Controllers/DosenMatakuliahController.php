<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\DosenMatakuliah;
use App\Models\mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DosenMatakuliahController extends Controller
{

    protected function Database() {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function index(Request $request)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }

        $query = Dosen::select(['dosen.nim', 'dosen.nama', 'dosen.kontak', 'dosen.email', 'matakuliah.nama_matakuliah'])->leftJoin('matakuliah', 'matakuliah.kode', '=', 'dosen.nim');
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

        $query->with('matakuliah');
        $query = $query->paginate(10);
        $response = [
            "message" => "Data Successfully Retrieved",
            "data" => $query
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'id' => "required|unique:dosen_matakuliah,id",
            "id_dosen" => "required|exists:dosen,nim",
            "id_matakuliah" => "required|exists:matakuliah,kode"
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $kode = $request->input('id');
        $id_dosen = $request->input('id_dosen');
        $id_matakuliah = $request->input('id_matakuliah');

        $dosenPembimbing = new DosenMatakuliah;
        $dosenPembimbing->id = $kode;
        $dosenPembimbing->id_dosen = $id_dosen;
        $dosenPembimbing->id_matakuliah = $id_matakuliah;

        if (!$dosenPembimbing->save()) {
            return response()->json(['error' => 'Failed to save, Database Server Problem'], 500);
        };
        $dosen = Dosen::find($id_dosen);
        $matakuliah = Matakuliah::find($id_matakuliah);

        $response = [
            'message' => 'Data Dosen Successfully Created',
            'data' => [
                "id" => $kode,
                "id_dosen" => $dosen->nama,
                "id_matakuliah" => $matakuliah->nama_matakuliah
            ]
        ];
        return response()->json($response, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
        $dosen = DosenMatakuliah::find($id);

        if ($dosen == null) {
            $response = [
                'error' => "Data Not Found",
            ];
            return response()->json($response, 404);
        }
        $dosenData = Dosen::find($dosen->id_dosen);
        $matakuliah = Matakuliah::find($dosen->id_matakuliah);

        $dosen->dosen = $dosenData;
        $dosen->matakuliah = $matakuliah;
        // $dosen->load('matakuliah');
        $response = [
            "message" => "Data Successfully Retrieved",
            "data" => $dosen
        ];
        return response()->json($response, 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
            'id' => "required|unique:dosen_matakuliah,id",
            "id_dosen" => "required|exists:dosen,nim",
            "id_matakuliah" => "required|exists:matakuliah,kode"
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        $dosenMatakuliah = DosenMatakuliah::where('id',$id);
        if ($dosenMatakuliah == null) {
            return response()->json(['error'=>'Cannot Find Id'], 404);
        }
        $dosenMatakuliah->update($request->all());
        $id_dosen = $request->input('id_dosen');
        $id_matakuliah = $request->input('id_matakuliah');

        $dosen = Dosen::find($id_dosen);
        $matakuliah = Matakuliah::find($id_matakuliah);
        $kode = $request->input('id');
        $response = [
            'message' => 'Data Dosen Successfully Update',
            'data' => [
                "id" => $kode,
                "id_dosen" => $dosen->nama,
                "id_matakuliah" => $matakuliah->nama_matakuliah
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
        $dosenMatakuliah = DosenMatakuliah::where('id',$id);
        if (!$dosenMatakuliah->delete()) {
            return response()->json(['error'=>'Delete is Failed'], 404);
        }

        return response()->json(["message"=>"Successfully"], 204);
    }
}
