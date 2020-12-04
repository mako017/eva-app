import axios from "axios";
import { singleCourse, courseContainer, dbCourse, changes } from "@/components/models.ts";

function initSingleCourse(course: dbCourse): singleCourse {
	return {
		id: course.Counter,
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
		lsf: course.lsf,
		titel: course.titel,
		singleCourses: [initSingleCourse(course)],
	};
}

export function initdbCourse(courseContainer: courseContainer, session: singleCourse) {
	return {
		Counter: session.id,
		lsf: courseContainer.lsf,
		titel: courseContainer.titel,
		sitzung: session.sitzung,
		dozent: session.dozent,
		datum: session.datum,
		raum: session.raum,
		von: session.von,
		bis: session.bis,
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

export function highestID(courses: Array<courseContainer>) {
	let hID = 0;
	courses.forEach(element => {
		element.singleCourses.forEach(sess => {
			if (sess.id > hID) hID = sess.id;
		});
	});
	return hID;
}
/**
 * This function makes sure that newly created courses are prepared for being sent to the server.
 * @param changes The changes object that contains all sessions that need to be changed in the database
 * @param id The unique id of a change
 * @param dbCourse The course information that is to be updated
 */
function createChange(changes: changes, id: number, dbCourse: dbCourse): void {
	changes.create.push({ id, dbCourse });
}
/**
 * This function makes sure that deletions are prepared for being sent to the server if the course was not created in this session.
 * @param changes The changes object that contains all sessions that need to be changed in the database
 * @param id The unique id of a change
 * @param dbCourse The course information that is to be updated
 */
function removeChange(changes: changes, id: number, dbCourse: dbCourse): void {
	const isCreated = changes.create.findIndex(sess => sess.id === id);
	const isChanged = changes.update.findIndex(sess => sess.id === id);

	if (isCreated !== -1) {
		changes.create.splice(isCreated, 1);
		return;
	}
	if (isChanged !== -1) {
		changes.update.splice(isCreated, 1);
		changes.remove.push({ id, dbCourse });
	}
}
/**
 * This function makes sure that deletions are prepared for being sent to the server if the course was not created in this session.
 * @param changes The changes object that contains all sessions that need to be changed in the database
 * @param id The unique id of a change
 * @param dbCourse The course information that is to be updated
 */
function updateChange(changes: changes, id: number, dbCourse: dbCourse): void {
	const isCreated = changes.create.findIndex(sess => sess.id === id);

	if (isCreated !== -1) {
		changes.create[isCreated].dbCourse = dbCourse;
		return;
	} else changes.update.push({ id, dbCourse });
}
/**
 * A wrapper function to handle CRD operations
 * @param changes The changes object that contains all session that need to be changed in the database
 * @param id The unique id of a change
 * @param dbCourse The course information that is to be updated
 * @param type The type of change that needs to be applied to the database. Either create, update, or remove an entry
 */
export function handleChange(changes: changes, dbCourse: dbCourse, type: "create" | "update" | "remove"): void {
	switch (type) {
		case "create":
			createChange(changes, changes.changeID, dbCourse);
			break;
		case "update":
			updateChange(changes, dbCourse.Counter, dbCourse);
			break;
		case "remove":
			removeChange(changes, dbCourse.Counter, dbCourse);
			break;
		default:
			console.log("Invalid call to handleChange()");
			break;
	}
}
