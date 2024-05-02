import { user } from './formHandling.js';
const sidebar = document.querySelector('.sidebar');
const menu = document.querySelector('.menu');
const close = document.querySelector('.close');
const tableBody = document.querySelector('.table_body');
const selectHalaka = document.querySelector('.select_halaka');

const openSidebar = () => {
	sidebar.classList.add('show');
	document.body.style.overflowX = 'hidden';
};

const closeSidebar = () => {
	sidebar.classList.remove('show');
	document.body.style.overflowX = 'unset';
};

menu.addEventListener('click', openSidebar);
close.addEventListener('click', closeSidebar);

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
				<td>${parent.password}</td>
				<td>تعديل \ حذف</td>
			</tr>
        `;
		html += content;
	});
	tableBody.innerHTML = html;
};
const addStudent = (studentArr) => {
	let html = ``;
	studentArr.map((student) => {
		let content = `
            <tr>
				<th scope="row">${student.id}</th>
				<td>${student.name}</td>
				<td>${student.ssn}</td>
				<td>${student.parent_phone}</td>
				<td>${student.Alhalka_Number}</td>
				<td>تعديل \ حذف</td>
			</tr>
        `;
		html += content;
	});
	tableBody.innerHTML = html;
};

window.onload = () => {
	if (selectHalaka) {
		fetch('http://localhost/php/Alssafrah/api/admin/allteachers.php')
			.then((respones) => respones.json())
			.then((data) => {
				let html = ``;
				data.data.map((el) => {
					html += `
					<option value=${el.Alhalka_Number}>${el.Alhalka_Number}</option>
				`;
				});
				selectHalaka.innerHTML = html;
			});
	}

	if (user === 'addTeacher') {
		fetch('http://localhost/php/Alssafrah/api/admin/allteachers.php')
			.then((respones) => respones.json())
			.then((data) => {
				addTeacher(data.data);
			});
	}

	if (user === 'addParent') {
		fetch('http://localhost/php/Alssafrah/api/admin/allparents.php')
			.then((respones) => respones.json())
			.then((data) => {
				addParent(data.data);
			});
	}
	if (user === 'addStudent') {
		fetch('http://localhost/php/Alssafrah/api/admin/allstudents.php')
			.then((respones) => respones.json())
			.then((data) => {
				addStudent(data.data);
			});
	}
};
