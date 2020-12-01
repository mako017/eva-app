import axios from "axios";
import { courseContainer } from "@/components/models.ts";

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