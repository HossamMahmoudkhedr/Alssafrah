import { requestData } from './APIHandle.js';
import { addParent, addStudent, addTeacher, getUserType } from './addUsers.js';
import { getUsers, mode, setMode } from './main.js';

const tabelBody = document.querySelector('.table_body');
const inputs = document.querySelectorAll('input');
const button = document.querySelector('button');
const selectHalaka = document.querySelector('.select_halaka');

let url = '';
let editUrl = '';
const user = getUserType();
const edit = (id) => {
	const formData = new FormData();
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
	requestData(url, { method: 'GET' }).then((data) => {
		inputs.forEach((input) => {
			input.value = data.data[input.name];
		});
		if (user === 'addStudent') {
			selectHalaka.value = data.data['alhalka_number'];
		}
		button.innerText = 'تعديل';

		button.onclick = () => {
			formData.append('id', id);
			inputs.forEach((input) => {
				formData.append(input.name, input.value);
			});
			if (user === 'addStudent') {
				formData.append(selectHalaka.name, selectHalaka.value);
			}
			requestData(editUrl, { method: 'POST', body: formData }).then((data) => {
				getUsers(addTeacher, addParent, addStudent);
				setMode('insert');
				inputs.forEach((input) => {
					input.value = '';
				});
				if (user === 'addStudent') {
					selectHalaka.value = '1';
				}
				button.innerText = 'إضافة';
			});
		};
	});
};

const remove = (id) => {
	if (user === 'addTeacher') {
		url = `admin/deleteteacher.php?id=${id}`;
	} else if (user === 'addParent') {
		url = `admin/deleteparent.php?id=${id}`;
	} else if (user === 'addStudent') {
		url = `admin/deletestudent.php?id=${id}`;
	}
	requestData(url, { method: 'GET' }).then((data) => {
		getUsers(addTeacher, addParent, addStudent);
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
			remove(id);
		}
	}
};

tabelBody.addEventListener('click', handleButtons);
