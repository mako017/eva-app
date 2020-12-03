export interface singleCourse {
	id: number;
	datum: string;
	raum: string;
	von: string;
	bis: string;
	sitzung: string;
	dozent: string;
}

export interface courseContainer {
	lsf: number;
	titel: string;
	singleCourses: Array<singleCourse>;
}

export interface dbCourse {
	Counter: number;
	lsf: number;
	titel: string;
	sitzung: string;
	dozent: string;
	datum: string;
	raum: string;
	von: string;
	bis: string;
}
