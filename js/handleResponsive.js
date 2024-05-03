const sidebar = document.querySelector('.sidebar');
const menu = document.querySelector('.menu');
const close = document.querySelector('.close');

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
