
document.addEventListener('DOMContentLoaded', function () {
    // Function to decode HTML entities




    // Initialize Choices.js
    new Choices('#choices-publish-status-input', { searchEnabled: false });
    new Choices('#choices-publish-visibility-input', { searchEnabled: false });
    new Choices('#choices-players-visibility-input', { searchEnabled: false });
    new Choices('#choices-places-visibility-input', { searchEnabled: true });


// Image preview functionality
// Image preview functionality
    document.querySelector("#product-image-input").addEventListener("change", function () {
        var previewContainer = document.querySelector("#image-preview-container");
        var files = this.files;

        Array.from(files).forEach(file => {
            var reader = new FileReader();
            reader.addEventListener("load", function () {
                var imgContainer = document.createElement("div");
                imgContainer.className = "position-relative m-2";

                var img = document.createElement("img");
                img.src = reader.result;
                img.style.maxWidth = "100px"; // Adjust as needed
                img.style.margin = "5px";
                img.className = "img-thumbnail";

                var replaceButton = document.createElement("button");
                replaceButton.innerText = "Replace";
                replaceButton.className = "btn btn-sm btn-warning position-absolute bottom-0 start-0 m-1";
                replaceButton.onclick = function () {
                    var replaceInput = document.createElement("input");
                    replaceInput.type = "file";
                    replaceInput.accept = "image/png, image/gif, image/jpeg";
                    replaceInput.className = "d-none";
                    replaceInput.onchange = function () {
                        var newFile = replaceInput.files[0];
                        var newReader = new FileReader();
                        newReader.onload = function () {
                            img.src = newReader.result;
                        };
                        if (newFile) {
                            newReader.readAsDataURL(newFile);
                        }
                    };
                    replaceInput.click();
                };

                var deleteButton = document.createElement("button");
                deleteButton.innerText = "Delete";
                deleteButton.className = "btn btn-sm btn-danger position-absolute bottom-0 end-0 m-1";
                deleteButton.onclick = function () {
                    imgContainer.remove();
                };

                imgContainer.appendChild(img);
                imgContainer.appendChild(replaceButton);
                imgContainer.appendChild(deleteButton);
                previewContainer.appendChild(imgContainer);
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        });
    });



    // Handle form submission
    document.getElementById('create-playground-form').addEventListener('submit', function (e) {
        e.preventDefault();


        const formData = new FormData(this);





        var  name_ar=document.getElementById('product-title-input').value;
        var  name_en=document.getElementById('product-title-input-en').value;
        var  price60=document.getElementById('product-price60-input').value;
        var  price90=document.getElementById('product-price90-input').value;
        var  price120=document.getElementById('product-price120-input').value;
        var  price180=document.getElementById('product-price180-input').value;


        formData.append('name_ar', name_ar);
        formData.append('name_en', name_en);
        formData.append('price_per_60', price60);
        formData.append('price_per_90', price90);
        formData.append('price_per_120', price120);
        formData.append('price_per_180', price180);

        formData.append('place_id',  document.getElementById("choices-places-visibility-input").value);
        formData.append('classification',  document.getElementById("choices-publish-visibility-input").value);
        formData.append('player',  document.getElementById("choices-players-visibility-input").value);
        formData.append('is_active',  document.getElementById("choices-publish-status-input").value);

        var imageInput = document.querySelector("#product-image-input");

        for (var i = 0; i < imageInput.files.length; i++) {
            formData.append('images[]', imageInput.files[i]);
        }

        const xhr = new XMLHttpRequest();
        var url = `/api/admin/playgrounds`;
        xhr.open('POST', url, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name="_token"]').value);
        xhr.setRequestHeader('lang', 'ar');

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 200) {

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.msg,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    }).then(() => {
                        window.location.href = '/playgrounds';
                    });
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: response.msg,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    });
                }
            } else {
                console.error('Error:', xhr.statusText);
            }
        };

        xhr.onerror = function () {
            console.error('Request failed');
        };

        xhr.send(formData);
    });
});
