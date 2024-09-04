
document.addEventListener("DOMContentLoaded", function() {
    var currentPage = 1;
    var totalPages = 1; // Total number of page
    var perPage = 50; // Number of users per page
    var apiUrl = "/api/admin/allClient"; // API endpoint to fetch user data
    const userLanguage = window.languageSettings.locale; // Fallback for older browsers

    var formattedStartDate="";
    var isEdit=false;
    var formattedEndDate="";


    console.log(userLanguage);


    var status="all";



    let typeField = document.getElementById("sport_type");
    var typeVal =  new Choices(typeField, {
        searchEnabled: false,
    });



    let genderField = document.getElementById("gender");
    var genderVal =  new Choices(genderField, {
        searchEnabled: false,
    });

    let levelField = document.getElementById("level");
    var levelVal =  new Choices(levelField, {
        searchEnabled: false,
    });


    let ageField = document.getElementById("age");
    var ageVal =  new Choices(ageField, {
        searchEnabled: false,
    });

    let isActiveField = document.getElementById("is_active");
    var isActiveVal =  new Choices(isActiveField, {
        searchEnabled: false,
    });


    flatpickr("#datepicker-range", {
        locale: "ar",
        mode: "range"  ,
        dateFormat: "d M, Y",
        range: true,
        onChange: function(selectedDates, dateStr, instance) {
            formattedStartDate="";
            formattedEndDate="";
            if (selectedDates.length === 2) {
                var startDate = formatDatePicker(selectedDates[0]);
                var endDate = formatDatePicker(selectedDates[1]);
                formattedStartDate = addDays(selectedDates[0], 1);
                formattedEndDate = addDays(selectedDates[1], 1);
                console.log("Selected date range:", formattedStartDate, "to", formattedEndDate);
                instance.element.value = startDate + " إلى " + endDate;
            }
            else if (selectedDates.length === 1) {
                instance.element.value = formatDatePicker(selectedDates[0]);
            }
        }
    });

    function addDays(date, days) {
        var newDate = new Date(date);
        newDate.setDate(newDate.getDate() + days);
        return newDate.toISOString().split('T')[0];
    }

    function formatDatePicker(date) {
        var day = date.getDate();
        var month = date.toLocaleDateString("ar-EG", { month: "long" });
        var year = date.getFullYear();
        return `${day} ${month}، ${year}`;
    }


    function fetchUsers(page, column, direction,searchQuery) {
        var queryString = `?page=${page}&column=${column}&direction=${direction}&status=${status}`;

        if (searchQuery) {
            queryString += `&search=${searchQuery}`;
        }
        if (formattedStartDate!=="" && formattedEndDate!=="") {
            queryString += `&startDate=${formattedStartDate}&endDate=${formattedEndDate}`;
        }


        var xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            var json_records = JSON.parse(this.responseText);
            totalPages = Math.ceil(json_records.total / perPage);
            updateTable(json_records.data);
            updatePaginationButtons();
            toggleTableVisibility(json_records.data.length === 0);
        };
        xhttp.open("GET", apiUrl + queryString);
        xhttp.send();
    }


    function toggleTableVisibility(hasResults) {
        const noResultMessage = document.querySelector('.noresult');
        if (hasResults) {
            noResultMessage.style.display = 'block'; // Hide the no result message
        } else {
            noResultMessage.style.display = 'none'; // Show the no result message
        }
    }

    // Function to update the table with user data
    function updateTable(users) {
        var tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '';
        users.forEach(user => {
            var row = document.createElement('tr');
            row.innerHTML = `
                <td scope="row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                    </div>
                </td>
                <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">${JSON.stringify(user, null, 2)}</a></td>

                <td class="first_name">${user.first_name}</td>
                                <td class="last_name">${user.last_name}</td>

                                                                <td class="phone">${user.phone}</td>


                    <td class="sport_type">${  user.sport_type===null ?'-':user.sport_type==='Tennis' ?userLanguage==="en" ? 'Tennis' :  'تنس' :userLanguage==="en" ? 'Padel' : 'بادل'}</td>

                    <td class="gender">${user.gender===null ?'-':user.gender === 'male' ? userLanguage === "en" ? 'Male' : 'ذكر' : userLanguage === "en" ? 'Female' : 'آنثي'}</td>

                    <td class="level">${user.level===null ?'-' :isLevel(user.level) }</td>

<td class="date">${formatDate(user.created_at, userLanguage)}</td>


                <td class="status" >${isStatus(user.is_active)}</td>
        <td>
    <ul class="list-inline hstack gap-2 mb-0">
        <!-- Details Button -->
        <li class="list-inline-item details" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="${userLanguage === "en" ? 'Details' : 'تفاصيل'}">
            <a href="/admin/clients/${user.id}" class="btn btn-info btn-sm details-item-btn">
                ${userLanguage === "en" ? 'Details' : 'تفاصيل'}
            </a>
        </li>
        <!-- Reservations Button -->
        <li class="list-inline-item reservations" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="${userLanguage === "en" ? 'Reservations' : 'الحجوزات'}">
            <a href="/admin/client/${user.id}/experience" class="btn btn-secondary btn-sm reservations-item-btn">
                ${userLanguage === "en" ? 'Reservations' : 'الحجوزات'}
            </a>
        </li>
    </ul>
</td>


            `;
            tableBody.appendChild(row);
        });
    }



    // Function to update pagination buttons based on current page and total pages
// Function to update pagination buttons based on current page and total pages
    function updatePaginationButtons() {
        var prevButton = document.querySelector(".pagination-prev");
        var nextButton = document.querySelector(".pagination-next");

        // Disable previous button if on the first page
        if (currentPage === 1) {
            prevButton.classList.add("disabled");
        } else {
            prevButton.classList.remove("disabled");
        }

        // Disable next button if on the last page
        if (currentPage === totalPages) {
            nextButton.classList.add("disabled");
        } else {
            nextButton.classList.remove("disabled");
        }

        // Clear existing page number buttons
        var pageNumberContainer = document.querySelector(".pagination.listjs-pagination");
        pageNumberContainer.innerHTML = "";

        // Define the number of adjacent page numbers to display (adjust as needed)
        var adjacentPageNumbers = 1;
        var startPage = Math.max(1, currentPage - adjacentPageNumbers);
        var endPage = Math.min(totalPages, currentPage + adjacentPageNumbers);

        // Add page number buttons
        for (var i = startPage; i <= endPage; i++) {
            var pageNumberButton = document.createElement("li");
            pageNumberButton.textContent = i;
            pageNumberButton.classList.add("page-item");
            if (i === currentPage) {
                pageNumberButton.classList.add("active");
            }
            pageNumberButton.addEventListener("click", function() {
                currentPage = parseInt(this.textContent);
                fetchData(currentPage);
                updatePaginationButtons();
            });
            pageNumberContainer.appendChild(pageNumberButton);
        }

        // Add ellipsis if there are more pages before the first page
        if (startPage > 1) {
            var ellipsis = document.createElement("li");
            ellipsis.textContent = "...";
            ellipsis.classList.add("disabled");
            pageNumberContainer.insertBefore(ellipsis, pageNumberContainer.firstChild);
        }

        // Add ellipsis if there are more pages after the last page
        if (endPage < totalPages) {
            var ellipsis = document.createElement("li");
            ellipsis.textContent = "...";
            ellipsis.classList.add("disabled");
            pageNumberContainer.appendChild(ellipsis);
        }
    }

    // Event listener for previous button click
    document.querySelector(".pagination-prev").addEventListener("click", function() {
        if (currentPage > 1) {
            currentPage--;
            fetchUsers(currentPage,'created_at','desc');

            updatePaginationButtons();
        }
    });

    // Event listener for next button click
    document.querySelector(".pagination-next").addEventListener("click", function() {
        if (currentPage < totalPages) {
            currentPage++;
            fetchUsers(currentPage,'created_at','desc');
            updatePaginationButtons();
        }
    });

    // Initial setup
    updatePaginationButtons();

    // Function to determine status
    function isStatus(val) {
        return val
            ? '<span class="badge bg-success-subtle text-success text-uppercase">' + (userLanguage === "en" ? 'Active' : 'نشط') + '</span>'
            : '<span class="badge bg-danger-subtle text-danger text-uppercase">' + (userLanguage === "en" ? 'Inactive' : 'غير نشط') + '</span>';
    }


    function isLevel(val) {
        return val === 'junior'
            ? `<span class="badge bg-success-subtle text-success text-uppercase">${userLanguage === "en" ? 'Junior' : 'مبتدئ'}</span>`
            : val === 'middle'
                ? `<span class="badge bg-danger-subtle text-danger text-uppercase">${userLanguage === "en" ? 'Middle' : 'متوسط'}</span>`
                : `<span class="badge bg-secondary-subtle text-secondary text-uppercase">${userLanguage === "en" ? 'Advanced' : 'محترف'}</span>`;
    }


    function formatDate(dateString, locale) {
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        const date = new Date(dateString);
        return date.toLocaleDateString(locale, options);
    }




    function sortByColumn(columnName) {
        // Determine sorting direction based on current column state
        var currentColumn = document.querySelector(`th[data-sort=${columnName}]`);
        var sortOrder = currentColumn.classList.contains('asc') ? 'desc' : 'asc';

        // Remove sorting indicators from other columns
        var sortHeaders = document.querySelectorAll('.sort');
        sortHeaders.forEach(header => {
            if (header !== currentColumn) {
                header.classList.remove('asc', 'desc');
            }
        });


        // Add sorting indicator to current column
        currentColumn.classList.remove('asc', 'desc'); // Remove existing sorting classes
        currentColumn.classList.add(sortOrder);
        // Fetch users based on the selected column and sorting direction
        fetchUsers(currentPage, columnName, sortOrder);
    }


    // Function to perform search
    function performSearch() {
        var searchInput = document.querySelector('.search').value.toLowerCase();
        currentPage=1;
        status = document.getElementById("idStatus").value;

        fetchUsers(currentPage,'created_at','desc',searchInput);


    }




// Event listener for search input
    document.querySelector('.search').addEventListener('input', function() {
        performSearch();
    });

    window.sortByColumn = sortByColumn;
    window.performSearch = performSearch;
    // Initial fetch to load the first page of users
    fetchUsers(currentPage,'created_at','desc');
});




