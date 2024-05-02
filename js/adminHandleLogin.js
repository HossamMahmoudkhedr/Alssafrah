const form = document.querySelector('form');
const email = document.querySelector('#email');
const password = document.querySelector('#password');
const formData = new FormData();

formData.append('type', 'admin');

email.onchange = () => {
	formData.append(email.name, email.value);
	console.log(formData);
};
password.onchange = () => {
	formData.append(password.name, password.value);
	console.log(formData);
};

form.addEventListener('submit', (e) => {
	e.preventDefault();
	fetch('http://localhost/php/Alssafrah/api/admin/adminlogin.php', {
		method: 'POST',
		body: formData,
	})
		.then((response) => {
			return response.json();
		})
		.then((data) => {
			console.log(data);
			window.location.href =
				'http://localhost/php/Alssafrah/pages/addTeacher.html';
		})
		.catch((error) => {
			console.error('There was a problem with the fetch operation:', error);
		});
});
