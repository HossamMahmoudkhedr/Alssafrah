import { requestData } from './APIHandle.js';

const form = document.querySelector('form');
const input = document.querySelectorAll('input');

let href = window.location.toString();
let arr = href.split('/');
let user = arr[arr.length - 1].split('.')[0];
// http://localhost/php/Alssafrah/api/

const formData = new FormData();

input.forEach((el) => {
	el.onchange = () => {
		formData.append(el.name, el.value);
	};
});

let url;

form.addEventListener('submit', (e) => {
	e.preventDefault();
	url = 'admin/addteacher.php';
	if (user === 'addTeacher') {
		requestData(url, formData, 'POST');
	}
});
