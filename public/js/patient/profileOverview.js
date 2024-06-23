
const patientId = document.getElementById('patientIdField').value;
const tableBody = document.getElementById('dataTableBody');
// Section buttons
const vaccineButton = document.getElementById('vaccineButton'), reportButton = document.getElementById('reportButton');

showVaccinationData(); // Show vaccine details on load

vaccineButton.addEventListener('click', e => {
    showVaccinationData();

    if(!vaccineButton.classList.contains('active')){
        vaccineButton.classList.add('active');
        reportButton.classList.remove('active');
    }
});

reportButton.addEventListener('click', e => {
    showReportData();

    if(!reportButton.classList.contains('active')){
        reportButton.classList.add('active');
        vaccineButton.classList.remove('active');
    }
});

async function showVaccinationData(){
    let vaccinations = await getVaccinationData();

    let template =
    `<div class="vhead">
        <div class="vtr">
            <div>#</div>
            <div>Brand</div>
            <div class="d-none d-md-block">Name</div>
            <div class="d-none d-md-block">Location</div>
            <div >Date</div>
            <div class="d-none d-md-block">Dose</div>
            <div>
                <span class="material-symbols-outlined">
                    description
                </span>
            </div>
        </div>
    </div>
    <div class="vbody">`;

    if(vaccinations == null || vaccinations.lenght < 0) return;

    for (const vaccine of vaccinations) {
        template +=
        `<div class="vtr">
            <div class="tr">
                <div class="d-flex">
                    <span class="d-none d-md-block">${vaccine.id}</span>
                </div>
                <div>${vaccine.vaccine_name.vaccine_brand.brand_name}</div>
                <div class="d-none d-md-block">${vaccine.vaccine_name.vaccine_name}</div>
                <div class="d-none d-md-block">${vaccine.hospital.name}</div>
                <div>${vaccine.date_administered}</div>
                <div class="d-none d-md-block">${vaccine.dose}</div>
                <div>
                    <button type="button" class="p-0 border-0 bg-transparent"
                        data-bs-toggle="collapse" data-bs-target="#collapse${vaccine.id}"
                        aria-expanded="false" aria-controls="collapse${vaccine.id}">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            </div>

            <div class="notes px-3 py-2 collapse" id="collapse${vaccine.id}">
                <h6 class="mt-2">Description : </h6>
                <p>
                    ${vaccine.description}
                </p>
            </div>
        </div>`;
    }

    template += `</div>`;

    tableBody.innerHTML = template;
}

async function showReportData(){
    let reports = await getReportData();

    let template =
    `<div class="vhead">
        <div class="vtr">
            <div>#</div>
            <div>Report Type</div>
            <div class="d-none d-md-block">Medical Institution</div>
            <div>Date</div>
            <div>
                <span class="material-symbols-outlined">
                    description
                </span>
            </div>
        </div>
    </div>
    <div class="vbody">`;

    if(reports == null || reports.lenght < 0) return;

    for (const report of reports) {

        template +=
        `<div class="vtr">
            <div class="tr">
                <div class="d-flex">
                    <span class="d-none d-md-block">${report.id}</span>
                </div>
                <div>${report.record_type}</div>
                <div class="d-none d-md-block">${report.hospital.name}</div>
                <div class="d-none d-md-block">${report.formatted_created_at}</div>
                <div>
                    <button type="button" class="p-0 border-0 bg-transparent"
                        data-bs-toggle="collapse" data-bs-target="#collapse${report.id}"
                        aria-expanded="false" aria-controls="collapse${report.id}">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            </div>

            <div class="notes px-3 py-2 collapse" id="collapse${report.id}">
                <h6 class="mt-2">Notes : </h6>
                <p>
                    ${report.description}

                    <a href="${report.file_path}" target="_blank" class="d-block mt-3">Download Attacthment</a>
                </p>
            </div>
        </div>`;
    }

    template += `</div>`;

    tableBody.innerHTML = template;
}

// Get vaccination details of the patient
async function getVaccinationData(){

    return await fetch(`http://127.0.0.1:8000/patient/data/vaccinations?id=${patientId}`,{
        method : 'GET',
        headers : {
            'Content-Type':'application/json'
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

async function getReportData(){

    return await fetch(`/patient/data/reports`,{
        method : 'GET',
        headers : {
            'Content-Type':'application/json'
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
