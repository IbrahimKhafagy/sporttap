
document.addEventListener("DOMContentLoaded", function() {


document.getElementById("showModal").addEventListener("show.bs.modal", function (e) {
    // If the related target is an add button, clear modal fields and update modal title


    document.getElementById('exampleModalLabel').innerText =  'اضافة عميل جديد'; // Update this text as needed
    document.getElementById('add-btn').innerText = 'اضف الآن'; // Update this text as needed
    document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";

    document.querySelector('.tablelist-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission behavior

        // Retrieve form data from the modal
        var level = document.getElementById('level').value;
        var age = document.getElementById('age').value;
        var gender = document.getElementById('gender').value;
        var sport_type =  document.getElementById('sport_type').value; // Handle optional field
        var id = document.getElementById('id-client').value;
        var is_active = document.getElementById('is_active').value;



        var requestData = {
            level: level,
            sport_type: sport_type,
            gender: gender,
            age: age,
            is_active:is_active,
        };

        var baseUrl = window.location.origin;

        var xhr = new XMLHttpRequest();
        var url = `${baseUrl}/api/admin/client/update/${id}`; // Replace with your route name
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name="_token"]').value);

        // Send the request with the edited data
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                var response = JSON.parse(this.responseText);
                if (xhr.status === 200 && response.success) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });

                    // Refresh the user data or page
                    document.getElementById("close-modal").click();
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            }
        };

        // Validation


        xhr.send(JSON.stringify(requestData));
    });
});
});




