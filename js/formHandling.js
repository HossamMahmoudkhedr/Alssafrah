import { requestData } from './APIHandle.js';

const form = document.querySelector('form');
const input = document.querySelectorAll('input');
const tableBody = document.querySelector('.table_body');

let href = window.location.toString();
let arr = href.split('/');
export let user = arr[arr.length - 1].split('.')[0];

const formData = new FormData();

input.forEach((el) => {
	el.onchange = () => {
		formData.append(el.name, el.value);
	};
});

let url;

const addTeacher = (teachersArr) => {
	let html = ``;
	teachersArr.map((teacher) => {
		let content = `
            <tr>
				<th scope="row">${teacher.id}</th>
				<td>${teacher.name}</td>
				<td>${teacher.email}</td>
				<td>${teacher.password}</td>
				<td>${teacher.phone}</td>
				<td>${teacher.Alhalka_Number}</td>
				<td>تعديل \ حذف</td>
			</tr>
        `;
		html += content;
	});
	tableBody.innerHTML = html;
};

const addParent = (parentArr) => {
	let html = ``;
	parentArr.map((parent) => {
		let content = `
            <tr>
				<th scope="row">${parent.id}</th>
				<td>${parent.name}</td>
				<td>${parent.phone}</td>
				<td>${teacher.password}</td>
				<td>تعديل \ حذف</td>
			</tr>
        `;
		html += content;
	});
	tableBody.innerHTML = html;
};

form.addEventListener('submit', (e) => {
	e.preventDefault();
	if (user === 'addTeacher') {
		url = 'admin/addteacher.php';
		requestData(url, formData, 'POST');
		fetch('http://localhost/php/Alssafrah/api/admin/allteachers.php')
			.then((respones) => respones.json())
			.then((data) => {
				addTeacher(data.data.teachers);
			});
	} else if (user === 'addParent') {
		url = 'admin/addparent.php';
		requestData(url, formData, 'POST');
		fetch('http://localhost/php/Alssafrah/api/admin/allparents.php')
			.then((respones) => respones.json())
			.then((data) => {
				addParent(data.data.parents);
			});
	}
});
