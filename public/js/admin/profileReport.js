const patientId = document.getElementById('patientIdField').value;
const tableBody = document.getElementById('dataTableBody');
const popUpContainer = document.getElementById('pop-up-container');
const popUp = document.getElementById('pop-up');
const popUpCloseButton = document.getElementById('pop-up-close');
const resultTitlesSection = document.getElementById('result-titles');

const vaccineButton = document.getElementById('vaccineButton'), reportButton = document.getElementById('reportButton'); // Section buttons
const searchBarForm = document.querySelector('#search-controls-section form'); // Search Bar Form

// The function which should be used to search in a given time (reports search function or vaccination search function)
let activeSearchFunction = showVaccinationData;

let showTimeLine = anime.timeline({ // The timeline for showing the poup
    easing: 'easeOutQuint',
    autoplay: false
});

let closeTimeLine = anime.timeline({ // The timeline for hiding the pop up
    easing: 'easeOutQuint',
    autoplay: false
});

const vaccinationAddButtonHandler = () => {
    showInsertPopUp(true);
    showPopUp();
}

const reportAddButtonHandler = () => {
    showInsertPopUp(false);
    showPopUp();
}

init(); // Initialize data and add event listeners
activeSearchFunction();

function init() {

    showTimeLine.add({
        targets: popUp,
        scaleY: {
            value: ['0', '1'],
            duration: 550
        },
        begin: anim => {
            popUpContainer.classList.remove('d-none');
            popUpContainer.classList.remove('bg-transparent');
        }
    });

    closeTimeLine.add({
        targets: popUp,
        scaleY: {
            value: ['1', '0'],
            duration: 650
        },
        begin: anim => {
            popUpContainer.classList.add('bg-transparent');
        },
        complete: anim => {
            popUpContainer.classList.add('d-none');
        }
    });

    vaccineButton.addEventListener('click', e => {

        showVaccinationData(); // Show all vaccination data

        if (!vaccineButton.classList.contains('active')) { // change the active button
            vaccineButton.classList.add('active');
            reportButton.classList.remove('active');
        }

        activeSearchFunction = showVaccinationData; // Change the active search function
    });

    reportButton.addEventListener('click', e => {

        showReportData(); // Show all vaccination data

        if (!reportButton.classList.contains('active')) { // change the active button
            reportButton.classList.add('active');
            vaccineButton.classList.remove('active');
        }

        activeSearchFunction = showReportData;
    });

    searchBarForm.addEventListener('submit', e => {
        e.preventDefault();

        activeSearchFunction();
    })

    popUpCloseButton.addEventListener('click', e => {
        hidePopUp();
    });
}

async function showVaccinationData() {
    //Change the result section title and add button event handler
    resultTitlesSection.querySelector('h5').innerText = 'Vaccination Details';
    resultTitlesSection.querySelector('.add-btn span').innerText = 'Add Vaccination';

    resultTitlesSection.querySelector('.add-btn').removeEventListener('click',reportAddButtonHandler);
    resultTitlesSection.querySelector('.add-btn').addEventListener('click',vaccinationAddButtonHandler);

    let vaccinations = await getVaccinationData();

    let template =
        `<thead>
        <tr>
            <th scope="col" class="d-none d-lg-table-cell">ID</th>
            <th scope="col">Brand</th>
            <th scope="col" class="d-none d-md-table-cell">Name</th>
            <th scope="col">Location</th>
            <th scope="col">Date</th>
            <th scope="col" class="d-none d-md-table-cell">Dose</th>
            <th scope="col" class="d-none d-lg-table-cell"></th>
        </tr>
    </thead>
    <tbody>`;

    if (vaccinations == null || vaccinations.lenght < 0) return;

    for (const vaccine of vaccinations) {

        template +=
            `<tr class="${vaccine.isEditable ? 'editable' : ''}">
            <th scope="row" class="d-none d-lg-table-cell">${vaccine.id}</th>
            <td>${vaccine.vaccine_name.vaccine_brand.brand_name}</td>
            <td class="d-none d-md-table-cell">${vaccine.vaccine_name.vaccine_name}</td>
            <td>${vaccine.hospital.name}</td>
            <td>${vaccine.date_administered}</td>
            <td class="d-none d-md-table-cell">${vaccine.dose}</td>
            <td class="d-none d-lg-table-cell">
                <div class="d-none d-lg-flex justify-content-end align-items-center">
                    <button class="view-more">
                        <span class="material-symbols-outlined">
                            read_more
                        </span>
                    </button>
                </div>
            </td>
        </tr>`;
    }

    template += `</tbody>`;
    tableBody.innerHTML = template;

    let tableRows = tableBody.querySelectorAll('tbody tr');
    for (let i = 0; i < tableRows.length; i++) {
        const row = tableRows[i];
        const vaccination = vaccinations[i];

        row.addEventListener('touchend', e => {
            showOverviewPopUp(vaccination, true);
            showPopUp();
        });

        row.querySelector('.view-more').addEventListener('click', e => {
            showOverviewPopUp(vaccination, true);
            showPopUp();
        });
    }
}

