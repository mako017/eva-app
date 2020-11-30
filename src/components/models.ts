export interface singleCourse {
  datum: string;
  raum: string;
  von: string;
  bis: string;
  sitzung: string;
  dozent: string;
}

export interface courseContainer {
  id: number;
  lsf: number;
  titel: string;
  singleCourses: Array<singleCourse>;
}