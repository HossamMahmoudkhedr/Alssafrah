// In this file you will find all the functions responsible for creating the rows in the tabels

// Select the body of the table
const tableBody = document.querySelector('.table_body');

export const addTeacher = (teachersArr) => {
	let html = ``;
	teachersArr.map((teacher) => {
		let content = `
            <tr>
				<th scope="row">${teacher.id}</th>
				<td>${teacher.name}</td>
				<td>${teacher.email}</td>
				<td>${teacher.password}</td>
				<td>${teacher.phone}</td>
				<td>${teacher.Alhalka_Number}</td>
				<td>
					<div class="d-flex gap-2 align-items-center" data-id='${teacher.id}'>
						<span class="position-relative " >
							<span class="cursor-pointer position-absolute start-0 top-0 w-100 h-100" style="zIndex:'2'" id="edit"></span>
							<svg width="33" height="29" viewBox="0 0 33 29" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="33" height="29" rx="3" fill="#84A966"/>
							<path d="M23.474 5.60677L27.3889 9.5217C27.5538 9.68663 27.5538 9.95573 27.3889 10.1207L17.9097 19.5998L13.8819 20.0469C13.3438 20.1076 12.888 19.6519 12.9488 19.1137L13.3958 15.0859L22.875 5.60677C23.0399 5.44184 23.309 5.44184 23.474 5.60677ZM30.5052 4.61285L28.3872 2.49479C27.7274 1.83507 26.6554 1.83507 25.9913 2.49479L24.4549 4.03125C24.2899 4.19618 24.2899 4.46528 24.4549 4.63021L28.3698 8.54514C28.5347 8.71007 28.8038 8.71007 28.9687 8.54514L30.5052 7.00868C31.1649 6.34462 31.1649 5.27257 30.5052 4.61285ZM22.6667 17.0217V21.4401H8.77778V7.55122H18.7517C18.8906 7.55122 19.0208 7.49479 19.1207 7.39931L20.8568 5.66319C21.1866 5.33333 20.9523 4.77344 20.4878 4.77344H8.08333C6.93316 4.77344 6 5.7066 6 6.85677V22.1345C6 23.2847 6.93316 24.2179 8.08333 24.2179H23.3611C24.5113 24.2179 25.4444 23.2847 25.4444 22.1345V15.2856C25.4444 14.8212 24.8845 14.5911 24.5547 14.9167L22.8186 16.6528C22.7231 16.7526 22.6667 16.8828 22.6667 17.0217Z" fill="white"/>
						</svg>

						</span>
						<span class="position-relative">
						<span class=" cursor-pointer position-absolute start-0 top-0 w-100 h-100" style="zIndex:'2'" id="trash"></span>
							<svg width="33" height="29" viewBox="0 0 33 29" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="33" height="29" rx="3" fill="#D34141"/>
								<path d="M8.35714 22.9375C8.35714 23.4845 8.57162 24.0091 8.95339 24.3959C9.33516 24.7827 9.85295 25 10.3929 25H22.6071C23.147 25 23.6648 24.7827 24.0466 24.3959C24.4284 24.0091 24.6429 23.4845 24.6429 22.9375V8.50001H8.35714V22.9375ZM19.8929 11.9375C19.8929 11.7552 19.9643 11.5803 20.0916 11.4514C20.2189 11.3224 20.3915 11.25 20.5714 11.25C20.7514 11.25 20.924 11.3224 21.0513 11.4514C21.1785 11.5803 21.25 11.7552 21.25 11.9375V21.5625C21.25 21.7448 21.1785 21.9197 21.0513 22.0486C20.924 22.1776 20.7514 22.25 20.5714 22.25C20.3915 22.25 20.2189 22.1776 20.0916 22.0486C19.9643 21.9197 19.8929 21.7448 19.8929 21.5625V11.9375ZM15.8214 11.9375C15.8214 11.7552 15.8929 11.5803 16.0202 11.4514C16.1474 11.3224 16.32 11.25 16.5 11.25C16.68 11.25 16.8526 11.3224 16.9798 11.4514C17.1071 11.5803 17.1786 11.7552 17.1786 11.9375V21.5625C17.1786 21.7448 17.1071 21.9197 16.9798 22.0486C16.8526 22.1776 16.68 22.25 16.5 22.25C16.32 22.25 16.1474 22.1776 16.0202 22.0486C15.8929 21.9197 15.8214 21.7448 15.8214 21.5625V11.9375ZM11.75 11.9375C11.75 11.7552 11.8215 11.5803 11.9487 11.4514C12.076 11.3224 12.2486 11.25 12.4286 11.25C12.6085 11.25 12.7811 11.3224 12.9084 11.4514C13.0357 11.5803 13.1071 11.7552 13.1071 11.9375V21.5625C13.1071 21.7448 13.0357 21.9197 12.9084 22.0486C12.7811 22.1776 12.6085 22.25 12.4286 22.25C12.2486 22.25 12.076 22.1776 11.9487 22.0486C11.8215 21.9197 11.75 21.7448 11.75 21.5625V11.9375ZM25.3214 4.37501H20.2321L19.8335 3.57149C19.749 3.39971 19.6189 3.25521 19.4579 3.15425C19.2968 3.05329 19.1111 2.99987 18.9217 3.00001H14.0741C13.8851 2.99927 13.6997 3.05249 13.5392 3.15356C13.3787 3.25464 13.2495 3.39948 13.1665 3.57149L12.7679 4.37501H7.67857C7.4986 4.37501 7.32601 4.44744 7.19875 4.57637C7.07149 4.7053 7 4.88017 7 5.06251V6.43751C7 6.61984 7.07149 6.79471 7.19875 6.92364C7.32601 7.05257 7.4986 7.12501 7.67857 7.12501H25.3214C25.5014 7.12501 25.674 7.05257 25.8013 6.92364C25.9285 6.79471 26 6.61984 26 6.43751V5.06251C26 4.88017 25.9285 4.7053 25.8013 4.57637C25.674 4.44744 25.5014 4.37501 25.3214 4.37501Z" fill="white"/>
							</svg>
						</span>
					</div>
				</td>
			</tr>
        `;
		html += content;
	});
	tableBody.innerHTML = html;
};

