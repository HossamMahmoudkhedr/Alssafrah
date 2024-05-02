// const sidebar = document.querySelector('.sidebar');
// const menu = document.querySelector('.menu');
// const close = document.querySelector('.close');
const email = document.querySelector('#email');
const password = document.querySelector('#password');
const form = document.querySelector('form');
const formData = new FormData();
const button = document.querySelector('button');

// const openSidebar = () => {
//     sidebar.classList.add('show');
// };

// const closeSidebar = () => {
//     sidebar.classList.remove('show');
// };

// menu.addEventListener('click', openSidebar);
// close.addEventListener('click', closeSidebar);

email.onchange = () => {
	formData.append(email.name, email.value);
};
password.onchange = () => {
	formData.append(password.name, password.value);
};

formData.append('type', 'admin');

form.addEventListener('submit', (e) => {
	e.preventDefault();
	fetch('http://localhost/php/Alssafrah/api/admin/addteacher.php', {
		method: 'POST',
		body: formData,
		headers: {
			'Content-Type': 'application/json',
		},
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.json(); // Assuming the response is JSON
		})
		.then((data) => {
			// Handle the response data
			console.log(data);
		})
		.catch((error) => {
			// Error handling
			console.error('There was a problem with the fetch operation:', error);
		});
});