async function showReportData() {
    //Change the result section title and add button event handler
    resultTitlesSection.querySelector('h5').innerText = 'Report Details';
    resultTitlesSection.querySelector('.add-btn span').innerText = 'Add Report';


    resultTitlesSection.querySelector('.add-btn').removeEventListener('click',vaccinationAddButtonHandler);
    resultTitlesSection.querySelector('.add-btn').addEventListener('click',reportAddButtonHandler);

    let reports = await getReportData();

    let template =
        `<thead>
        <tr>
            <th scope="col" class="d-none d-lg-table-cell">#</th>
            <th scope="col">Report Type</th>
            <th scope="col" class="d-none d-md-table-cell">Medical Institution</th>
            <th scope="col">Date</th>
            <th scope="col" class="d-none d-lg-table-cell"></th>
        </tr>
    </thead>
    <tbody>`;

    if (reports == null || reports.lenght < 0) return;

    for (const report of reports) {

        template +=
            `<tr class="${report.isEditable ? 'editable' : ''}">
            <th scope="row" class="d-none d-lg-table-cell">22 : 25</th>
            <td>${report.record_type}</td>
            <td class="d-none d-md-table-cell">${report.hospital.name}</td>
            <td>${report.formatted_created_at}</td>
            <td class="d-none d-lg-table-cell">
                <div class="d-none d-lg-flex justify-content-end align-items-center">
                    <button class="view-more">
                        <span class="material-symbols-outlined">
                            read_more
                        </span>
                    </button>
                </div>
            </td>
        </tr>`;
    }

    template += `</tbody>`;
    tableBody.innerHTML = template;

    let tableRows = tableBody.querySelectorAll('tbody tr');
    for (let i = 0; i < tableRows.length; i++) {
        const row = tableRows[i];
        const report = reports[i];

        row.addEventListener('touchend', e => {
            showOverviewPopUp(report, false);
            showPopUp();
        });

        row.querySelector('.view-more').addEventListener('click', e => {
            showOverviewPopUp(report, false);
            showPopUp();
        })
    }
}

// Get vaccination details of the patient
async function getVaccinationData() {

    let searchFormData = new FormData(searchBarForm);
    const url =
        `http://127.0.0.1:8000/admin/patient/data/vaccinations/search?id=${patientId}&query=${searchFormData.get('query')}&type=${searchFormData.get('type')}`;

    return await fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(
            response => {
                return response.json();
            }
        )
        .catch(error => {
            console.log(error);
        })
}

async function getReportData() {

    let searchFormData = new FormData(searchBarForm);
    const url =
        `http://127.0.0.1:8000/admin/patient/data/reports/search?id=${patientId}&query=${searchFormData.get('query')}&type=${searchFormData.get('type')}`;

    console.log(url);
    return await fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(
            response => {
                return response.json();
            }
        )
        .catch(error => {
            console.log(error);
        })
}

function showPopUp() {

    showTimeLine.play();
}

function hidePopUp() {


    closeTimeLine.play();
}

// Function to fetch vaccine brands and populate the dropdown
async function fetchVaccineBrands() {
    const url = 'http://127.0.0.1:8000/admin/patient/data/vaccine-brands';

    await fetch(url)
        .then(response => response.json())
        .then(data => {
            const vaccineBrandDropdown = document.getElementById('vaccineBrand');
            data.forEach(brand => {
                let option = document.createElement('option');
                option.value = brand.id;
                option.text = brand.brand_name;
                vaccineBrandDropdown.appendChild(option);
            });

            document.getElementById('vaccineBrand').addEventListener('change', function() {
                const brandId = this.value;

                for (const brand of data) {

                    if(brand.id == brandId){
                        const vaccineNameDropdown = document.getElementById('vaccineNames');
                        vaccineNameDropdown.innerHTML = '<option selected disabled>Select a brand</option>';

                        for (const vaccine of brand.vaccine_names) {
                            vaccineNameDropdown.innerHTML += `<option value="${vaccine.id}">${vaccine.vaccine_name}</option>`;
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching vaccine brands:', error));
}

async function updateVaccination(data) {
    const url = `http://127.0.0.1:8000/admin/patient/vaccinations/update`;

    return await fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: data
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                hidePopUp();
                showVaccinationData();
            } else {
                alert('Failed to update vaccination');
            }
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred. Please try again.');
        });
}

async function insertVaccination(data) {
    const url = `http://127.0.0.1:8000/admin/patient/vaccinations/add`;

    return await fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: data
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                hidePopUp();
                showVaccinationData();
            } else {
                alert('Failed to insert vaccination');
            }
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred. Please try again.');
        });
}

async function insertMedicalRecord(data) {
    const url = `http://127.0.0.1:8000/admin/patient/reports/add`;

    return await fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: data
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                hidePopUp();
                showReportData();
            } else {
                alert('Failed to insert medical record');
            }
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred. Please try again.');
        });
}

