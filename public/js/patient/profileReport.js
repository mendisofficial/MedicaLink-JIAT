const tableBody = document.getElementById('dataTableBody');
const popUpContainer = document.getElementById('pop-up-container');
const popUp = document.getElementById('pop-up');
const popUpCloseButton = document.getElementById('pop-up-close');

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
    let vaccinations = await getVaccinationData();

    let template =
        `<thead>
        <tr>
            <th scope="col" class="d-none d-lg-table-cell">#</th>
            <th scope="col">Brand</th>
            <th scope="col" class="d-none d-md-table-cell">Name</th>
            <th scope="col">Location</th>
            <th scope="col">Date</th>
            <th scope="col" class="d-none d-md-table-cell">Dose</th>
            <th scope="col" class="d-none d-lg-table-cell"></th>
        </tr>
    </thead>
    <tbody>`;

    if (vaccinations == null || vaccinations.lenght < 0) {
        tableBody.innerHTML = '<strong>No results were found....</strong>'
        return;
    }

    for (const vaccine of vaccinations) {

        template +=
            `<tr>
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
    for (let i =0; i < tableRows.length; i++) {
        const row = tableRows[i];
        const vaccination = vaccinations[i];

        row.addEventListener('touchend', e => {
            showOverviewPopUp(vaccination,true);
            showPopUp();
        });

        row.querySelector('.view-more').addEventListener('click', e => {
            showOverviewPopUp(vaccination,true);
            showPopUp();
        });
    }
}

async function showReportData() {
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
            `<tr>
            <th scope="row" class="d-none d-lg-table-cell">${report.id}</th>
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
    for (let i =0; i < tableRows.length; i++) {
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
        `http://127.0.0.1:8000/patient/data/vaccinations/search?query=${searchFormData.get('query')}&type=${searchFormData.get('type')}`;

    return await fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(
            response => {
                console.log(response);
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
        `http://127.0.0.1:8000/patient/data/reports/search?query=${searchFormData.get('query')}&type=${searchFormData.get('type')}`;

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

function showPopUp(){

    showTimeLine.play();
}

function hidePopUp(){


    closeTimeLine.play();
}

/**
 *
 * @param {JSON} data - A Vaccine or Medical Record data object
 * @param {Boolean} isVaccine - Indicates the type of the data object (vaccine or medical record)
 */
function showOverviewPopUp(data = {isEditable : true}, isVaccine = true) {

    let template =
    `<h4 class="mt-3 mt-md-0">${ isVaccine? 'Vaccination' : 'Medical Record'} Details - ${data.id}</h4>

    <div class="container-fluid mt-3 px-0">
        <div class="row gx-0">

        ${ isVaccine? (
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

            <div class="col-12 col-md-6">
                <div class="record">
                    <span class="title">Attachment :</span>
                    <span class="value"><a href="${data.file_path}" class="text-decoration-none" target="_blank">Download Report<a/></span>
                </div>
            </div>`
        ) }

        </div>
    </div>`;

    const popUpContent = popUp.querySelector('#pop-up-content');
    popUpContent.innerHTML = template;
}