export const addParent = (parentArr) => {
	let html = ``;
	parentArr.map((parent) => {
		let content = `
            <tr>
				<th scope="row">${parent.id}</th>
				<td>${parent.name}</td>
				<td>${parent.phone}</td>
				<td>${parent.password}</td>
				<td>
					<div class="d-flex gap-2 align-items-center" data-id='${parent.id}'>
						<span class="position-relative " >
							<span class="cursor-pointer position-absolute start-0 top-0 w-100 h-100" style="zIndex:'2'" id="edit"></span>
							<svg width="33" height="29" viewBox="0 0 33 29" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="33" height="29" rx="3" fill="#84A966"/>
							<path d="M23.474 5.60677L27.3889 9.5217C27.5538 9.68663 27.5538 9.95573 27.3889 10.1207L17.9097 19.5998L13.8819 20.0469C13.3438 20.1076 12.888 19.6519 12.9488 19.1137L13.3958 15.0859L22.875 5.60677C23.0399 5.44184 23.309 5.44184 23.474 5.60677ZM30.5052 4.61285L28.3872 2.49479C27.7274 1.83507 26.6554 1.83507 25.9913 2.49479L24.4549 4.03125C24.2899 4.19618 24.2899 4.46528 24.4549 4.63021L28.3698 8.54514C28.5347 8.71007 28.8038 8.71007 28.9687 8.54514L30.5052 7.00868C31.1649 6.34462 31.1649 5.27257 30.5052 4.61285ZM22.6667 17.0217V21.4401H8.77778V7.55122H18.7517C18.8906 7.55122 19.0208 7.49479 19.1207 7.39931L20.8568 5.66319C21.1866 5.33333 20.9523 4.77344 20.4878 4.77344H8.08333C6.93316 4.77344 6 5.7066 6 6.85677V22.1345C6 23.2847 6.93316 24.2179 8.08333 24.2179H23.3611C24.5113 24.2179 25.4444 23.2847 25.4444 22.1345V15.2856C25.4444 14.8212 24.8845 14.5911 24.5547 14.9167L22.8186 16.6528C22.7231 16.7526 22.6667 16.8828 22.6667 17.0217Z" fill="white"/>
						</svg>

						</span>
						<span class="cursor-pointer" id="trash">
							<svg width="33" height="29" viewBox="0 0 33 29" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="33" height="29" rx="3" fill="#D34141"/>
								<path d="M8.35714 22.9375C8.35714 23.4845 8.57162 24.0091 8.95339 24.3959C9.33516 24.7827 9.85295 25 10.3929 25H22.6071C23.147 25 23.6648 24.7827 24.0466 24.3959C24.4284 24.0091 24.6429 23.4845 24.6429 22.9375V8.50001H8.35714V22.9375ZM19.8929 11.9375C19.8929 11.7552 19.9643 11.5803 20.0916 11.4514C20.2189 11.3224 20.3915 11.25 20.5714 11.25C20.7514 11.25 20.924 11.3224 21.0513 11.4514C21.1785 11.5803 21.25 11.7552 21.25 11.9375V21.5625C21.25 21.7448 21.1785 21.9197 21.0513 22.0486C20.924 22.1776 20.7514 22.25 20.5714 22.25C20.3915 22.25 20.2189 22.1776 20.0916 22.0486C19.9643 21.9197 19.8929 21.7448 19.8929 21.5625V11.9375ZM15.8214 11.9375C15.8214 11.7552 15.8929 11.5803 16.0202 11.4514C16.1474 11.3224 16.32 11.25 16.5 11.25C16.68 11.25 16.8526 11.3224 16.9798 11.4514C17.1071 11.5803 17.1786 11.7552 17.1786 11.9375V21.5625C17.1786 21.7448 17.1071 21.9197 16.9798 22.0486C16.8526 22.1776 16.68 22.25 16.5 22.25C16.32 22.25 16.1474 22.1776 16.0202 22.0486C15.8929 21.9197 15.8214 21.7448 15.8214 21.5625V11.9375ZM11.75 11.9375C11.75 11.7552 11.8215 11.5803 11.9487 11.4514C12.076 11.3224 12.2486 11.25 12.4286 11.25C12.6085 11.25 12.7811 11.3224 12.9084 11.4514C13.0357 11.5803 13.1071 11.7552 13.1071 11.9375V21.5625C13.1071 21.7448 13.0357 21.9197 12.9084 22.0486C12.7811 22.1776 12.6085 22.25 12.4286 22.25C12.2486 22.25 12.076 22.1776 11.9487 22.0486C11.8215 21.9197 11.75 21.7448 11.75 21.5625V11.9375ZM25.3214 4.37501H20.2321L19.8335 3.57149C19.749 3.39971 19.6189 3.25521 19.4579 3.15425C19.2968 3.05329 19.1111 2.99987 18.9217 3.00001H14.0741C13.8851 2.99927 13.6997 3.05249 13.5392 3.15356C13.3787 3.25464 13.2495 3.39948 13.1665 3.57149L12.7679 4.37501H7.67857C7.4986 4.37501 7.32601 4.44744 7.19875 4.57637C7.07149 4.7053 7 4.88017 7 5.06251V6.43751C7 6.61984 7.07149 6.79471 7.19875 6.92364C7.32601 7.05257 7.4986 7.12501 7.67857 7.12501H25.3214C25.5014 7.12501 25.674 7.05257 25.8013 6.92364C25.9285 6.79471 26 6.61984 26 6.43751V5.06251C26 4.88017 25.9285 4.7053 25.8013 4.57637C25.674 4.44744 25.5014 4.37501 25.3214 4.37501Z" fill="white"/>
							</svg>
						</span>
					</div>
				</td>
			</tr>
        `;
		html += content;
	});
	tableBody.innerHTML = html;
};

