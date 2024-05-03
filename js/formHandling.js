import { requestData } from './APIHandle.js';
import { addParent, addTeacher, addStudent } from './addUsers.js';
import { getUsers, mode } from './main.js';
import { getUserType } from './addUsers.js';

const form = document.querySelector('form');
const input = document.querySelectorAll('input');
const selectHalaka = document.querySelector('.select_halaka');

const formData = new FormData();

input.forEach((el) => {
	el.onchange = () => {
		formData.append(el.name, el.value);
	};
});

let url = '';

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
			getUsers(addTeacher, addParent, addStudent);
			input.forEach((el) => {
				el.value = '';
			});
		});
	}
});
