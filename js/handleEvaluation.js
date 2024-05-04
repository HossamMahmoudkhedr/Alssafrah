const checkboxs = document.querySelectorAll('input[type="checkbox"]');
const replacements = document.querySelectorAll('.checkbox_replacement');

const fromSurah = document.getElementById('fromSurah');
const fromAyaNum = document.getElementById('fromAyaNum');
const revFromSurah = document.getElementById('revFromSurah');
const revToSurah = document.getElementById('revToSurah');
const toSurah = document.getElementById('toSurah');
const toAyaNum = document.getElementById('toAyaNum');

const selects = document.querySelectorAll('select');
const inputs = document.querySelectorAll('input');
const button = document.querySelector('button');

replacements.forEach((replacement) => {
	replacement.onclick = () => {
		replacement.classList.toggle('show');
		replacement.children[0].classList.toggle('show');

		checkboxs.forEach((checkbox) => {
			if (replacement.getAttribute('data-name') === checkbox.name) {
				checkbox.click();
			}
		});
	};
});

window.onload = () => {
	fetch('https://api.alquran.cloud/v1/meta')
		.then((response) => {
			return response.json();
		})
		.then((data) => {
			let html = `<option value="chooseSurah" disabled selected> إختر السورة</option>`;
			let quran = data.data.surahs.references;
			quran.map((surah) => {
				html += `<option data-id=${surah.number} value=${surah.name}>${surah.name}</option>`;
			});
			fromSurah.innerHTML = html;
			toSurah.innerHTML = html;
			revFromSurah.innerHTML = html;
			revToSurah.innerHTML = html;
		});
};

const getAyasNumber = (e) => {
	const target = e.target;
	const TargetDataId = e.target.getAttribute('data-name');
	if (target.value !== 'chooseSurah') {
		const id = target.value;
		fetch(`https://api.alquran.cloud/v1/surah/${id}`)
			.then((response) => {
				return response.json();
			})
			.then((data) => {
				let html = `<option value="ayaNum" disabled selected>رقم الآية</option>`;
				let ayahs = data.data.ayahs;
				ayahs.map((aya, index) => {
					html += `<option data-id=${index + 1} value=${index + 1}>${
						index + 1
					}</option>`;
				});

				selects.forEach((select) => {
					if (
						select.getAttribute('data-name') === TargetDataId &&
						select.getAttribute('name') === TargetDataId + '_number'
					) {
						select.innerHTML = html;
					}
				});
			});
	}
};

const sendData = (e) => {
	e.preventDefault();
	const formData = new FormData();
	let behavior = {};
	formData.append('id', '6');
	inputs.forEach((input) => {
		behavior[input.name] = input.value;
	});
	formData.append('behavior', behavior);
	selects.forEach((select) => {
		formData.append(select.name, select.value);
	});

	fetch('http://localhost/php/Alssafrah/api/teacher/evaluatestudent.php', {
		method: 'POST',
		body: formData,
	})
		.then((response) => {
			return response.json();
		})
		.then((data) => {
			console.log(data);
		});
};

fromSurah.addEventListener('change', getAyasNumber);
toSurah.addEventListener('change', getAyasNumber);
revFromSurah.addEventListener('change', getAyasNumber);
revToSurah.addEventListener('change', getAyasNumber);
button.addEventListener('click', sendData);
