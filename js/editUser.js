import { requestData } from './APIHandle.js';
import { getUserType } from './addUsers.js';

const tabelBody = document.querySelector('.table_body');
const inputs = document.querySelectorAll('input');
// http://localhost/php/Alssafrah/api/admin/getteacher.php?id=3
let url = '';
const user = getUserType();
const edit = (id) => {
	if (user === 'addTeacher') {
		url = `admin/getteacher.php?id=${id}`;
	} else if (user === 'addParent') {
		url = `admin/getparent.php?id=${id}`;
	} else if (user === 'addStudent') {
		url = `admin/getstudent.php?id=${id}`;
	}
	requestData(url, { method: 'GET' }).then((data) => {
		inputs.forEach((input) => {
			input.value = data.data[input.name];
		});
	});
};

const handleButtons = (e) => {
	const target = e.target;
	if (target && target.classList.contains('cursor-pointer')) {
		const stauts = target.getAttribute('id');
		const id = target.parentElement.parentElement.getAttribute('data-id');
		if (stauts === 'edit') {
			edit(id);
		} else if (stauts === 'trash') {
			console.log(id);
		}
	}
};

tabelBody.addEventListener('click', handleButtons);
