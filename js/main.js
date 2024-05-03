import { requestData } from './APIHandle.js';
import { addParent, addStudent, addTeacher, getUserType } from './addUsers.js';

// Selecting elements
const sidebar = document.querySelector('.sidebar');
const menu = document.querySelector('.menu');
const close = document.querySelector('.close');
const selectHalaka = document.querySelector('.select_halaka');

// Handle sidebar in small screens
const openSidebar = () => {
	sidebar.classList.add('show');
	document.body.style.overflowX = 'hidden';
};

// Handle sidebar in small screens
const closeSidebar = () => {
	sidebar.classList.remove('show');
	document.body.style.overflowX = 'unset';
};

menu.addEventListener('click', openSidebar);
close.addEventListener('click', closeSidebar);

// This function used to show all the users in the tables in the admin pges
export const getUsers = (addTeacher, addParent, addStudent) => {
	let user = getUserType();

	let url = '';
	let addingFunction;

	// We detect here the page where we are
	if (user === 'addTeacher') {
		url = 'admin/allteachers.php';
		addingFunction = addTeacher;
	} else if (user === 'addParent') {
		url = 'admin/allparents.php';
		addingFunction = addParent;
	} else if (user === 'addStudent') {
		url = 'admin/allstudents.php';
		addingFunction = addStudent;
	}

	requestData(url, { method: 'GET' }).then((data) => {
		addingFunction(data.data);
	});
};

window.onload = () => {
	// Getting all the available halakas from teacher api to add them to the dropdown in addStudent page
	if (selectHalaka) {
		requestData('admin/allteachers.php', { method: 'GET' }).then((data) => {
			let html = ``;
			data.data.map((el) => {
				html += `
					<option value=${el.Alhalka_Number}>${el.Alhalka_Number}</option>
				`;
			});
			selectHalaka.innerHTML = html;
		});
	}

	// Show all the users in the tabels when the window loaded
	getUsers(addTeacher, addParent, addStudent);
};
