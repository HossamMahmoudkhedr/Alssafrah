// In this file you will find all the functions responsible for creating the rows in the tabels

// Select the body of the table
const tableBody = document.querySelector('.table_body');

export const addTeacher = (teachersArr) => {
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

export const addParent = (parentArr) => {
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

export const addStudent = (studentArr) => {
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

export const getUserType = () => {
	let href = window.location.toString();
	let arr = href.split('/');
	let user = arr[arr.length - 1].split('.')[0];
	return user;
};
