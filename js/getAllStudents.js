import { requestData } from './APIHandle.js';

// http://localhost/php/Alssafrah/api/teacher/allstudents.php
const studentsListContainer = document.getElementById('studentsList');

window.onload = () => {
	let type = window.localStorage.getItem('type');
	requestData(
		`${type}/${type === 'teacher' ? 'allstudents' : 'parentchilds'}.php`
	).then((data) => {
		const studnets = data.data;
		let html = '';
		studnets.map((studnet) => {
			html += `
                <div class="student_bar flex-lg-row flex-column gap-2 gap-lg-0">
					<p class="mb-0 px-5">${studnet.name}</p>
					<a
						href="${
							type === 'teacher'
								? './evaluationBoard.html'
								: './studentResults.html'
						}"
                        data-id="${studnet.id}"
						class="px-5 rounded-3 evaluation"
						>التقييم</a
					>
                    ${
											type === 'teacher'
												? `
					<div class="d-flex align-items-center gap-3 px-5 rounded-3">
						<label>الحضور</label>
						<input type="checkbox" name='attend' data-id="${studnet.id}" ${
														studnet.attend ? 'checked' : ''
												  } hidden />
                        <div
								class="checkbox_replacement position-relative ${studnet.attend ? 'show' : ''}"
                                style="width:25px !important; height:23px !important; padding:0"
								data-id="${studnet.id}">
                                <span data-id="${
																	studnet.id
																}" class='d-block handleAttend position-absolute w-100 h-100 start-0 end-0' style="zIndex:2"></span>
								<span class=" ${studnet.attend ? 'show' : ''}">
									<svg
										width="17"
										height="13"
										viewBox="0 0 17 13"
										fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path
											d="M5.77395 12.4281L0.248949 6.90313C-0.082983 6.57119 -0.082983 6.033 0.248949 5.70104L1.451 4.49895C1.78293 4.16699 2.32116 4.16699 2.65309 4.49895L6.375 8.22083L14.3469 0.248949C14.6788 -0.082983 15.2171 -0.082983 15.549 0.248949L16.7511 1.45104C17.083 1.78297 17.083 2.32116 16.7511 2.65312L6.97604 12.4282C6.64408 12.7601 6.10589 12.7601 5.77395 12.4281Z"
											fill="white" />
									</svg>
								</span>
							</div>
					</div>
                    `
												: ''
										}
				</div>
            `;
		});
		studentsListContainer.innerHTML = html;
	});
};

const handleCheckboxes = (target, id) => {
	const checkboxs = document.querySelectorAll('input[type="checkbox"]');
	const replacements = document.querySelectorAll('.checkbox_replacement');

	replacements.forEach((replacement) => {
		checkboxs.forEach((checkbox) => {
			if (
				replacement.getAttribute('data-id') ===
					target.getAttribute('data-id') &&
				replacement.getAttribute('data-id') === checkbox.getAttribute('data-id')
			) {
				checkbox.click();
				replacement.classList.toggle('show');
				replacement.children[0].classList.toggle('show');
				replacement.children[1].classList.toggle('show');
				requestData(`teacher/attend.php?id=${id}`).then((data) => {
					window.location.reload();
				});
			}
		});
	});
};

studentsListContainer.onclick = (e) => {
	const target = e.target;
	if (target.classList.contains('evaluation')) {
		window.localStorage.setItem('studentId', target.getAttribute('data-id'));
	}
	if (target.classList.contains('handleAttend')) {
		handleCheckboxes(target, target.getAttribute('data-id'));
	}
};
