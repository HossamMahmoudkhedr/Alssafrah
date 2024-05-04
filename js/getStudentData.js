import { requestData } from './APIHandle.js';

const inputs = document.querySelectorAll('input');
window.onload = () => {
	const type = window.localStorage.getItem('type');
	requestData(`${type}/${type}data.php`, { method: 'GET' }).then((data) => {
		inputs.forEach((input) => {
			input.value = data.data[input.name];
		});
	});
};
