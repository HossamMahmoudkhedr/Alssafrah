import { requestData } from './APIHandle.js';

const sidebar = document.querySelector('.sidebar');
const menu = document.querySelector('.menu');
const close = document.querySelector('.close');
const username = document.getElementById('username');
const logOut = document.getElementById('logOut');

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

const getUserName = () => {
	const type = window.localStorage.getItem('type');
	requestData(`${type}/${type}data.php`, { method: 'GET' }).then((data) => {
		const name = data.data.name;
		username.innerText = name;
	});
};

const logUserOut = () => {
	requestData('logout.php').then((data) => {
		window.localStorage.clear();
	});
};

window.addEventListener('DOMContentLoaded', getUserName);
logOut.addEventListener('click', logUserOut);
