import { requestData } from './APIHandle.js';
import { addParent, addTeacher, addStudent } from './addUsers.js';
import { getUsers } from './main.js';
import { getUserType } from './addUsers.js';

const form = document.querySelector('form');
const input = document.querySelectorAll('input');
const selectHalaka = document.querySelector('.select_halaka');
const success = document.querySelector('.alert-success');
const danger = document.querySelector('.alert-danger');
const phone = document.getElementById('phone');
const ssn = document.getElementById('ssn');
const halaka = document.querySelector('.halaka');
const button = document.querySelector('button');

let url = '';

const makeInputNumbers = (e) => {
	const isNumber = /[0-9]/.test(e.key);
	const isShortcutKey = e.ctrlKey || e.metaKey;
	const isBackspace = e.key === 'Backspace' || e.key === 'Delete';

	if (!isNumber && !isShortcutKey && !isBackspace) {
		e.preventDefault();
	}
};

const edit = (id) => {
	let editUrl = '';
	const user = getUserType();
	if (user === 'addTeacher') {
		url = `admin/getteacher.php?id=${id}`;
		editUrl = 'admin/editteacher.php';
	} else if (user === 'addParent') {
		url = `admin/getparent.php?id=${id}`;
		editUrl = 'admin/editparent.php';
	} else if (user === 'addStudent') {
		url = `admin/getstudent.php?id=${id}`;
		editUrl = 'admin/editstudent.php';
	}
	if (window.localStorage.getItem('mode') === 'edit') {
		const formData = new FormData();
		formData.append('id', id);
		input.forEach((el) => {
			formData.append(el.name, el.value);
		});
		if (user === 'addStudent') {
			formData.append(selectHalaka.name, selectHalaka.value);
		}
		requestData(editUrl, { method: 'POST', body: formData }).then((data) => {
			getUsers(addTeacher, addParent, addStudent);

			if (data.success) {
				success.classList.remove('d-none');
				success.innerText = data.message;
				setTimeout(() => {
					success.classList.add('d-none');
				}, 3000);
				input.forEach((el) => {
					el.value = '';
				});
				if (user === 'addStudent') {
					selectHalaka.value = '1';
				}
				// setMode('insert');
				window.localStorage.setItem('mode', 'insert');
				button.innerText = 'إضافة';
				formData.forEach((el) => {
					formData.delete(el.name);
				});
			} else {
				danger.classList.remove('d-none');
				danger.innerText = data.message;
				setTimeout(() => {
					danger.classList.add('d-none');
				}, 3000);
			}
		});
	}
};

form.addEventListener('submit', (e) => {
	e.preventDefault();
	if (window.localStorage.getItem('mode') === 'insert') {
		const formData = new FormData();
		input.forEach((el) => {
			formData.append(el.name, el.value);
		});
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
	} else {
		edit(window.localStorage.getItem('editID'));
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
