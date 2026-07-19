export function initRegionSelector(config = {}) {
    const provSelect = document.getElementById(config.provinceSelectId || 'province_select');
    const regSelect = document.getElementById(config.regencySelectId || 'regency_select');
    
    if (!provSelect || !regSelect) return;

    const hiddenProvId = document.getElementById('province_id');
    const hiddenProvName = document.getElementById('province_name');
    const hiddenRegId = document.getElementById('regency_id');
    const hiddenRegName = document.getElementById('regency_name');

    if (config.isPublicForm !== true) {
        fetch("/admin/region/provinces")
            .then(response => response.json())
            .then(data => {
                const provinces = data.value || data;
                if (Array.isArray(provinces)) {
                    provinces.forEach(province => {
                        const option = new Option(province.name, province.id);
                        provSelect.add(option);
                    });

                    if (hiddenProvId && hiddenProvId.value) {
                        provSelect.value = hiddenProvId.value;
                        loadRegencies(hiddenProvId.value, hiddenRegId ? hiddenRegId.value : null);
                    }
                }
            })
            .catch(error => console.error('Error Fetch Provinsi:', error));
    } else {
        if (config.oldProvinceId) {
            loadRegencies(config.oldProvinceId, config.oldRegencyId);
        }
    }

    provSelect.addEventListener('change', function () {
        const provinceId = this.value;

        if (hiddenProvId) hiddenProvId.value = provinceId;
        if (hiddenProvName) hiddenProvName.value = this.selectedIndex > 0 ? this.options[this.selectedIndex].text : '';

        regSelect.innerHTML = `<option value="">${config.defaultRegencyText || '-- Pilih Kota/Kabupaten --'}</option>`;
        regSelect.disabled = true;
        regSelect.classList.add('bg-gray-50');
        
        if (hiddenRegId) hiddenRegId.value = '';
        if (hiddenRegName) hiddenRegName.value = '';

        if (!provinceId) return;
        loadRegencies(provinceId);
    });

    regSelect.addEventListener('change', function () {
        if (hiddenRegId) hiddenRegId.value = this.value;
        if (hiddenRegName) hiddenRegName.value = this.selectedIndex > 0 ? this.options[this.selectedIndex].text : '';
    });

    function loadRegencies(provinceId, selectedRegencyId = null) {
        regSelect.innerHTML = '<option value="">-- Memuat Data Wilayah... --</option>';
        regSelect.disabled = true;

        fetch(`/admin/region/regencies?id_provinsi=${provinceId}`)
            .then(res => {
                if (!res.ok) throw new Error('Respons server bermasalah');
                return res.json();
            })
            .then(data => {
                regSelect.innerHTML = `<option value="">${config.defaultRegencyText || '-- Pilih Kota/Kabupaten --'}</option>`;
                const regencies = data.value || data;

                if (Array.isArray(regencies) && regencies.length > 0) {
                    regencies.forEach(reg => {
                        const option = new Option(reg.name, reg.id);
                        regSelect.add(option);
                    });
                    
                    regSelect.disabled = false;
                    regSelect.classList.remove('bg-gray-50');

                    if (selectedRegencyId) {
                        regSelect.value = selectedRegencyId;
                        if (hiddenRegName) {
                            hiddenRegName.value = regSelect.selectedIndex > 0 ? regSelect.options[regSelect.selectedIndex].text : '';
                        }
                    }
                } else {
                    regSelect.innerHTML = '<option value="">Data tidak ditemukan</option>';
                }
            })
            .catch(err => {
                console.error("Gagal memuat kabupaten:", err);
                regSelect.innerHTML = '<option value="">Gagal memuat data wilayah</option>';
            });
    }
}