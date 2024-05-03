window.onload = () => {
	function getCookie(cookieName) {
		// Split all cookies into an array
		const cookies = document.cookie.split('; ');

		// Iterate through the array to find the desired cookie
		for (let i = 0; i < cookies.length; i++) {
			const cookie = cookies[i].split('=');
			// Trim any leading or trailing whitespace
			const name = cookie[0].trim();
			const value = cookie[1];

			// Check if the cookie name matches
			if (name === cookieName) {
				// Decode the cookie value to handle special characters
				return decodeURIComponent(value);
			}
		}

		// If the cookie is not found, return null
		return null;
	}

	// Example usage
	const myCookieValue = getCookie('loginName');
	if (myCookieValue !== 'admin') {
		console.log('no');
		window.history.back();
	} else {
		console.log('Cookie not found');
	}
};
