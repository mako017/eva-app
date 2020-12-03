import axios from "axios";
import { singleCourse, courseContainer, dbCourse } from "@/components/models.ts";

function initSingleCourse(course: dbCourse): singleCourse {
	return {
		datum: course.datum,
		raum: course.raum,
		von: course.von,
		bis: course.bis,
		sitzung: course.sitzung,
		dozent: course.dozent,
	};
}

function initCourseContainer(course: dbCourse): courseContainer {
	return {
		id: course.Counter,
		lsf: course.lsf,
		titel: course.titel,
		singleCourses: [initSingleCourse(course)],
	};
}

export function saveCourses(courses: Array<courseContainer>) {
	axios
		.post(
			"./php/handle.php",
			JSON.stringify({
				call: "insertCourse",
				payload: courses,
			}),
		)
		.then(response => {
			console.log(response.data);
		})
		.catch(error => {
			console.log(error);
		});
}

async function requestCourses(): Promise<Array<dbCourse>> {
	let unsortedCourses: Array<dbCourse> = [];
	await axios
		.post(
			"./php/handle.php",
			JSON.stringify({
				call: "requestAllCourses",
			}),
		)
		.then(response => {
			unsortedCourses = response.data;
		})
		.catch(error => {
			console.log(error);
		});
	return unsortedCourses;
}

function sortCourses(courses: Array<dbCourse>) {
	const sortedArrays: Array<courseContainer> = [];
	courses.forEach(session => {
		if (sortedArrays.length === 0) {
			sortedArrays.push(initCourseContainer(session));
			console.log("Course created");
		} else {
			const index = sortedArrays.findIndex(el => el.lsf === session.lsf);
			if (index === -1) sortedArrays.push(initCourseContainer(session));
			else sortedArrays[index].singleCourses.push(initSingleCourse(session));
		}
	});

	return sortedArrays;
}

export async function getAllCourses(): Promise<Array<courseContainer>> {
	let allCourses: Array<courseContainer> = [];
	let dbCourses: Array<dbCourse> = [];
	await requestCourses().then(response => (dbCourses = response));
	allCourses = sortCourses(dbCourses);
	return allCourses;
}
