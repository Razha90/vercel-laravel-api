<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class MahasiswaController extends Controller
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
            $mahasiswa = mahasiswa::query();
            $search = $req->input('search');
            $sort = $req->input('sort');

            if($search) {
                $mahasiswa->where(function ($q) use ($search) {
                    $q->where('nim', 'like', '%' . $search . '%')
                        ->orWhere('nama', 'like', '%' . $search . '%')
                        ->orWhere('kontak', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%');
                });
            }
            if ($mahasiswa->count() == 0) {
                $response = ['message' => 'Data not found'];
                return response()->json($response, 204);
            }
            if ($sort != 'desc') {
                $mahasiswa = $mahasiswa->orderBy('nama', 'asc'); 
            } else {
                $mahasiswa = $mahasiswa->orderBy('nama', 'desc'); 
            }
            $mahasiswa = $mahasiswa->paginate(10);

            $response = [
                'message' => "Data Mahasiswa Successfully Retrieved",
                "data" => $mahasiswa
            ];
            return response()-> json($response, 200);

        
    }

    public function store(Request $request)
    {
        if (!$this->Database()) {
            return response()->json(['message' => 'Failed to connect to the database'], 500);
        }
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:100',
                'kontak' => 'required|numeric',
                'email' => 'required|email|unique:mahasiswa,email',
                'alamat' => 'nullable|string|max:100',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $nama = $request->input('nama');
            $kontak = $request->input('kontak');
            $email = $request->input('email');
            $alamat = $request->input('alamat');
    
            $mahasiswa = new Mahasiswa;
            $mahasiswa->nama = $nama;
            $mahasiswa->kontak = $kontak;
            $mahasiswa->email = $email;
            $mahasiswa->alamat = $alamat;
            if (!$mahasiswa->save()) {
                return response()->json(['error' => 'Failed to save Mahasiswa, Database Server Problem'], 500);
            }
            $response = [
                'message' => 'Data Mahasiswa Successfully Created',
                'data' => [
                    "nama" => $nama,
                    "kontak" => $kontak,
                    "email" => $email,
                    "alamat" => $alamat
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
            
            $mahasiswa = mahasiswa::find($id);

            if ($mahasiswa == null) {
                $response = [
                    'error' => "Data Mahasiswa Not Found",
                ];
                return response()->json($response, 404);
            }

            $response = [
                'message' => "Data Mahasiswa Retrieved Successfully",
                'data' => $mahasiswa
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
                'nama' => 'required|string|max:100',
                'kontak' => 'required|numeric',
                'email' => 'required|email|unique:mahasiswa,email',
                'alamat' => 'required|nullable|string|max:100',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

        } elseif ($request->isMethod('patch')) {
            $validator = Validator::make($request->all(), [
                'nama' => 'sometimes|required|string|max:100',
                'kontak' => 'sometimes|required|numeric',
                'email' => 'sometimes|required|email|unique:mahasiswa,email,' . $id,
                'alamat' => 'sometimes|required|nullable|string|max:100',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }
            
        }

        $mahasiswa = mahasiswa::find($id);

        if ($mahasiswa == null) {
            $response = [
                'error' => "Data Mahasiswa Not Found",
            ];
            return response()->json($response, 404);
        }

        $mahasiswa->update($request->all());
        $response = [
            'message' => "Data Mahasiswa Successfully Update",
            "data" => $mahasiswa
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
        $mahasiswa = mahasiswa::find($id);
        $mahasiswaData = $mahasiswa;
        if (!$mahasiswa) {
            $response = [
                "error" => "Not Found Data",
                "nim" => $id
            ];
            return response()->json($response, 404);
        }
        $checkDelete = $mahasiswa->delete();
        if ($checkDelete) {
            return response()->json([
                "message" => "Data Mahasiswa Successfully Delete"
            ], 200);
        } else {
            $response = [
                "error" => "Data Cannot Delete"
            ];
            return response()->json($response, 400); 
        }
    }
}
