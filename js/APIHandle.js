export const requestData = (url, formData, method) => {
	fetch(`http://localhost/php/Alssafrah/api/${url}`, {
		method: method,
		body: formData ? formData : {},
	})
		.then((response) => {
			return response.json();
		})
		.then((data) => {
			console.log(data);
		})
		.catch((error) => {
			console.error('There was a problem with the fetch operation:', error);
		});
};
