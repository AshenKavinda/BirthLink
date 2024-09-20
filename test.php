<div class="modal fade" id="centerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Add New Center</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="province" class="form-label">Province</label>
                    <select class="form-select" id="province" onchange="updateDistricts()">
                        <option value="">Select Province</option>
                        <option value="Central Province">Central Province</option>
                        <option value="Southern Province">Southern Province</option>
                        <option value="Northern Province">Northern Province</option>
                        <option value="North Central Province">North Central Province</option>
                        <option value="Eastern Province">Eastern Province</option>
                        <option value="Western Province">Western Province</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="district" class="form-label">District</label>
                    <select class="form-select" id="district" onchange="updateAreas()">
                        <option value="">Select District</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="area" class="form-label">Area</label>
                    <select class="form-select" id="area">
                        <option value="">Select Area</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dark" onclick="addNewCenter()">Add</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    const data = [
        { name: "Kandy Town Midwife Clinic", area: "Kandy Town", district: "Kandy", province: "Central Province" },
        { name: "Galle Fort Midwife Clinic", area: "Galle Fort", district: "Galle", province: "Southern Province" },
        { name: "Jaffna Town Midwife Clinic", area: "Jaffna Town", district: "Jaffna", province: "Northern Province" },
        { name: "Anuradhapura Town Midwife Clinic", area: "Anuradhapura Town", district: "Anuradhapura", province: "North Central Province" },
        { name: "Batticaloa Town Midwife Clinic", area: "Batticaloa Town", district: "Batticaloa", province: "Eastern Province" },
        { name: "Nuwara Eliya Town Midwife Clinic", area: "Nuwara Eliya Town", district: "Nuwara Eliya", province: "Central Province" },
        { name: "Matara Town Midwife Clinic", area: "Matara Town", district: "Matara", province: "Southern Province" },
        { name: "Negombo Town Midwife Clinic", area: "Negombo Town", district: "Gampaha", province: "Western Province" },
        { name: "Vavuniya Town Midwife Clinic", area: "Vavuniya Town", district: "Vavuniya", province: "Northern Province" },
        { name: "Hiyare Midwife Clinic", area: "Hiyare", district: "Galle", province: "Southern Province" },
        { name: "Wakwella Midwife Clinic", area: "Wakwella", district: "Galle", province: "Southern Province" }
    ];

    function updateDistricts() {
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');
        const areaSelect = document.getElementById('area');

        districtSelect.innerHTML = '<option value="">Select District</option>';
        areaSelect.innerHTML = '<option value="">Select Area</option>';

        const selectedProvince = provinceSelect.value;
        const districts = new Set();

        data.forEach(entry => {
            if (entry.province === selectedProvince) {
                districts.add(entry.district);
            }
        });

        districts.forEach(district => {
            const option = document.createElement('option');
            option.value = district;
            option.textContent = district;
            districtSelect.appendChild(option);
        });
    }

    function updateAreas() {
        const districtSelect = document.getElementById('district');
        const areaSelect = document.getElementById('area');

        areaSelect.innerHTML = '<option value="">Select Area</option>';

        const selectedDistrict = districtSelect.value;
        const areas = new Set();

        data.forEach(entry => {
            if (entry.district === selectedDistrict) {
                areas.add(entry.area);
            }
        });

        areas.forEach(area => {
            const option = document.createElement('option');
            option.value = area;
            option.textContent = area;
            areaSelect.appendChild(option);
        });
    }

    function addNewCenter() {
        // Add functionality to handle the form submission.
        const province = document.getElementById('province').value;
        const district = document.getElementById('district').value;
        const area = document.getElementById('area').value;
        const name = document.getElementById('name').value;

        // Handle the data as required (e.g., sending it to a server).
        console.log({ province, district, area, name });
    }
</script>
