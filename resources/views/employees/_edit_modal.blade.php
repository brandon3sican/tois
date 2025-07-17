<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employees.update', $employee) }}" method="POST" id="editEmployeeForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Personal Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Personal Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control form-control-lg @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ $employee->first_name }}" required>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control form-control-lg @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ $employee->last_name }}" required>
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control form-control-lg @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ $employee->middle_name }}">
                                        @error('middle_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="suffix" class="form-label">Suffix</label>
                                        <input type="text" class="form-control form-control-lg @error('suffix') is-invalid @enderror" id="suffix" name="suffix" value="{{ $employee->suffix }}">
                                        @error('suffix')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Contact Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="age" class="form-label">Age</label>
                                        <input type="number" class="form-control form-control-lg @error('age') is-invalid @enderror" id="age" name="age" value="{{ $employee->age }}" min="18" required>
                                        @error('age')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select form-select-lg @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ $employee->gender == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="contact_num" class="form-label">Contact Number</label>
                                        <input type="text" class="form-control form-control-lg @error('contact_num') is-invalid @enderror" id="contact_num" name="contact_num" value="{{ $employee->contact_num }}" required>
                                        @error('contact_num')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control form-control-lg @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ $employee->address }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="birthdate" class="form-label">Birthdate</label>
                                        <input type="date" class="form-control form-control-lg @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ $employee->birthdate->format('Y-m-d') }}" required>
                                        @error('birthdate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Employment Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date_hired" class="form-label">Date Hired</label>
                                        <input type="date" class="form-control form-control-lg @error('date_hired') is-invalid @enderror" id="date_hired" name="date_hired" value="{{ $employee->date_hired->format('Y-m-d') }}" required>
                                        @error('date_hired')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="position_id" class="form-label">Position</label>
                                        <select class="form-select form-select-lg @error('position_id') is-invalid @enderror" id="position_id" name="position_id" required>
                                            <option value="">Select Position</option>
                                            @foreach($positions as $position)
                                                <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>
                                                    {{ $position->name }} (₱{{ number_format($position->salary, 2) }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('position_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="employment_status_id" class="form-label">Employment Status</label>
                                        <select class="form-select form-select-lg @error('employment_status_id') is-invalid @enderror" id="employment_status_id" name="employment_status_id" required>
                                            <option value="">Select Status</option>
                                            @foreach($employmentStatuses as $status)
                                                <option value="{{ $status->id }}" {{ $employee->employment_status_id == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('employment_status_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="div_sec_unit_id" class="form-label">Division/Section/Unit</label>
                                <select class="form-select form-select-lg @error('div_sec_unit_id') is-invalid @enderror" id="div_sec_unit_id" name="div_sec_unit_id" required>
                                    <option value="">Select Unit</option>
                                    @foreach($divSecUnits as $unit)
                                        <option value="{{ $unit->id }}" {{ $employee->div_sec_unit_id == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('div_sec_unit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-lg">Update Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
