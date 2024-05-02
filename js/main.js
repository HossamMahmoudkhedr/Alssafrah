const sidebar = document.querySelector('.sidebar');
const menu = document.querySelector('.menu');
const close = document.querySelector('.close');

const openSidebar = () => {
	sidebar.classList.add('show');
};

const closeSidebar = () => {
	sidebar.classList.remove('show');
};

menu.addEventListener('click', openSidebar);
close.addEventListener('click', closeSidebar);
