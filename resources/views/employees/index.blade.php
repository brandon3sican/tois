@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Employees</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEmployeeModal">
                        Add New Employee
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Unit</th>
                                    <th>Status</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->first_name }} {{ $employee->middle_name ? $employee->middle_name . ' ' : '' }}{{ $employee->last_name }}{{ $employee->suffix ? ', ' . $employee->suffix : '' }}</td>
                                        <td>{{ $employee->position->name }}</td>
                                        <td>{{ $employee->divSecUnit->name }}</td>
                                        <td>{{ $employee->employmentStatus->name }}</td>
                                        <td>{{ $employee->age }}</td>
                                        <td>{{ ucfirst($employee->gender) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <!-- Show Button -->
                                                <button type="button" 
                                                        class="btn btn-outline-info btn-sm rounded-pill me-2 mb-1 hover:shadow-md transition-all duration-200" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#showEmployeeModal" 
                                                        onclick="showEmployee({{ $employee->id }})"
                                                        title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <!-- Edit Button -->
                                                <button type="button" 
                                                        class="btn btn-outline-warning btn-sm rounded-pill me-2 mb-1 hover:shadow-md transition-all duration-200" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editEmployeeModal" 
                                                        onclick="editEmployee({{ $employee->id }})"
                                                        title="Edit Employee">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger btn-sm rounded-pill mb-1 hover:shadow-md transition-all duration-200" 
                                                            onclick="return confirm('Are you sure you want to delete this employee?')"
                                                            title="Delete Employee">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the modals -->
@include('employees._create_modal')
@include('employees._show_modal')
@include('employees._edit_modal')

<script>
    function showEmployee(id) {
        // Get employee data using AJAX
        fetch(`/employees/${id}`)
            .then(response => response.json())
            .then(data => {
                // Update modal content
                document.getElementById('showEmployeeModal').querySelector('.modal-body').innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <p>${data.first_name} ${data.middle_name ? data.middle_name + ' ' : ''}${data.last_name}${data.suffix ? ', ' + data.suffix : ''}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Position</label>
                                <p>${data.position.name} (₱${data.position.salary.toFixed(2)})</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Division/Section/Unit</label>
                                <p>${data.divSecUnit.name}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Employment Status</label>
                                <p>${data.employmentStatus.name}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date Hired</label>
                                <p>${new Date(data.date_hired).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Age</label>
                                <p>${data.age}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Gender</label>
                                <p>${data.gender.charAt(0).toUpperCase() + data.gender.slice(1)}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Birthdate</label>
                                <p>${new Date(data.birthdate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Contact Number</label>
                                <p>${data.contact_num}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <p>${data.address}</p>
                            </div>
                        </div>
                    </div>
                `;
                
                // Show the modal
                new bootstrap.Modal(document.getElementById('showEmployeeModal')).show();
            });
    }

    function editEmployee(id) {
        // Get employee data using AJAX
        fetch(`/employees/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                // Update form fields
                document.getElementById('first_name').value = data.first_name;
                document.getElementById('last_name').value = data.last_name;
                document.getElementById('middle_name').value = data.middle_name || '';
                document.getElementById('suffix').value = data.suffix || '';
                document.getElementById('age').value = data.age;
                document.getElementById('gender').value = data.gender;
                document.getElementById('contact_num').value = data.contact_num;
                document.getElementById('address').value = data.address;
                document.getElementById('birthdate').value = data.birthdate;
                document.getElementById('date_hired').value = data.date_hired;
                document.getElementById('position_id').value = data.position_id;
                document.getElementById('employment_status_id').value = data.employment_status_id;
                document.getElementById('div_sec_unit_id').value = data.div_sec_unit_id;

                // Show the modal
                new bootstrap.Modal(document.getElementById('editEmployeeModal')).show();
            });
    }
</script>
@endsection
