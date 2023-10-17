<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
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

    public function index(Request $req)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
            $dosen = Dosen::query();
            $search = $req->input('search');
            $sort = $req->input('sort');

            if($search) {
                $dosen->where(function ($q) use ($search) {
                    $q->where('nim', 'like', '%' . $search . '%')
                        ->orWhere('nama', 'like', '%' . $search . '%')
                        ->orWhere('kontak', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
            
            if ($dosen->count() == 0) {
                $response = ['message' => 'Data not found'];
                return response()->json($response, 204);
            }
            if ($sort != 'desc') {
                $dosen = $dosen->orderBy('nama', 'asc'); 
            } else {
                $dosen = $dosen->orderBy('nama', 'desc'); 
            } 
            $dosen = $dosen->paginate(10);

            $response = [
                'message' => "Data Dosen Successfully Retrieved",
                "data" => $dosen
            ];
            return response()-> json($response, 200);
    }

    public function store(Request $request)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
            $validator = Validator::make($request->all(), [
                'nim' => 'required|unique:dosen,nim',
                'nama' => 'required|string|max:100',
                'kontak' => 'required|numeric',
                'email' => 'required|email|unique:dosen,email'
            ]);
        
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $nim = $request->input('nim');
            $nama = $request->input('nama');
            $kontak = $request->input('kontak');
            $email = $request->input('email');
    
            $dosen = new Dosen;
            $dosen->nim = $nim;
            $dosen->nama = $nama;
            $dosen->kontak = $kontak;
            $dosen->email = $email;
        
            if (!$dosen->save()) {
                return response()->json(['error' => 'Failed to save Dosen, Database Server Problem'], 500);
            }
            $response = [
                'message' => 'Data Dosen Successfully Created',
                'data' => [
                    "nim" => $nim,
                    "nama" => $nama,
                    "kontak" => $kontak,
                    "email" => $email,
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
            
            $dosen = Dosen::find($id);

            if ($dosen == null) {
                $response = [
                    'error' => "Data Dosen Not Found",
                ];
                return response()->json($response, 404);
            }

            $response = [
                'message' => "Data Dosen Retrieved Successfully",
                'data' => $dosen
            ];
            return response()->json($response, 200);

    }


    public function update(Request $request, string $id)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
        if ($request->isMethod('put')) {
            $validator = Validator::make($request->all(), [
                'nim' => 'required|numeric|unique:dosen,nim',
                'nama' => 'required|string|max:100',
                'kontak' => 'required|numeric',
                'email' => 'required|email|unique:dosen,email',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

        } elseif ($request->isMethod('patch')) {
            $validator = Validator::make($request->all(), [
                'nim' => 'sometimes|required|unique:dosen,nim,' . $id,
                'nama' => 'sometimes|required|string|max:100',
                'kontak' => 'sometimes|required|numeric',
                'email' => 'sometimes|required|email|unique:dosen,email,' . $id,
            ]);
            
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }
            
        }

        $dosen = Dosen::find($id);

        if ($dosen == null) {
            $response = [
                'error' => "Data Dosen Not Found",
            ];
            return response()->json($response, 404);
        }

        $dosen->update($request->all());
        $response = [
            'message' => "Data Dosen Successfully Update",
            "data" => $dosen
        ];
        return response()->json($response, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
        $dosen = Dosen::find($id);
        $dosenData = $dosen;
        if (!$dosen) {
            $response = [
                "error" => "Not Found Data",
                "nim" => $id
            ];
            return response()->json($response, 404);
        }
        $checkDelete = $dosen->delete();
        if ($checkDelete) {
            return response()->json([
                "message" => "Data Dosen Successfully Delete"
            ], 204);
        } else {
            $response = [
                "error" => "Data Cannot Delete"
            ];
            return response()->json($response, 400); 
        }
    }
}

