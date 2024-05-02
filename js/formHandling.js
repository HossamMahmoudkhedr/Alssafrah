const form = document.querySelector('form');
const input = document.querySelectorAll('input');
const formData = new FormData();

input.forEach((el) => {
	el.onchange = () => {
		formData.append(el.name, el.value);
	};
});

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
