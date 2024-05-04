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
let url = '';
let user = getUserType();
let person = '';
window.onload = () => {
	if (user === 'teacherLogin') {
		person = 'teacher';
		url = 'pages/studentsBoard.html';
	} else if (user === 'studentLogin') {
		person = 'student';
		url = 'pages/studentResults.html';
	} else if (user === 'parentLogin') {
		person = 'parent';
		url = 'pages/childrenBoard.html';
	} else if (user === 'adminLogin') {
		person = 'admin';
		url = 'pages/addTeacher.html';
	}
	formData.append('type', person);
};
// Here we get the password value and save it in the formData object
form.addEventListener('submit', (e) => {
	e.preventDefault();

	requestData(`${person}/${user.toLowerCase()}.php`, {
		method: 'POST',
		body: formData,
	}).then((data) => {
		console.log(data);
		if (data.success) {
			window.localStorage.setItem('type', data.data.type);
			window.location.href = `http://localhost/php/Alssafrah/${url}`;
		}
	});
});
