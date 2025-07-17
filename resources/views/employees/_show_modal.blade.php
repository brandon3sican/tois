<!-- Show Employee Modal -->
<div class="modal fade" id="showEmployeeModal" tabindex="-1" aria-labelledby="showEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showEmployeeModalLabel">Employee Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Full Name</label>
                            <p>{{ $employee->first_name }} {{ $employee->middle_name ? $employee->middle_name . ' ' : '' }}{{ $employee->last_name }}{{ $employee->suffix ? ', ' . $employee->suffix : '' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Position</label>
                            <p>{{ $employee->position->name }} (₱{{ number_format($employee->position->salary, 2) }})</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Division/Section/Unit</label>
                            <p>{{ $employee->divSecUnit->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Employment Status</label>
                            <p>{{ $employee->employmentStatus->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Date Hired</label>
                            <p>{{ $employee->date_hired->format('F j, Y') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Age</label>
                            <p>{{ $employee->age }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Gender</label>
                            <p>{{ ucfirst($employee->gender) }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Birthdate</label>
                            <p>{{ $employee->birthdate->format('F j, Y') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Contact Number</label>
                            <p>{{ $employee->contact_num }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <p>{{ $employee->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
