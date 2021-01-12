export interface singleCourse {
	id: number;
	datum: string;
	raum: string;
	von: string;
	bis: string;
	sitzung: string;
	dozent: string;
	liveFB: boolean;
	optLink: string;
}

export interface singleVote {
	datum: string;
	zeit: string;
	wertung: number;
	session: number;
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
	liveFB: boolean;
	optLink: string;
}

export interface changes {
	changeID: number;
	create: Array<dbCourse>;
	update: Array<dbCourse>;
	remove: Array<dbCourse>;
}
