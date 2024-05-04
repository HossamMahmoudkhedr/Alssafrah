import { requestData } from './APIHandle.js';

const sidebar = document.querySelector('.sidebar');
const menu = document.querySelector('.menu');
const close = document.querySelector('.close');
const username = document.getElementById('username');

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

window.onload = () => {
	const type = window.localStorage.getItem('type');
	// http://localhost/php/Alssafrah/api/student/studentdata.php
	requestData(`${type}/${type}data.php`, { method: 'GET' }).then((data) => {
		const name = data.data.name;
		username.innerText = name;
	});
};

window.localStorage.removeItem('name');
window.localStorage.removeItem('id');