async function updateMedicalRecord(data) {
    const url = `http://127.0.0.1:8000/admin/patient/reports/update`;

    return await fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: data
    })
        .then(response => response.json())
        .then(result => {
            //console.log(result);
            if (result.success) {
                alert(result.message);
                hidePopUp();
                showReportData();
            } else {
                alert('Failed to update medical record');
            }
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred. Please try again.');
        });
}

/**
 *
 * @param {JSON} data - A Vaccine or Medical Record data object
 * @param {Boolean} isVaccine - Indicates the type of the data object (vaccine or medical record)
 */
function showOverviewPopUp(data = { isEditable: true }, isVaccine = true) {

    let template =
        `<h4 class="mt-3 mt-md-0">${isVaccine ? 'Vaccination' : 'Medical Record'} Details - ${data.id}</h4>

    ${data.isEditable ? (
            `<div class="d-flex mt-3 mt-md-0 edit-btn-container">
            <button class="edit-btn shadow" id="edit-btn">
                <span class="me-2">Edit Record</span>
                <span class="material-symbols-outlined">
                    edit_note
                </span>
            </button>
        </div>`
        ) : ''}

    <div class="container-fluid mt-3 px-0">
        <div class="row gx-0">

        ${isVaccine ? (
            `<div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Vaccine Brand :</span>
                    <span class="value">${data.vaccine_name.vaccine_brand.brand_name}</span>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Vaccine Name :</span>
                    <span class="value">${data.vaccine_name.vaccine_name}</span>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Vaccinated Location :</span>
                    <span class="value">${data.hospital.name}</span>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Dose :</span>
                    <span class="value">${data.dose}</span>
                </div>
            </div>

            <div class="col-12">
                <div class="record">
                    <span class="title">Description :</span>
                    <p class="value">${data.description}</p>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Created On :</span>
                    <span class="value">${data.formatted_created_at}</span>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Last Updated :</span>
                    <span class="value">${data.formatted_updated_at}</span>
                </div>
            </div>`
        ) : (
            `<div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Record Type :</span>
                    <span class="value">${data.record_type}</span>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Medical Institute :</span>
                    <span class="value">${data.hospital.name}</span>
                </div>
            </div>

            <div class="col-12">
                <div class="record">
                    <span class="title">Description :</span>
                    <p class="value">
                        ${data.description}
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Created On :</span>
                    <span class="value">${data.formatted_created_at}</span>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Last Updated :</span>
                    <span class="value">${data.formatted_updated_at}</span>
                </div>
            </div>

            <div class="col-12">
                <div class="record">
                    <span class="title">Attachment :</span>
                    <span class="value">
                    ${data.file_path?
                    `<a href="${data.file_path}" class="text-decoration-none" target="_blank">Download Report<a/>`:
                    'No attachments'}
                    </span>
                </div>
            </div>`
        )}

        </div>
    </div>`;

    const popUpContent = popUp.querySelector('#pop-up-content');
    popUpContent.innerHTML = template;

    if (data.isEditable) {
        popUpContent.querySelector('#edit-btn').addEventListener('click', e => {
            // Show the edit form
            showEditPopUp(data, isVaccine);
        });
    }
}

