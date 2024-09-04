document.addEventListener("DOMContentLoaded", function() {

    let typeField = document.getElementById("choices-publish-status-input");
    var typeVal =  new Choices(typeField, {
        searchEnabled: false,
    });

    const eventStatus = 'paid'; // Replace this with your actual event status
    const statusElement = document.querySelector('.payment-status'); // Replace with your actual selector
    const dateElement = document.getElementById('event-date'); // Replace with your actual selector
    const createdAt = dateElement.getAttribute('data-created-at');

    const dateTimeElement = document.getElementById('event-date-time'); // Replace with your actual selector

    const dateEventElement = document.getElementById('event-datet'); // Replace with your actual selector
    const eventTimeElement = document.getElementById('event-time');


    const eventDate = dateEventElement.getAttribute('data-event-date');
    const eventTime = eventTimeElement.getAttribute('data-event-time');


    if (statusElement) {
        statusElement.innerHTML = `حالة الطلب  : ${translateStatus(eventStatus)}`;
    }
    if (dateElement) {
        dateElement.innerHTML = ` ${formatDate(createdAt, 'ar')}`;
    }
    if (dateEventElement) {
        dateEventElement.innerHTML = ` ${formatDate(eventDate, 'ar')}`;
    }
    if (eventTimeElement) {
        eventTimeElement.innerHTML = ` ${convertTo12HourFormatArabic(eventTime.split(" ")[1])}`;
    }
    if (dateTimeElement) {
        dateTimeElement.innerHTML = ` ${formatDate(createdAt, 'ar') }` + '  -  ' +` ${convertTo12HourFormatArabic(createdAt.split(" ")[1]) }` ;
    }
    function translateStatus(status) {
        const translations = {
            'paid': 'مدفوع',
            'completed': 'مكتمل',
            'pending': 'قيد الانتظار',
            'pending_payment': 'انتظار الدفع',
            'payment_failed': 'فشل الدفع',
            'canceled': 'ملغي'
        };

        return translations[status] || status;
    }

    function formatDate(dateString, locale) {
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        const date = new Date(dateString);
        return date.toLocaleDateString(locale, options);
    }

    function convertTo12HourFormatArabic(time24) {
        // Split the time into hours, minutes, and seconds
        console.log(time24);
        var parts = time24.split(':');

        var hours = parseInt(parts[0]);
        var minutes = parseInt(parts[1]);
        var seconds = parseInt(parts[2]);

        // Determine AM/PM
        var ampm = hours >= 12 ? 'مساءً' : 'صباحًا';

        // Convert hours to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // 0 should be converted to 12

        // Ensure leading zero for single-digit minutes and seconds
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        // Return the formatted time
        return hours + ':' + minutes + ':' + seconds + ' ' + ampm;
    }

    const saveStatusBtn = document.getElementById('save-status-btn');
    const statusSelect = document.getElementById('choices-publish-status-input');
    const paymentStatusElement = document.querySelector('.payment-status');

    saveStatusBtn.addEventListener('click', function (e) {
        e.preventDefault();

        const status = statusSelect.value;
        const ticketId = window.ticketId;
        const csrfToken = window.csrfToken;
        e.preventDefault();



        const xhr = new XMLHttpRequest();
        const url = `/api/admins/orders/${ticketId}/status`;
        xhr.open('PUT', url, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                var response = JSON.parse(this.responseText);
                if (response.status === 200) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.msg,
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true
                    }).then(() => {
                        // Update the status text on the page
                        document.querySelector('.payment-status').textContent = translateStatus(status);
                    });
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
            } else {
                console.error('Error:', xhr.statusText);
            }
        };

        xhr.onerror = function () {
            console.error('Request failed');
        };

        xhr.send(JSON.stringify({ status: status }));
    });


});
