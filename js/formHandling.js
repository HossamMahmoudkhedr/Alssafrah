const form = document.querySelector('form');
const input = document.querySelector('input');
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
