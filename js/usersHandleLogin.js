import { requestData } from './APIHandle.js';
import { getUserType } from './addUsers.js';

// This page used to handle users login
const form = document.querySelector('form');
// const email = document.querySelector('#email');
// const password = document.querySelector('#password');
const input = document.querySelectorAll('input');
const formData = new FormData();

// Here we get the email value and save it in the formData object
input.forEach((el) => {
	el.onchange = () => {
		formData.append(el.name, el.value);
	};
});

// Here we get the password value and save it in the formData object
form.addEventListener('submit', (e) => {
	e.preventDefault();

	requestData('admin/adminlogin.php', { method: 'POST', body: formData })
		.then((data) => {
			console.log(data);
			window.location.href =
				'http://localhost/php/Alssafrah/pages/addTeacher.html';
		})
		.catch((error) => {
			console.error('There was a problem with the fetch operation:', error);
		});
});

window.onload = () => {
	let user = getUserType();
	if (user === 'teacherLogin') {
		formData.append('type', 'teacher');
	} else if (user === 'studentLogin') {
		formData.append('type', 'student');
	} else if (user === 'parentLogin') {
		formData.append('type', 'parent');
	} else if (user === 'adminLogin') {
		formData.append('type', 'admin');
	}
};
