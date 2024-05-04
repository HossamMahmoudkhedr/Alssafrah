import { requestData } from './APIHandle.js';

const fromSurah = document.getElementById('fromSurah');
const toSurah = document.getElementById('toSurah');
const revFromSurah = document.getElementById('revFromSurah');
const revToSurah = document.getElementById('revToSurah');

const keys = [
	'new_sura_start_name',
	'new_sura_end_name',
	'revision_sura_start_name',
	'revision_sura_end_name',
];
const elements = [fromSurah, toSurah, revFromSurah, revToSurah];
const inputs = document.querySelectorAll('input');
const checkboxes = document.querySelectorAll('[type="checkbox"]');
window.onload = () => {
	const type = window.localStorage.getItem('type');
	requestData(`${type}/${type}data.php`, { method: 'GET' }).then((data) => {
		keys.map((key, i) => {
			const theKey = data.data[key];
			fetch(`https://api.alquran.cloud/v1/surah/${data.data[key]}`)
				.then((response) => {
					return response.json();
				})
				.then((data) => {
					if (data.data.number == theKey) {
						elements[i].value = data.data.name;
					}
				});
			inputs.forEach((input) => {
				if (input.value === '') {
					input.value = data.data[input.name];
				}
			});

			const behaviorList = data.data.behavior.split(',');

			checkboxes.forEach((checkbox, i) => {
				if (behaviorList.includes(checkbox.name)) {
					checkbox.checked = true;
				}
			});
			handleCheckboxes();
		});
	});
};

const handleCheckboxes = () => {
	const checkboxs = document.querySelectorAll('[type="checkbox"]');
	const replacements = document.querySelectorAll('.checkbox_replacement');
	replacements.forEach((replacement) => {
		checkboxs.forEach((checkbox) => {
			if (
				replacement.getAttribute('data-name') === checkbox.name &&
				checkbox.checked
			) {
				replacement.classList.add('show');
				replacement.children[0].classList.add('show');
			}
		});
	});
};
