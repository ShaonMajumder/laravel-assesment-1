<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * @OA\Info(
 *     title="Employee Management API",
 *     version="1.0.0",
 *     description="A Laravel-based API for managing employee data. This API supports full CRUD operations for employees, including their details, department management, and security best practices using API key authentication.",
 *     @OA\Contact(
 *         email="smazoomder@gmail.com"
 *     )
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="api_key",
 *     type="apiKey",
 *     in="header",
 *     name="X-API-KEY"
 * )
 */
class EmployeeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/employees",
     *     summary="Get a list of employees with pagination",
     *     description="Returns a paginated list of employees with their details",
     *     operationId="getEmployees",
     *     tags={"Employees"},
     *     @OA\Parameter(
     *         name="paginate",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             default=10
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A paginated list of employees",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array", 
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=5523),
     *                     @OA\Property(property="name", type="string", example="Mrs. Idell Stehr"),
     *                     @OA\Property(property="email", type="string", example="jada.raynor@bayer.org"),
     *                     @OA\Property(property="department_id", type="integer", example=6),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-05T14:43:59.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-05T14:43:59.000000Z"),
     *                     @OA\Property(property="deleted_at", type="string", nullable=true, example=null),
     *                     @OA\Property(property="detail", type="object", nullable=true,
     *                         @OA\Property(property="id", type="integer", example=null),
     *                         @OA\Property(property="employee_id", type="string", example=null),
     *                         @OA\Property(property="designation", type="string", example=null),
     *                         @OA\Property(property="salary", type="number", format="float", example=null),
     *                         @OA\Property(property="address", type="string", example=null),
     *                         @OA\Property(property="joined_date", type="string", format="date", example=null),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example=null),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example=null)
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/employees?page=1"),
     *             @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/api/employees?page=1500"),
     *             @OA\Property(property="next_page_url", type="string", example="http://localhost:8000/api/employees?page=2"),
     *             @OA\Property(property="prev_page_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="to", type="integer", example=10),
     *             @OA\Property(property="total", type="integer", example=15000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid page number or other request issues",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Bad Request")
     *         )
     *     )
     * )
     */
    public function index($paginate=10)
    {
        return response()->json(Employee::with('detail')->paginate($paginate));
    }

    /**
     * @OA\Post(
     *     path="/api/employees",
     *     summary="Create a new employee",
     *     tags={"Employees"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name", "email", "department_id", "designation", "salary", "address", "joined_date"},
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *                 @OA\Property(property="department_id", type="integer", example=1),
     *                 @OA\Property(property="designation", type="string", example="Software Engineer"),
     *                 @OA\Property(property="salary", type="number", format="float", example=7500),
     *                 @OA\Property(property="address", type="string", example="123 Main St, Springfield, IL"),
     *                 @OA\Property(property="joined_date", type="string", format="date", example="2025-05-05")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Employee created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="department_id", type="integer", example=1),
     *             @OA\Property(property="id", type="string", example="afb2475a-459d-43bf-88cd-748c0f2b60c9"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-05T15:08:29.000000Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-05T15:08:29.000000Z"),
     *             @OA\Property(
     *                 property="detail",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=15001),
     *                 @OA\Property(property="employee_id", type="string", example="afb2475a-459d-43bf-88cd-748c0f2b60c9"),
     *                 @OA\Property(property="designation", type="string", example="Software Engineer"),
     *                 @OA\Property(property="salary", type="number", format="float", example=7500),
     *                 @OA\Property(property="address", type="string", example="123 Main St, Springfield, IL"),
     *                 @OA\Property(property="joined_date", type="string", format="date", example="2025-05-05"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-05T15:08:29.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-05T15:08:29.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|integer|exists:departments,id',
            'designation' => 'required|string',
            'salary' => 'required|numeric|min:0',
            'address' => 'required|string',
            'joined_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $employee = Employee::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
        ]);

        $employee->detail()->create([
            'designation' => $request->designation,
            'salary' => $request->salary,
            'address' => $request->address,
            'joined_date' => $request->joined_date,
        ]);

        return response()->json($employee->load('detail'), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/employees/{id}",
     *     summary="Get employee by ID",
     *     description="Fetch an employee's information along with their details using their unique ID.",
     *     operationId="getEmployeeById",
     *     tags={"Employees"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid"),
     *         description="The ID of the employee"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Employee details fetched successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="id", type="string", format="uuid", example="00061be2-ea73-469d-b0ba-c371bcf9183f"),
     *                 @OA\Property(property="name", type="string", example="Ms. Leda Ankunding V"),
     *                 @OA\Property(property="email", type="string", example="chanel.ryan@barton.com"),
     *                 @OA\Property(property="department_id", type="integer", example=9),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-05T14:43:56.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-05T14:43:56.000000Z"),
     *                 @OA\Property(property="deleted_at", type="string", nullable=true, example="null"),
     *                 @OA\Property(
     *                     property="detail",
     *                     type="object",
     *                     properties={
     *                         @OA\Property(property="id", type="integer", example=55),
     *                         @OA\Property(property="employee_id", type="string", format="uuid", example="00061be2-ea73-469d-b0ba-c371bcf9183f"),
     *                         @OA\Property(property="designation", type="string", example="Event Planner"),
     *                         @OA\Property(property="salary", type="number", format="float", example=7746.84),
     *                         @OA\Property(property="address", type="string", example="7241 Reichert Manors Apt. 741\nChristineview, AZ 20846-3087"),
     *                         @OA\Property(property="joined_date", type="string", format="date", example="1995-05-15"),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-05T14:43:56.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-05T14:43:56.000000Z")
     *                     }
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="message", type="string", example="Employee not found.")
     *             }
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $employee = Employee::with('detail')->findOrFail($id);
        return response()->json($employee);
    }

    /**
     * @OA\Put(
     *     path="/api/employees/{id}",
     *     summary="Update an existing employee",
     *     description="Update the employee's basic information and details (if present)",
     *     operationId="updateEmployee",
     *     tags={"Employees"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the employee to be updated",
     *         @OA\Schema(
     *             type="string",
     *             example="00005523-d4c2-4845-a3b0-f88fb8164f4a"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Employee data to be updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Mrs. Idell Stehr"),
     *             @OA\Property(property="email", type="string", example="jada.raynor@bayer.org"),
     *             @OA\Property(property="department_id", type="integer", example=6),
     *             @OA\Property(property="designation", type="string", example="Manager"),
     *             @OA\Property(property="salary", type="number", format="float", example=45000.00),
     *             @OA\Property(property="address", type="string", example="123 Street, City"),
     *             @OA\Property(property="joined_date", type="string", format="date", example="2025-01-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully updated the employee",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="string", example="5523"),
     *             @OA\Property(property="name", type="string", example="Mrs. Idell Stehr"),
     *             @OA\Property(property="email", type="string", example="jada.raynor@bayer.org"),
     *             @OA\Property(property="department_id", type="integer", example=6),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-05T14:43:59.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-05T14:43:59.000000Z"),
     *             @OA\Property(property="deleted_at", type="string", nullable=true, example=null),
     *             @OA\Property(property="detail", type="object", 
     *                 @OA\Property(property="employee_id", type="string", example="5523"),
     *                 @OA\Property(property="designation", type="string", example="Manager"),
     *                 @OA\Property(property="salary", type="number", format="float", example=45000.00),
     *                 @OA\Property(property="address", type="string", example="123 Street, City"),
     *                 @OA\Property(property="joined_date", type="string", format="date", example="2025-01-01"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-05-05T14:43:59.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-05-05T14:43:59.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data or invalid employee ID",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Bad Request")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Employee not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->update($request->only('name', 'email', 'department_id'));

        if ($employee->detail) {
            $employee->detail->update($request->only('designation', 'salary', 'address', 'joined_date'));
        }

        return response()->json([
            'message' => 'Employee updated successfully!',
            'data' => $employee->load('detail'),
        ]);
    }


    /**
     * @OA\Delete(
     *     path="/api/employees/{id}",
     *     summary="Delete an employee by ID",
     *     description="Delete an employee and their associated details using their unique ID.",
     *     operationId="deleteEmployee",
     *     tags={"Employees"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid"),
     *         description="The ID of the employee to be deleted"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Employee successfully deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="message", type="string", example="Employee deleted.")
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Employee not found",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="message", type="string", example="Employee not found.")
     *             }
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->detail()->delete();
        $employee->delete();

        return response()->json(['message' => 'Employee deleted.']);
    }
}