function showEditPopUp(data, isVaccine) {
    let template = `
    <h4 class="mt-3 mt-md-0">${isVaccine ? 'Vaccination' : 'Medical Record'} Details - ${data.id}</h4>
    <div class="d-flex mt-3 mt-md-0 cancel-btn-container">
        <button class="cancel-btn shadow" id="cancel-btn">
            <span class="me-2">Cancel</span>
            <span class="material-symbols-outlined">
                close
            </span>
        </button>
    </div>
    <div class="mt-5">
        <form class="row g-3 mx-0" id="edit-form" action="/admin/patient/vaccinations/update" method="POST">
            <input type="hidden" id="patientId" name="patient_id" value="${data.patient_id}">
            ${isVaccine ? `
                <input type="hidden" id="vaccination_id" name="vaccination_id" value="${data.id}">
                <div class="col-12 col-md-6">
                    <label for="vaccineBrand" class="form-label">Vaccine Brand</label>
                    <select id="vaccineBrand" class="form-select">
                        <option selected disabled>Select Vaccine Brand</option>
                        <!-- Options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="vaccineNames" class="form-label">Vaccine Name</label>
                    <select id="vaccineNames" class="form-select" name="vaccine_id">
                        <option selected disabled>Select Vaccine Name</option>
                        <!-- Options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" value="${data.hospital.name}" disabled>
                </div>
                <div class="col-12 col-md-6">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date_administered" value="${data.date_administered}">
                </div>
                <div class="col-12 col-md-6">
                    <label for="dose" class="form-label">Dose</label>
                    <input type="text" class="form-control" name="dose" id="dose" value="${data.dose}">
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control">${data.description}</textarea>
                </div>
            ` : `
                <input type="hidden" id="record_id" name="record_id" value="${data.id}">
                <div class="col-12 col-md-6">
                    <label for="recordType" class="form-label">Record Type</label>
                    <input type="text" class="form-control" id="recordType" name="record_type" value="${data.record_type}">
                </div>
                <div class="col-12 col-md-6">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" value="${data.hospital.name}" disabled>
                </div>
                <div class="col-12 col-md-6">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date_created_at" value="${data.formatted_created_at}">
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control">${data.description}</textarea>
                </div>
                <div class="col-12">
                    <label for="fileInput" class="form-label">Attachment</label>
                    <input type="file" id="fileInput" name="file" class="form-control">
                </div>
            `}
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Save Record</button>
            </div>
        </form>
    </div>`;

    const popUpContent = popUp.querySelector('#pop-up-content');
    popUpContent.innerHTML = template;

    if(isVaccine) {
        fetchVaccineBrands();
        document.getElementById('vaccineBrand').value = data.vaccine_name.vaccine_brand.id;
        document.getElementById('vaccineNames').value = data.vaccine_id;
    }

    document.getElementById('edit-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        if(isVaccine){
            // Make an update request for vaccination
            const updateData = new FormData(e.target);

            await updateVaccination(updateData);
        }
        else{
            // Make an update request for medical record
            const updateData = new FormData(e.target);

            await updateMedicalRecord(updateData);
        }
    });

    popUpContent.querySelector('#cancel-btn').addEventListener('click', e => {
        // Cancel the edit form
        showOverviewPopUp(data, isVaccine);
    });
}

function showInsertPopUp(isVaccine) {
    let template = `
    <h4 class="mt-3 mt-md-0">${isVaccine ? 'Vaccination' : 'Medical Record'} Details</h4>
    <div class="mt-5">
        <form class="row g-3 mx-0" id="edit-form">
            <input type="hidden" id="patientId" name="patient_id" value="${patientId}">
            ${isVaccine ? `
                <div class="col-12 col-md-6">
                    <label for="vaccineBrand" class="form-label">Vaccine Brand</label>
                    <select id="vaccineBrand" class="form-select">
                        <option selected disabled>Select Vaccine Brand</option>
                        <!-- Options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="vaccineNames" class="form-label">Vaccine Name</label>
                    <select id="vaccineNames" class="form-select" name="vaccine_id">
                        <option selected disabled>Select Vaccine Name</option>
                        <!-- Options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date_administered">
                </div>
                <div class="col-12 col-md-6">
                    <label for="dose" class="form-label">Dose</label>
                    <input type="text" class="form-control" id="dose" name="dose">
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Notes / Description</label>
                    <textarea id="description" class="form-control" name="description"></textarea>
                </div>
            ` : `
                <div class="col-12 col-md-6">
                    <label for="record_type" class="form-label">Record Type</label>
                    <input type="text" class="form-control" id="record_type" name="record_type">
                </div>
                <div class="col-12 col-md-6">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date_administered">
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>
                <div class="col-12">
                    <label for="fileInput" class="form-label">Attachment</label>
                    <input type="file" id="fileInput" name="file" class="form-control">
                </div>
            `}
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Save Record</button>
            </div>
        </form>
    </div>`;

    const popUpContent = popUp.querySelector('#pop-up-content');
    popUpContent.innerHTML = template;

    if(isVaccine){ fetchVaccineBrands(); }

    document.getElementById('edit-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        if(isVaccine){
            // Make an insert request for vaccination
            const insertData = new FormData(e.target);

            await insertVaccination(insertData);
        }
        else{
            // Make an insert request for medical record
            const insertData = new FormData(e.target);

            await insertMedicalRecord(insertData);
        }
    });
}
