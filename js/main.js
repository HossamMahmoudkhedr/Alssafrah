// const sidebar = document.querySelector('.sidebar');
// const menu = document.querySelector('.menu');
// const close = document.querySelector('.close');
const email = document.querySelector('#email');
const password = document.querySelector('#password');
const form = document.querySelector('form');
const button = document.querySelector('button');
let data = { type: 'admin' };

// const openSidebar = () => {
// 	sidebar.classList.add('show');
// };

// const closeSidebar = () => {
// 	sidebar.classList.remove('show');
// };

// menu.addEventListener('click', openSidebar);
// close.addEventListener('click', closeSidebar);

email.onchange = () => {
	data = { ...data, [email.name]: email.value };
};
password.onchange = () => {
	data = { ...data, [password.name]: password.value };
};

button.onclick = async (e) => {
	e.preventDefault();
	const response = await fetch(
		'http://localhost/php/Alssafrah/api/admin/adminlogin.php',
		{
			method: 'POST',
			mode: 'cors',
			cache: 'no-cache',
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/json',
			},
			redirect: 'follow',
			referrerPolicy: 'no-referrer',
			body: JSON.stringify(data),
		}
	).catch((error) => {
		console.log(error);
	});
	console.log('clicked');
	return response.json();
};
