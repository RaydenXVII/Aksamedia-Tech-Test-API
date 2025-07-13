<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('division');

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('division_id')) {
            $query->where('division_id', $request->division_id);
        }

        $employees = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil diambil',
            'data' => [
                'employees' => collect($employees->items())->map(function ($employee) {
                    return [
                        'id' => $employee->id,
                        'image' => $employee->image ? Storage::url($employee->image) : null,
                        'name' => $employee->name,
                        'position' => $employee->position,
                        'division_id' => $employee->division->id,
                        'division_name' => $employee->division->name,
                    ];
                }),
            ],
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'division' => 'required|exists:divisions,id',
            'position' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $filename = null;
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->store('employee_images', 'public');
        }

        $employee = Employee::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'phone' => $request->phone,
            'position' => $request->position,
            'division_id' => $request->division,
            'image' => $filename,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data pegawai berhasil ditambahkan',
        ]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'division' => 'required|exists:divisions,id',
            'position' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            if ($employee->image && Storage::disk('public')->exists($employee->image)) {
                Storage::disk('public')->delete($employee->image);
            }

            $filename = $request->file('image')->store('employee_images', 'public');
            $employee->image = $filename;
        }

        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->division_id = $request->division;
        $employee->position = $request->position;
        $employee->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pegawai berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pegawai tidak ditemukan'
            ], 404);
        }

        if ($employee->image && Storage::disk('public')->exists($employee->image)) {
            Storage::disk('public')->delete($employee->image);
        }

        $employee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pegawai berhasil dihapus'
        ]);
    }
}
