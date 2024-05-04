import { requestData } from './APIHandle.js';

// http://localhost/php/Alssafrah/api/teacher/allstudents.php
const studentsListContainer = document.getElementById('studentsList');

window.onload = () => {
	let type = window.localStorage.getItem('type');
	requestData(
		`${type}/${type === 'teacher' ? 'allstudnets' : 'parentchilds'}.php`
	).then((data) => {
		const studnets = data.data;
		let html = '';
		studnets.map((studnet) => {
			html += `
                <div class="student_bar flex-lg-row flex-column gap-2 gap-lg-0">
					<p class="mb-0 px-5">${studnet.name}</p>
					<a
						href="./evaluationBoard.html"
						class="px-5 rounded-3"
						>التقييم</a
					>
					<div class="d-flex align-items-center gap-3 px-5 rounded-3">
						<label>الحضور</label>
						<input type="checkbox" name='attend' ${
							type === 'parent' && studnet.attend ? 'checked' : ''
						} />
					</div>
				</div>
            `;
		});
		studentsListContainer.innerHTML = html;
	});
};
