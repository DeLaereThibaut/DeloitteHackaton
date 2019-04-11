<div class="modal fade" tabindex="-1" role="dialog" id="createContact">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">Create New Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert" class="erroralert">

                </div>
                <div class="form-group">
                    <label for="name">First Name</label>
                    <input type="text" class="form-control" id="firstname">
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" id="lastname">
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="phonenumber">Phonenumber</label>
                    <input type="text" class="form-control" id="phonenumber">
                </div>
                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="text" class="form-control" id="position">
                </div>
                <div class="form-group check">
                    <label for="primary">primary</label>
                    <input type="checkbox" class="form-control myCheckbox" id="primary">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveChanges" onclick="saveContact()">Save changes
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function saveContact() {
        let firstname = document.getElementById('firstname').value;
        let lastname = document.getElementById('lastname').value;
        let email = document.getElementById('email').value;
        let phonenumber = document.getElementById('phonenumber').value;
        let position = document.getElementById('position').value;
        let primary;
        if (document.getElementById("primary").checked){
            primary = 1;
        } else {
            primary = 0;
        }
        {{'let school_id= ' . $school->school_id}}
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('school.addContact')}}",
            type: "POST",
            data: {
                school_id: school_id,
                firstname: firstname,
                lastname: lastname,
                email: email,
                phonenumber: phonenumber,
                primary: primary,
                position: position,
            },
            dataType: "html",

            success: function (json_doc) {
                console.log(json_doc);
                r = JSON.parse(json_doc);
                if (r.result) {
                    showMessage("#general_alert", r.message, "success");
                    location.reload();
                } else {
                    showMessage(".erroralert", r.message, "danger");
                }
                console.log(json_doc);
            },
            error: function (jqXHR, exception) {
                alert("error");
                //console.log(jqXHR, exception)
                //showMessage("#alert", json_doc, "danger");
            },
            complete: function (result, status) {
                console.log(result);
            }

        });
    }
</script>
