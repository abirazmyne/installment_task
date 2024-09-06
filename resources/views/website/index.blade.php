<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Home Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .custom-header {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
<div class="">
    <div class="custom-header">
        <h1>Welcome to the Home Page</h1>
        <p class="lead">This is a simple integration of Bootstrap, jQuery, FontAwesome, Yajrabox & Sweetalert .</p>
    </div>

   <div class="row">
       <div class="col-md-7">
           <div class="container">
               <div class="row mt-5">
                   <div class="col">
                       <div class="card">
                           <div class="card-body">
                               <h3><i class="fas fa-user-plus"></i> Create Member</h3>
                               <form id="memberForm">
                               @csrf <!-- CSRF token for security -->

                                   <div class="mb-3">
                                       <label for="name" class="form-label">Name</label>
                                       <input type="text" class="form-control" id="name" name="name" placeholder="Enter member name" required>
                                   </div>

                                   <div class="mb-3">
                                       <label for="email" class="form-label">Email</label>
                                       <input type="email" class="form-control" id="email" name="email" placeholder="Enter member email" required>
                                   </div>

                                   <div class="mb-3">
                                       <label for="phone" class="form-label">Phone</label>
                                       <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter member phone" required>
                                   </div>

                                   <div class="mb-3">
                                       <label for="address" class="form-label">Address</label>
                                       <input type="text" class="form-control" id="address" name="address" placeholder="Enter member address" required>
                                   </div>

                                   <div class="mb-3">
                                       <label for="installment_amount" class="form-label">Installment Amount</label>
                                       <input type="number" class="form-control" id="installment_amount" name="installment_amount" placeholder="Enter installment amount" required>
                                   </div>

                                   <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                               </form>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="row mt-5">
                   <div class="col">
                       <div class="card">
                           <div class="card-body">
                               <div class="col-md-12">
                                   <h3><i class="fas fa-cogs"></i> Members Table</h3>
                                   <div class="row mt-5">
                                       <div class="col-md-12">
                                           <table id="membersTable" class="display table table-striped">
                                               <thead>
                                               <tr>
                                                   <th>ID</th>
                                                   <th>Name</th>
                                                   <th>Email</th>
                                                   <th>Phone</th>
                                                   <th>Address</th>
                                                   <th>Installment Amount</th>
                                                   <th>Actions</th>
                                               </tr>
                                               </thead>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

           </div>
       </div>
       <div class="col-md-5">
           <div class="container">
               <div class="row mt-5">
                   <div class="col">
                       <div id="cardContainer"></div>

                   </div>
               </div>
           </div>
       </div>
   </div>
</div>
@include('website.modal')
<footer>
    <div class="mt-5">

    </div>
</footer>
<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    function handleSweetAlertResponse(response, successMessage, errorMessage) {
        if (response.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: successMessage || response.message
            }).then(() => {
                // Reload the DataTable or perform any additional actions
                $('#membersTable').DataTable().ajax.reload();
                $('.modal').modal('hide'); // Close any open modals
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage || response.message
            });
        }
    }


    $(document).ready(function() {
            var table = $('#membersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("members.data") }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'address', name: 'address' },
                    { data: 'installment_amount', name: 'installment_amount' },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                        <button class="btn btn-primary btn-sm edit-btn" data-id="${row.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-success btn-sm memberdata-btn" data-id="${row.id}">
                            <i class="fas fa-info-circle"></i> Calculate
                        </button>
                    `;
                        }
                    }
                ]
            });

// Handle memberdata button click
            // Handle memberdata button click
            // Handle memberdata button click
            $('#membersTable').on('click', '.memberdata-btn', function() {
                var id = $(this).data('id'); // Get member ID from the button's data attribute

                $.ajax({
                    url: "{{ route('membersdata.get', '') }}/" + id, // Make AJAX GET request to fetch member data
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Create card HTML with a form
                            var cardHtml = `
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Member Details</h5>
                    </div>
                    <div class="card-body">
                                <form id="memberForm" action="{{ route('submit.member.data') }}" method="POST">
    @csrf
                            <div class="mb-3">
                                <label for="memberName" class="form-label">Name</label>
                                <input type="number" class="form-control" id="memberid" name="memberid" hidden>
                                <input type="text" class="form-control" id="memberName" name="memberName" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="memberEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="memberEmail" name="memberEmail" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="memberPhone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="memberPhone" name="memberPhone" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="memberAddress" class="form-label">Address</label>
                                <textarea class="form-control" id="memberAddress" name="memberAddress" rows="3" readonly></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="memberInstallmentAmountold" class="form-label">Installment Total Amount before Penalty Include</label>
                                <input type="number" class="form-control" id="memberInstallmentAmountold" name="member_old_installment" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="memberInstallmentAmount" class="form-label">Installment Total Amount</label>
                                <input type="number" class="form-control" id="memberInstallmentAmount" name="member_incresed_installment" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="amountIncreased" class="form-label">Amount Increased</label>
                                <input type="number" class="form-control" id="amountIncreased" name="installment_increased" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="penalty_percentage" class="form-label">Select Penalty Percentage</label>
                                <select class="form-control" id="penalty_percentage" name="penalty_percentage">
                                <!-- Options will be appended here -->
                                </select>
                            </div>
                            <div class="mb-3">
                            <label for="amount" class="form-label">Amount Paying Now</label>
                            <input type="number" class="form-control" id="amount" name="amount">
                            </div>
                            <div class="mb-3">
                            <label for="paid" class="form-label">Paid</label>
                            <input type="radio" id="paid" name="payment_status" value="paid">
                            </div>
                            <div class="mb-3">
                            <label for="failed_pay" class="form-label">Failed to Pay on Time</label>
                            <input type="radio" id="failed_pay" name="payment_status" value="failed_pay">
                            </div>

                            <div class="mb-3">
                            <label for="payment_date" class="form-label">Select Payment Date</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date">
                            </div>
                            <div class="mb-3">
                            <label for="penalty" class="form-label">Penalty</label>
                            <input type="number" class="form-control" id="penalty" name="penalty" readonly>
                            </div>
                            <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit Data</button>
                            </div>
                            </form>

                            </div>
                            </div>
                            `;

                // Replace content of cardContainer with the new card HTML
                $('#cardContainer').html(cardHtml);

                // Populate the form fields with response data
                $('#memberid').val(response.data.id);
                $('#memberName').val(response.data.name);
                $('#memberEmail').val(response.data.email);
                $('#memberPhone').val(response.data.phone);
                $('#memberAddress').val(response.data.address);
                $('#memberInstallmentAmount').val(response.data.installment_amount);
                $('#amount').val(response.data.amount);
                $('#paid').prop('checked', response.data.paid);
                $('#payment_date').val(response.data.payment_date || new Date().toISOString().split('T')[0]); // Default to current date if empty
                $('#memberInstallmentAmountold').val(response.data.installment_amount);
                $('#penalty').val(response.data.penalty);

                // Calculate the initial installment amount and amount increased
                var installmentAmount = parseFloat(response.data.installment_amount);
                $('#memberInstallmentAmount').val(installmentAmount.toFixed(2));

                // Fetch penalty settings and update the penalty_percentage select field
                $.ajax({
                    url: "{{ route('penalty-settings.get') }}",
                    type: 'GET',
                    success: function(penaltyResponse) {
                        if (penaltyResponse.success) {
                            // Clear existing options
                            $('#penalty_percentage').empty();

                            // Append all penalty percentages as options in the select dropdown
                            penaltyResponse.penalty_percentages.forEach(function(percentage) {
                                $('#penalty_percentage').append(`<option value="${percentage}">${percentage}%</option>`);
                            });

                    // Calculate and display the final installment amount based on the first penalty percentage
                    var selectedPercentage = penaltyResponse.penalty_percentages[0];
                    var finalAmount = installmentAmount * (1 + parseFloat(selectedPercentage) / 100);
                    $('#memberInstallmentAmount').val(finalAmount.toFixed(2));
                $('#amountIncreased').val((finalAmount - installmentAmount).toFixed(2)); // Display the increased amount

                // Handle change event for penalty_percentage dropdown
                $('#penalty_percentage').on('change', function() {
                    var selectedPercentage = $(this).val();
                    var penaltyAmount = installmentAmount * (parseFloat(selectedPercentage) / 100);
                    $('#penalty').val(penaltyAmount.toFixed(2));
                    var finalAmount = installmentAmount * (1 + parseFloat(selectedPercentage) / 100);
                    $('#memberInstallmentAmount').val(finalAmount.toFixed(2));
                    $('#amountIncreased').val((finalAmount - installmentAmount).toFixed(2)); // Update increased amount
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch penalty settings.'
                });
            }
        },
        error: function(xhr, status, error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while fetching penalty settings.'
        });
    }
    });

    // Handle overdue payment date
    var paymentDate = new Date(response.data.payment_date);
    var currentDate = new Date();
    var diffDays = Math.ceil((currentDate - paymentDate) / (1000 * 60 * 60 * 24));

    if (diffDays > 7) {
        $('#failed_pay').prop('checked', true);
        $('#payment_date').prop('readonly', false); // Make date field editable if overdue
        $('#payment_date').addClass('border-danger'); // Add red border if overdue
    } else {
        $('#failed_pay').prop('checked', false);
        $('#payment_date').prop('readonly', true); // Make date field readonly if not overdue
        $('#payment_date').removeClass('border-danger'); // Remove red border
    }
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to fetch member data.'
        });
    }
    },
    error: function(xhr, status, error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while fetching member data.'
        });
    }
    });
    });



    // Handle edit button click
    $('#membersTable').on('click', '.edit-btn', function() {
        var id = $(this).data('id');

        $.ajax({
            url: "{{ route('members.show', '') }}/" + id,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editMemberId').val(response.data.id);
                    $('#editName').val(response.data.name);
                    $('#editEmail').val(response.data.email);
                    $('#editPhone').val(response.data.phone);
                    $('#editAddress').val(response.data.address);
                    $('#editInstallmentAmount').val(response.data.installment_amount);

                    $('#editMemberModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            }
        });
    });

    // Handle update form submission
    $('#editMemberForm').on('submit', function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        var id = $('#editMemberId').val(); // Get the ID of the member being edited

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('members.update', ['id' => '__ID__']) }}".replace('__ID__', id), // Replace __ID__ with the actual member ID
            type: 'PUT',
            data: formData,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {
                        table.ajax.reload();
                        $('#editMemberModal').modal('hide');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please check the console for details.'
                });
            }
        });
    });

    // Handle delete button click
    $('#membersTable').on('click', '.delete-btn', function() {
        var deleteId = $(this).data('id');
        $('#deleteMemberModal').modal('show');

        // Confirm delete
        $('#confirmDelete').on('click', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('members.destroy', '') }}/" + deleteId,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: response.message
                        }).then(() => {
                            table.ajax.reload();
                            $('#deleteMemberModal').modal('hide');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please check the console for details.'
                    });
                }
            });
        });
    });

    // Handle form submission
    $('#memberForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = $(this).serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('members.store') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {
                        table.ajax.reload();
                        $('#addMemberModal').modal('hide');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.'
                });
            }
        });
    });
    });
</script>




</body>
</html>