export const addStudent = (studentArr) => {
	let html = ``;
	studentArr.map((student) => {
		let content = `
            <tr>
				<th scope="row">${student.id}</th>
				<td>${student.name}</td>
				<td>${student.ssn}</td>
				<td>${student.parent_phone}</td>
				<td>${student.Alhalka_Number}</td>
				<td>
					<div class="d-flex gap-2 align-items-center" data-id='${student.id}'>
						<span class="position-relative " >
							<span class="cursor-pointer position-absolute start-0 top-0 w-100 h-100" style="zIndex:'2'" id="edit"></span>
							<svg width="33" height="29" viewBox="0 0 33 29" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect width="33" height="29" rx="3" fill="#84A966"/>
							<path d="M23.474 5.60677L27.3889 9.5217C27.5538 9.68663 27.5538 9.95573 27.3889 10.1207L17.9097 19.5998L13.8819 20.0469C13.3438 20.1076 12.888 19.6519 12.9488 19.1137L13.3958 15.0859L22.875 5.60677C23.0399 5.44184 23.309 5.44184 23.474 5.60677ZM30.5052 4.61285L28.3872 2.49479C27.7274 1.83507 26.6554 1.83507 25.9913 2.49479L24.4549 4.03125C24.2899 4.19618 24.2899 4.46528 24.4549 4.63021L28.3698 8.54514C28.5347 8.71007 28.8038 8.71007 28.9687 8.54514L30.5052 7.00868C31.1649 6.34462 31.1649 5.27257 30.5052 4.61285ZM22.6667 17.0217V21.4401H8.77778V7.55122H18.7517C18.8906 7.55122 19.0208 7.49479 19.1207 7.39931L20.8568 5.66319C21.1866 5.33333 20.9523 4.77344 20.4878 4.77344H8.08333C6.93316 4.77344 6 5.7066 6 6.85677V22.1345C6 23.2847 6.93316 24.2179 8.08333 24.2179H23.3611C24.5113 24.2179 25.4444 23.2847 25.4444 22.1345V15.2856C25.4444 14.8212 24.8845 14.5911 24.5547 14.9167L22.8186 16.6528C22.7231 16.7526 22.6667 16.8828 22.6667 17.0217Z" fill="white"/>
						</svg>

						</span>
						<span class="cursor-pointer" id="trash">
							<svg width="33" height="29" viewBox="0 0 33 29" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="33" height="29" rx="3" fill="#D34141"/>
								<path d="M8.35714 22.9375C8.35714 23.4845 8.57162 24.0091 8.95339 24.3959C9.33516 24.7827 9.85295 25 10.3929 25H22.6071C23.147 25 23.6648 24.7827 24.0466 24.3959C24.4284 24.0091 24.6429 23.4845 24.6429 22.9375V8.50001H8.35714V22.9375ZM19.8929 11.9375C19.8929 11.7552 19.9643 11.5803 20.0916 11.4514C20.2189 11.3224 20.3915 11.25 20.5714 11.25C20.7514 11.25 20.924 11.3224 21.0513 11.4514C21.1785 11.5803 21.25 11.7552 21.25 11.9375V21.5625C21.25 21.7448 21.1785 21.9197 21.0513 22.0486C20.924 22.1776 20.7514 22.25 20.5714 22.25C20.3915 22.25 20.2189 22.1776 20.0916 22.0486C19.9643 21.9197 19.8929 21.7448 19.8929 21.5625V11.9375ZM15.8214 11.9375C15.8214 11.7552 15.8929 11.5803 16.0202 11.4514C16.1474 11.3224 16.32 11.25 16.5 11.25C16.68 11.25 16.8526 11.3224 16.9798 11.4514C17.1071 11.5803 17.1786 11.7552 17.1786 11.9375V21.5625C17.1786 21.7448 17.1071 21.9197 16.9798 22.0486C16.8526 22.1776 16.68 22.25 16.5 22.25C16.32 22.25 16.1474 22.1776 16.0202 22.0486C15.8929 21.9197 15.8214 21.7448 15.8214 21.5625V11.9375ZM11.75 11.9375C11.75 11.7552 11.8215 11.5803 11.9487 11.4514C12.076 11.3224 12.2486 11.25 12.4286 11.25C12.6085 11.25 12.7811 11.3224 12.9084 11.4514C13.0357 11.5803 13.1071 11.7552 13.1071 11.9375V21.5625C13.1071 21.7448 13.0357 21.9197 12.9084 22.0486C12.7811 22.1776 12.6085 22.25 12.4286 22.25C12.2486 22.25 12.076 22.1776 11.9487 22.0486C11.8215 21.9197 11.75 21.7448 11.75 21.5625V11.9375ZM25.3214 4.37501H20.2321L19.8335 3.57149C19.749 3.39971 19.6189 3.25521 19.4579 3.15425C19.2968 3.05329 19.1111 2.99987 18.9217 3.00001H14.0741C13.8851 2.99927 13.6997 3.05249 13.5392 3.15356C13.3787 3.25464 13.2495 3.39948 13.1665 3.57149L12.7679 4.37501H7.67857C7.4986 4.37501 7.32601 4.44744 7.19875 4.57637C7.07149 4.7053 7 4.88017 7 5.06251V6.43751C7 6.61984 7.07149 6.79471 7.19875 6.92364C7.32601 7.05257 7.4986 7.12501 7.67857 7.12501H25.3214C25.5014 7.12501 25.674 7.05257 25.8013 6.92364C25.9285 6.79471 26 6.61984 26 6.43751V5.06251C26 4.88017 25.9285 4.7053 25.8013 4.57637C25.674 4.44744 25.5014 4.37501 25.3214 4.37501Z" fill="white"/>
							</svg>
						</span>
					</div>
				</td>
			</tr>
        `;
		html += content;
	});
	tableBody.innerHTML = html;
};

export const getUserType = () => {
	let href = window.location.toString();
	let arr = href.split('/');
	let user = arr[arr.length - 1].split('.')[0];
	return user;
};
