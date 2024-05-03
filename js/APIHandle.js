// Use this function to make a request
// Pass the rest of the url and the from data and the method (POST or GET) as parameters

export const requestData = async (url, req) => {
	const response = await fetch(
		`http://localhost/php/Alssafrah/api/${url}`,
		req
	);

	return response.json();
};
