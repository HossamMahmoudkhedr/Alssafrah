import { requestData } from './APIHandle.js';
import { getUserType } from './addUsers.js';
import { mode, setMode } from './main.js';

const tabelBody = document.querySelector('.table_body');
const inputs = document.querySelectorAll('input');
const button = document.querySelector('button');
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

		button.innerText = 'تعديل';
		button.onclick = () => {
			console.log('clicked');
			setMode('insert');
			button.innerText = 'إضافة';
		};
	});
};

const handleButtons = (e) => {
	const target = e.target;
	if (target && target.classList.contains('cursor-pointer')) {
		const stauts = target.getAttribute('id');
		const id = target.parentElement.parentElement.getAttribute('data-id');
		if (stauts === 'edit') {
			setMode('edit');
			edit(id);
		} else if (stauts === 'trash') {
			console.log(id);
		}
	}
};

tabelBody.addEventListener('click', handleButtons);
