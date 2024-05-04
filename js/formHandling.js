import { requestData } from './APIHandle.js';
import { addParent, addTeacher, addStudent } from './addUsers.js';
import { getUsers, mode } from './main.js';
import { getUserType } from './addUsers.js';

const form = document.querySelector('form');
const input = document.querySelectorAll('input');
const selectHalaka = document.querySelector('.select_halaka');
const success = document.querySelector('.alert-success');
const danger = document.querySelector('.alert-danger');
const phone = document.getElementById('phone');
const ssn = document.getElementById('ssn');
const halaka = document.querySelector('.halaka');

const formData = new FormData();

input.forEach((el) => {
	el.onchange = () => {
		formData.append(el.name, el.value);
	};
});

let url = '';

const makeInputNumbers = (e) => {
	if (!/[0-9]/g.test(e.key) && e.key !== 'Backspace') e.preventDefault();
};

form.addEventListener('submit', (e) => {
	e.preventDefault();
	if (mode === 'insert') {
		let user = getUserType();
		if (user === 'addTeacher') {
			url = 'admin/addteacher.php';
		} else if (user === 'addParent') {
			url = 'admin/addparent.php';
		} else if (user === 'addStudent') {
			url = 'admin/addstudent.php';
			formData.append(selectHalaka.name, selectHalaka.value);
		}
		requestData(url, { method: 'POST', body: formData }).then((data) => {
			console.log(data);
			if (data.success) {
				success.classList.remove('d-none');
				success.innerText = data.message;
				setTimeout(() => {
					success.classList.add('d-none');
				}, 3000);
				input.forEach((el) => {
					el.value = '';
				});
			} else {
				danger.classList.remove('d-none');
				danger.innerText = data.message;
				setTimeout(() => {
					danger.classList.add('d-none');
				}, 3000);
			}
			getUsers(addTeacher, addParent, addStudent);
		});
	}
});

if (phone) {
	phone.addEventListener('keydown', makeInputNumbers);
}
if (ssn) {
	ssn.addEventListener('keydown', makeInputNumbers);
}
if (halaka) {
	halaka.addEventListener('keydown', makeInputNumbers);
}
